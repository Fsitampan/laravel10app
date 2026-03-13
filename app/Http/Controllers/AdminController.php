<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $total       = InputAspirasi::count();
        $menunggu    = Aspirasi::where('status', 'menunggu')->count();
        $diproses    = Aspirasi::where('status', 'diproses')->count();
        $selesai     = Aspirasi::where('status', 'selesai')->count();
        $terbaru     = InputAspirasi::with(['kategori','aspirasi','siswa'])->latest('id_pelaporan')->take(8)->get();
        $perKategori = Kategori::withCount('inputaspirasi')->orderByDesc('inputaspirasi_count')->get();

        return view('admin.dashboard', compact('total','menunggu','diproses','selesai','terbaru','perKategori'));
    }

    // Daftar aspirasi dengan filter
    public function index(Request $request)
    {
        $query = InputAspirasi::with(['kategori','aspirasi','siswa']);

        if ($request->filled('tanggal'))     $query->whereDate('created_at', $request->tanggal);
        if ($request->filled('nama'))        $query->whereHas('siswa', fn($q) => $q->where('username','like','%'.$request->nama.'%'));
        if ($request->filled('id_kategori')) $query->where('id_kategori', $request->id_kategori);

        $aspirasis = $query->latest('id_pelaporan')->paginate(10)->withQueryString();
        $kategoris = Kategori::all();

        return view('admin.aspirasi.index', compact('aspirasis','kategoris'));
    }

    // Detail aspirasi
    public function show($id)
    {
        $input = InputAspirasi::with(['kategori','aspirasi','siswa'])->findOrFail($id);
        return view('admin.aspirasi.show', compact('input'));
    }

    // Simpan tanggapan, rating & status
    public function update(Request $request, $id)
    {
        $request->validate([
            'status'   => 'required|in:menunggu,diproses,selesai',
            'feedback' => 'nullable|string|max:50',
            'rating'   => 'nullable|integer|min:1|max:5',
        ]);

        Aspirasi::where('id_aspirasi', $id)->update($request->only('status','feedback','rating'));

        return redirect()->route('admin.aspirasi.index')->with('success', 'Tanggapan berhasil disimpan.');
    }
}