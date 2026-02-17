<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComparisonFeature;
use Illuminate\Http\Request;

class ComparisonFeatureController extends Controller
{
    public function index()
    {
        $features = ComparisonFeature::orderBy('order')->get();
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $validated['is_standard'] = $request->has('is_standard');
        $validated['is_express'] = $request->has('is_express');
        $validated['is_elite'] = $request->has('is_elite');

        ComparisonFeature::create($validated);

        return redirect()->route('admin.features.index')->with('success', 'Feature created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $feature = ComparisonFeature::findOrFail($id);
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, string $id)
    {
        $feature = ComparisonFeature::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $validated['is_standard'] = $request->has('is_standard');
        $validated['is_express'] = $request->has('is_express');
        $validated['is_elite'] = $request->has('is_elite');

        $feature->update($validated);

        return redirect()->route('admin.features.index')->with('success', 'Feature updated successfully.');
    }

    public function destroy(string $id)
    {
        $feature = ComparisonFeature::findOrFail($id);
        $feature->delete();
        return redirect()->route('admin.features.index')->with('success', 'Feature deleted successfully.');
    }
}
