<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/client/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Redirect user after login based on role
     */
    protected function authenticated(Request $request, $user)
    {
        // Admin → dashboard admin
        if ($user->role == 'admin') {
            return redirect()->route('admin.dashboard');  // ← tanpa .index
        }
        
        // Marketing → dashboard marketing
        if ($user->role == 'marketing') {
            return redirect()->route('marketing.dashboard');  // ← tanpa .index
        }
        
        // CEO → dashboard ceo
        if ($user->role == 'ceo') {
            return redirect()->route('ceo.dashboard');  // ← tanpa .index
        }
        
        // Client → dashboard client
        return redirect()->route('client.dashboard');  // ← tanpa .index
    }
}