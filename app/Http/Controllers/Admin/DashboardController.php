<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Submission;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Logistics
        $activeStatuses = ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment'];
        $stats['active_orders'] = Submission::whereIn('status', $activeStatuses)->count();
        $stats['cards_in_production'] = Submission::where('status', 'in_production')->sum('total_cards');
        $stats['awaiting_label'] = Submission::where('status', 'awaiting_arrival')->count();
        $stats['ready_to_ship'] = Submission::where('status', 'awaiting_shipment')->count();

        // Revenue
        $currentMonth = Carbon::now()->startOfMonth();
        $currentWeek = Carbon::now()->startOfWeek();
        
        $stats['revenue_this_month'] = Submission::where('created_at', '>=', $currentMonth)
            ->whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->get()
            ->sum('total_cost');

        $stats['revenue_this_week'] = Submission::where('created_at', '>=', $currentWeek)
            ->whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->get()
            ->sum('total_cost');

        $totalRevenue = Submission::whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->get()
            ->sum('total_cost');
            
        $totalCards = Submission::whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->sum('total_cards');

        $totalOrders = Submission::whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])->count();

        $stats['avg_revenue_per_card'] = $totalCards > 0 ? $totalRevenue / $totalCards : 0;
        $stats['avg_revenue_per_order'] = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Operational
        $stats['total_cards_this_month'] = Submission::where('created_at', '>=', $currentMonth)
            ->sum('total_cards');

        // Avg Completion Time (Created -> Updated for 'shipped'/'completed')
        $completedOrders = Submission::whereIn('status', ['shipped', 'completed'])->get();
        $totalDuration = 0;
        $completedCount = 0;
        foreach ($completedOrders as $order) {
            $totalDuration += $order->created_at->diffInDays($order->updated_at);
            $completedCount++;
        }
        $stats['avg_completion_time'] = $completedCount > 0 ? round($totalDuration / $completedCount, 1) : 0;

        // Service Breakdown
        $totalServiceOrders = Submission::count();
        $serviceStats = Submission::select('service_level_id', DB::raw('count(*) as total'))
            ->groupBy('service_level_id')
            ->with('serviceLevel')
            ->get();
        
        $stats['service_breakdown'] = $serviceStats->map(function ($item) use ($totalServiceOrders) {
            return [
                'name' => $item->serviceLevel->name,
                'percentage' => $totalServiceOrders > 0 ? round(($item->total / $totalServiceOrders) * 100, 1) : 0
            ];
        });

        // Basic for table
        $stats['recent_submissions'] = Submission::with(['user', 'serviceLevel', 'cards', 'labelType'])
            ->latest()
            ->paginate(10, ['*'], 'recent_page');

        $filter = $request->input('revenue_filter', '12_months');
        $graphData = [];

        if ($filter === '30_days') {
            // Calculate daily revenue for last 30 days
            $endDate = Carbon::now()->endOfDay();
            $startDate = Carbon::now()->subDays(29)->startOfDay();

            $dailyRevenue = Submission::select(
                DB::raw('DATE(submissions.created_at) as date'),
                DB::raw('SUM(total_cards * service_levels.price_per_card) as revenue')
            )
            ->join('service_levels', 'submissions.service_level_id', '=', 'service_levels.id')
            ->whereIn('submissions.status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->whereBetween('submissions.created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

            $current = $startDate->copy();
            while ($current <= $endDate) {
                $dateStr = $current->format('Y-m-d');
                $revenue = $dailyRevenue->where('date', $dateStr)->first();

                $graphData[] = [
                    'label' => $current->format('d M'), // 28 Jan
                    'full_date' => $current->format('F j, Y'),
                    'revenue' => $revenue ? (float)$revenue->revenue : 0
                ];
                $current->addDay();
            }

            // Current revenue is just the last one
            $currentRevenue = end($graphData)['revenue'] ?? 0;
            
        } elseif ($filter === '12_weeks') {
            // Calculate weekly revenue for last 12 weeks
            $endDate = Carbon::now()->endOfWeek();
            $startDate = Carbon::now()->subWeeks(11)->startOfWeek();

            $weeklyRevenue = Submission::select(
                DB::raw('YEARWEEK(submissions.created_at, 1) as yearweek'),
                DB::raw('SUM(total_cards * service_levels.price_per_card) as revenue')
            )
            ->join('service_levels', 'submissions.service_level_id', '=', 'service_levels.id')
            ->whereIn('submissions.status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->whereBetween('submissions.created_at', [$startDate, $endDate])
            ->groupBy('yearweek')
            ->orderBy('yearweek', 'ASC')
            ->get();

            $current = $startDate->copy();
            while ($current <= $endDate) {
                $yearWeek = $current->isoFormat('GGGGWW'); // ISO Week format for YearWeek
                // YEARWEEK in MySQL default mode 1 returns YYYYWW (week starts Monday)
                // We'll match loosely or just query by range in loop if simple.
                // Better approach: Match strictly by start of week date in loop
                
                // Let's rely on standard Carbon week iteration
                $startOfWeek = $current->copy()->startOfWeek();
                $endOfWeek = $current->copy()->endOfWeek();
                
                $revenue = $weeklyRevenue->filter(function($item) use ($startOfWeek, $endOfWeek) {
                    // This is approximate matching if using YEARWEEK, let's just re-query or use collection filter if set is small
                    return true; 
                });
                // Re-querying inside loop for 12 items is fine and safer for date boundaries
                $weekRevenue = Submission::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                     ->whereIn('status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
                     ->with('serviceLevel')
                     ->get()
                     ->sum('total_cost');

                $graphData[] = [
                    'label' => 'W' . $current->week,
                    'full_date' => $startOfWeek->format('M d') . ' - ' . $endOfWeek->format('M d'),
                    'revenue' => $weekRevenue
                ];
                $current->addWeek();
            }

            // Current revenue is just the last one
            $currentRevenue = end($graphData)['revenue'] ?? 0;

        } else {
            // Default: Calculate monthly revenue for last 12 months
            $endDate = Carbon::now()->endOfMonth();
            $startDate = Carbon::now()->subMonths(11)->startOfMonth();

            $monthlyRevenue = Submission::select(
                DB::raw('YEAR(submissions.created_at) as year'),
                DB::raw('MONTH(submissions.created_at) as month'),
                DB::raw('SUM(total_cards * service_levels.price_per_card) as revenue')
            )
            ->join('service_levels', 'submissions.service_level_id', '=', 'service_levels.id')
            ->whereIn('submissions.status', ['awaiting_arrival', 'order_arrived', 'in_production', 'awaiting_shipment', 'shipped', 'completed'])
            ->whereBetween('submissions.created_at', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year', 'ASC')
            ->orderBy('month', 'ASC')
            ->get();

            $current = $startDate->copy();
            while ($current <= $endDate) {
                $year = $current->year;
                $month = $current->month;
                
                // Find revenue for this month
                $revenue = $monthlyRevenue->where('year', $year)->where('month', $month)->first();
                
                $graphData[] = [
                    'label' => $current->format('M'), // Jan, Feb
                    'year' => $year,
                    'full_date' => $current->format('F Y'),
                    'revenue' => $revenue ? (float)$revenue->revenue : 0
                ];
                
                $current->addMonth();
            }

            // Get current month revenue
            $currentMonthData = end($graphData);
            $currentRevenue = $currentMonthData ? $currentMonthData['revenue'] : 0;
        }
        
        // Add to stats
        $stats['monthly_revenue'] = $currentRevenue;
        $stats['revenue_graph_data'] = $graphData;
        $stats['active_filter'] = $filter;

        return view('admin.dashboard', compact('stats'));
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'All notifications marked as read.');
    }
}