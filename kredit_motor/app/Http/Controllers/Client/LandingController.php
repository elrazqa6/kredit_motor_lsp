<?php

namespace App\Http\Controllers;

use App\Models\Motor;

class LandingController extends Controller
{
    public function index()
    {
        $motors = Motor::latest()->take(6)->get();
        return view('landing', compact('motors'));
    }
}