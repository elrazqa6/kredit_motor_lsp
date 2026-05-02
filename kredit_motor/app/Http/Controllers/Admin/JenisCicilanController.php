<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisCicilan;
use Illuminate\Http\Request;

class JenisCicilanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $jenisCicilan = JenisCicilan::orderBy('lama_cicilan', 'asc')->paginate($perPage);
        
        return view('admin.jenis_cicilan.index', compact('jenisCicilan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lama_cicilan' => 'required|integer|min:1|max:120|unique:jenis_cicilan,lama_cicilan',
            'margin_kredit' => 'required|numeric|min:0|max:100',
        ]);

        JenisCicilan::create([
            'lama_cicilan' => $request->lama_cicilan,
            'margin_kredit' => $request->margin_kredit,
        ]);

        return redirect()->route('admin.jenis-cicilan.index')
            ->with('success', 'Jenis cicilan berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jenisCicilan = JenisCicilan::findOrFail($id);
        
        $request->validate([
            'lama_cicilan' => 'required|integer|min:1|max:120|unique:jenis_cicilan,lama_cicilan,' . $id,
            'margin_kredit' => 'required|numeric|min:0|max:100',
        ]);

        $jenisCicilan->update([
            'lama_cicilan' => $request->lama_cicilan,
            'margin_kredit' => $request->margin_kredit,
        ]);

        return redirect()->route('admin.jenis-cicilan.index')
            ->with('success', 'Jenis cicilan berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $jenisCicilan = JenisCicilan::findOrFail($id);
        
        // Cek apakah jenis cicilan sedang digunakan di pengajuan
        if ($jenisCicilan->pengajuanKredit()->count() > 0) {
            return redirect()->route('admin.jenis-cicilan.index')
                ->with('error', 'Jenis cicilan tidak bisa dihapus karena sedang digunakan!');
        }
        
        $jenisCicilan->delete();

        return redirect()->route('admin.jenis-cicilan.index')
            ->with('success', 'Jenis cicilan berhasil dihapus!');
    }
}