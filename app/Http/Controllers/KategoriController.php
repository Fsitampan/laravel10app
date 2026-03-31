<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori beserta form tambah.
     */
    public function index()
    {
        // Mengambil semua data kategori, diurutkan dari yang terbaru (opsional)
        $kategoris = Kategori::orderBy('id_kategori', 'desc')->get();
        
        // Pastikan path view di bawah ini sesuai dengan lokasi file index.blade.php milikmu
        return view('admin.kategori.index', compact('kategoris')); 
    }

    /**
     * Menyimpan data kategori baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'ket_kategori' => 'required|string|max:50|unique:kategori,ket_kategori',
        ], [
            'ket_kategori.required' => 'Nama kategori wajib diisi.',
            'ket_kategori.max' => 'Nama kategori tidak boleh lebih dari 50 karakter.',
            'ket_kategori.unique' => 'Nama kategori sudah ada, silakan gunakan nama lain.'
        ]);

        // Proses simpan ke database
        Kategori::create([
            'ket_kategori' => $request->ket_kategori,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Menghapus data kategori.
     */
    public function destroy($id_kategori)
    {
        // Mencari kategori berdasarkan id_kategori (Primary Key)
        $kategori = Kategori::findOrFail($id_kategori);
        
        // Hapus kategori
        $kategori->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}