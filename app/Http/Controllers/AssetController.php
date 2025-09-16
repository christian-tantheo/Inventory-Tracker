<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = Asset::query();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $assets = $query->paginate(6);

        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id'    => 'required|string|max:255|unique:assets',
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'condition'   => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'status'      => 'required|string|max:255',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            if ($request->hasFile('attachment')) {
                $file = $request->file('attachment');
                $path = $file->store('attachments', 'public');
                $validated['attachment'] = $path;
            }

            Asset::create($validated);

            return redirect()->route('assets.index')->with('success', 'Asset created successfully.');
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Failed to create asset: ' . $e->getMessage());

            // Redirect back with an error message and the user's input
            return redirect()->back()
                ->with('error', 'There was a problem creating the asset. Please try again.')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\View\View
     */
    public function edit(Asset $asset)
    {
        return view('assets.edit', compact('asset'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'asset_id'    => 'required|string|max:255|unique:assets,asset_id,' . $asset->id,
            'name'        => 'required|string|max:255',
            'category'    => 'required|string|max:255',
            'condition'   => 'required|string|max:255',
            'assigned_to' => 'required|string|max:255',
            'purchase_date' => 'required|date',
            'status'      => 'required|string|max:255',
            'attachment'  => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            if ($request->hasFile('attachment')) {
                // Delete old file if it exists
                if ($asset->attachment) {
                    Storage::disk('public')->delete($asset->attachment);
                }

                $file = $request->file('attachment');
                $path = $file->store('attachments', 'public');
                $validated['attachment'] = $path;
            }

            $asset->update($validated);

            return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Failed to update asset: ' . $e->getMessage());

            // Redirect back with an error message and the user's input
            return redirect()->back()
                ->with('error', 'There was a problem updating the asset. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Asset $asset)
    {
        try {
            if ($asset->attachment) {
                Storage::disk('public')->delete($asset->attachment);
            }

            $asset->delete();

            return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
        } catch (Exception $e) {
            // Log the error for debugging purposes
            Log::error('Failed to delete asset: ' . $e->getMessage());

            // Redirect back to the index page with an error
            return redirect()->route('assets.index')
                ->with('error', 'There was a problem deleting the asset. It might be in use or another issue occurred.');
        }
    }
}
