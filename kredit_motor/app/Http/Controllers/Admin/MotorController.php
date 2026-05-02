<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\JenisMotor;

class MotorController extends Controller
{
    public function index(Request $request)
    {
        $query = Motor::with('jenisMotor');

        if ($request->search) {
            $query->where('nama_motor', 'like', '%' . $request->search . '%');
        }

        $motors = $query->paginate(10);
        $jenisMotor = JenisMotor::all();

        return view('admin.motor.index', compact('motors', 'jenisMotor'));
    }

    public function create()
    {
        $jenisMotor = JenisMotor::all();
        return view('admin.motor.create', compact('jenisMotor'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_motor' => 'required',
            'merk' => 'required',
            'jenis_id' => 'required',
            'harga_cash' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'warna' => 'required',
            'tahun_produksi' => 'required',
            'stok' => 'required|numeric',
            'foto1' => 'nullable|image'
        ]);

        if ($request->hasFile('foto1')) {
            $data['foto1'] = $request->file('foto1')->store('motor', 'public');
        }

        Motor::create($data);

        return redirect()->route('admin.motor.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $motor = Motor::findOrFail($id);
        $jenisMotor = JenisMotor::all();

        return view('admin.motor.edit', compact('motor', 'jenisMotor'));
    }

    public function update(Request $request, $id)
    {
        $motor = Motor::findOrFail($id);

        $data = $request->validate([
            'nama_motor' => 'required',
            'merk' => 'required',
            'jenis_id' => 'required',
            'harga_cash' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'warna' => 'required',
            'tahun_produksi' => 'required',
            'stok' => 'required|numeric',
            'foto1' => 'nullable|image'
        ]);

        if ($request->hasFile('foto1')) {
            $data['foto1'] = $request->file('foto1')->store('motor', 'public');
        }

        $motor->update($data);

        return redirect()->route('admin.motor.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        Motor::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}