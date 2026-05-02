<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisMotor;

class JenisMotorController extends Controller
{
    public function index()
    {
        $data = JenisMotor::all();
        return view('admin.jenis_motor.index', compact('data'));
    }

    public function create()
    {
        return view('admin.jenis_motor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required'
        ]);

        JenisMotor::create([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('admin.jenis-motor.index')
            ->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $item = JenisMotor::findOrFail($id);
        return view('admin.jenis_motor.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis' => 'required'
        ]);

        $item = JenisMotor::findOrFail($id);
        $item->update([
            'jenis' => $request->jenis
        ]);

        return redirect()->route('admin.jenis-motor.index')
            ->with('success', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        JenisMotor::destroy($id);
        return back()->with('success', 'Data berhasil dihapus');
    }
}