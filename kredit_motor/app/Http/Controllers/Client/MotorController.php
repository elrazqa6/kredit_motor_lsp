<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Motor;
use App\Models\JenisMotor;
use Illuminate\Http\Request;

class MotorController extends Controller
{
    /**
     * Katalog motor — bisa diakses TANPA login.
     * Tidak memanggil Auth::user() agar tidak error.
     */
    public function index(Request $request)
    {
        $query = Motor::with('jenisMotor')->where('stok', '>', 0);

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_motor', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
            });
        }

        // Filter jenis motor
        if ($request->filled('jenis')) {
            $query->where('id_jenis_motor', $request->jenis);
        }

        $motors      = $query->orderBy('nama_motor')->paginate(12)->withQueryString();
        $jenisMotors = JenisMotor::orderBy('nama_jenis')->get();

        return view('client.katalog.index', compact('motors', 'jenisMotors'));
    }

    /**
     * Detail motor — bisa diakses TANPA login.
     */
    public function show($id)
    {
        $motor = Motor::with('jenisMotor')->findOrFail($id);

        return view('client.katalog.show', compact('motor'));
    }
}