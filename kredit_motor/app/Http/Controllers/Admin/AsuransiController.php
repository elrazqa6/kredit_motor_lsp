<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asuransi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsuransiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $asuransi = Asuransi::orderBy('id', 'desc')->paginate($perPage);
        
        return view('admin.asuransi.index', compact('asuransi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.asuransi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_asuransi' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'margin_asuransi' => 'required|numeric|min:0|max:100',
            'no_rekening' => 'nullable|string|max:100',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->except('url_logo');
        
        // Upload logo
        if ($request->hasFile('url_logo')) {
            $logoPath = $request->file('url_logo')->store('asuransi', 'public');
            $data['url_logo'] = $logoPath;
        }

        Asuransi::create($data);

        return redirect()->route('admin.asuransi.index')
            ->with('success', 'Asuransi berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        return view('admin.asuransi.edit', compact('asuransi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $asuransi = Asuransi::findOrFail($id);
        
        $request->validate([
            'nama_asuransi' => 'required|string|max:255',
            'nama_perusahaan' => 'required|string|max:255',
            'biaya' => 'required|numeric|min:0',
            'margin_asuransi' => 'required|numeric|min:0|max:100',
            'no_rekening' => 'nullable|string|max:100',
            'url_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $data = $request->except('url_logo');
        
        // Upload new logo
        if ($request->hasFile('url_logo')) {
            // Delete old logo
            if ($asuransi->url_logo && Storage::disk('public')->exists($asuransi->url_logo)) {
                Storage::disk('public')->delete($asuransi->url_logo);
            }
            
            $logoPath = $request->file('url_logo')->store('asuransi', 'public');
            $data['url_logo'] = $logoPath;
        }

        $asuransi->update($data);

        return redirect()->route('admin.asuransi.index')
            ->with('success', 'Asuransi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asuransi = Asuransi::findOrFail($id);
        
        // Delete logo file
        if ($asuransi->url_logo && Storage::disk('public')->exists($asuransi->url_logo)) {
            Storage::disk('public')->delete($asuransi->url_logo);
        }
        
        $asuransi->delete();

        return redirect()->route('admin.asuransi.index')
            ->with('success', 'Asuransi berhasil dihapus!');
    }
}