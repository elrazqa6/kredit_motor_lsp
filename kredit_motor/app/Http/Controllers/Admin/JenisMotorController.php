<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisMotor;

class JenisMotorController extends Controller
{
 public function index(Request $request)
{
    $perPage = $request->get('per_page', 10);
    $jenisMotor = JenisMotor::orderBy('created_at', 'desc')->paginate($perPage);  // ← ganti $data jadi $jenisMotor
    
    return view('admin.jenis_motor.index', compact('jenisMotor'));  // ← compact('jenisMotor')
}

    public function create()
    {
        return view('admin.jenis_motor.create');
    }

 
public function store(Request $request)
{
    try {
        $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:jenis_motor',
            'keterangan' => 'nullable|string',
            'is_active' => 'nullable|in:on,off,0,1',  // ← validasi untuk checkbox
        ]);
        
        $jenisMotor = new JenisMotor();
        $jenisMotor->nama_jenis = $request->nama_jenis;
        $jenisMotor->keterangan = $request->keterangan;
        $jenisMotor->is_active = $request->has('is_active') ? 1 : 0;
        $jenisMotor->save();
        
        return redirect()->route('admin.jenis-motor.index')
            ->with('success', 'Jenis motor "' . $request->nama_jenis . '" berhasil ditambahkan!');
        
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal menambahkan: ' . $e->getMessage())
            ->withInput();
    }
}

    public function destroy($id)
    {
        $item = JenisMotor::findOrFail($id);
        
        // Cek apakah ada motor yang menggunakan jenis ini
        if ($item->motor()->count() > 0) {
            return redirect()->route('admin.jenis-motor.index')
                ->with('error', 'Jenis motor tidak dapat dihapus karena masih digunakan oleh data motor!');
        }
        
        $item->delete();
        
        return redirect()->route('admin.jenis-motor.index')
            ->with('success', 'Jenis motor berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $item = JenisMotor::findOrFail($id);
        $item->update(['is_active' => !$item->is_active]);
        
        return redirect()->back()->with('success', 'Status jenis motor berhasil diubah!');
    }
}