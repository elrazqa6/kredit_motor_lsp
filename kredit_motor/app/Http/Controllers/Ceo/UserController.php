<?php

namespace App\Http\Controllers\Ceo;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $users = User::orderBy('created_at', 'desc')->paginate($perPage);
        
        return view('ceo.users.index', compact('users'));
    }
    
    public function create()
    {
        return view('ceo.users.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,marketing,ceo,client',
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        
        return redirect()->route('ceo.users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('ceo.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,marketing,ceo,client',
        ]);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        return redirect()->route('ceo.users.index')
            ->with('success', 'User berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah menghapus diri sendiri
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }
        
        $user->delete();
        
        return redirect()->route('ceo.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}