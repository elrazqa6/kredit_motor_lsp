<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroController extends Controller
{
    public function index()
    {
        $hero = Hero::orderBy('urutan', 'asc')->get();
        return view('admin.hero.index', compact('hero'));
    }
    
    public function create()
    {
        return view('admin.hero.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'sub_judul' => 'nullable|string|max:500',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tombol_teks' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);
        
        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_hero_' . $file->getClientOriginalName();
            $path = $file->storeAs('hero', $filename, 'public');
            $data['gambar'] = $path;
        }
        
        Hero::create($data);
        
        return redirect()->route('admin.hero.index')
            ->with('success', 'Banner hero berhasil ditambahkan!');
    }
    
    public function edit($id)
    {
        $hero = Hero::findOrFail($id);
        return view('admin.hero.edit', compact('hero'));
    }
    
    public function update(Request $request, $id)
    {
        $hero = Hero::findOrFail($id);
        
        $request->validate([
            'judul' => 'nullable|string|max:255',
            'sub_judul' => 'nullable|string|max:500',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'tombol_teks' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'urutan' => 'nullable|integer',
        ]);
        
        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
                Storage::disk('public')->delete($hero->gambar);
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_hero_' . $file->getClientOriginalName();
            $path = $file->storeAs('hero', $filename, 'public');
            $data['gambar'] = $path;
        }
        
        $hero->update($data);
        
        return redirect()->route('admin.hero.index')
            ->with('success', 'Banner hero berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        $hero = Hero::findOrFail($id);
        
        if ($hero->gambar && Storage::disk('public')->exists($hero->gambar)) {
            Storage::disk('public')->delete($hero->gambar);
        }
        
        $hero->delete();
        
        return redirect()->route('admin.hero.index')
            ->with('success', 'Banner hero berhasil dihapus!');
    }
    
    public function toggleStatus($id)
    {
        $hero = Hero::findOrFail($id);
        $hero->update(['is_active' => !$hero->is_active]);
        
        return redirect()->back()
            ->with('success', 'Status banner berhasil diubah!');
    }
}