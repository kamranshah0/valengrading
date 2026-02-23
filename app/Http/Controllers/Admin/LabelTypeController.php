<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LabelType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabelTypeController extends Controller
{
    public function index(): View
    {
        $labelTypes = LabelType::orderBy('order')->get();

        return view('admin.label-types.index', compact('labelTypes'));
    }

    public function create(): View
    {
        return view('admin.label-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'price_adjustment' => 'required|numeric|min:0',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'features' => 'nullable|string',
        ]);

        // Convert string to boolean
        $validated['is_active'] = (bool) $validated['is_active'];

        // Handle Features
        $features = [];
        if (!empty($validated['features'])) {
            $features = array_filter(array_map('trim', explode("\n", $validated['features'])));
        }
        $validated['features'] = $features;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('labels', 'public');
            $validated['image_path'] = $imagePath;
        }

        LabelType::create($validated);

        return redirect()
            ->route('admin.label-types.index')
            ->with('success', 'Label Type created successfully.');
    }

    public function edit(LabelType $labelType): View
    {
        return view('admin.label-types.edit', compact('labelType'));
    }

    public function update(Request $request, LabelType $labelType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'price_adjustment' => 'required|numeric|min:0',
            'order' => 'required|integer',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'features' => 'nullable|string',
        ]);

        // Convert string to boolean
        $validated['is_active'] = (bool) $validated['is_active'];

        // Handle Features
        $features = [];
        if (!empty($validated['features'])) {
            $features = array_filter(array_map('trim', explode("\n", $validated['features'])));
        }
        $validated['features'] = $features;

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Optionally delete old image
            if ($labelType->image_path && \Storage::disk('public')->exists($labelType->image_path)) {
                \Storage::disk('public')->delete($labelType->image_path);
            }
            
            $imagePath = $request->file('image')->store('labels', 'public');
            $validated['image_path'] = $imagePath;
        }

        $labelType->update($validated);

        return redirect()
            ->route('admin.label-types.index')
            ->with('success', 'Label Type updated successfully.');
    }

    public function destroy(LabelType $labelType): RedirectResponse
    {
        $labelType->delete();

        return redirect()
            ->route('admin.label-types.index')
            ->with('success', 'Label Type deleted successfully.');
    }
}
