<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    private function nis() { return Auth::guard('siswa')->user()->nis; }

    public function dashboard()
    {
        $nis  = $this->nis();
        $ids  = InputAspirasi::where('nis', $nis)->pluck('id_pelaporan');

        $total    = $ids->count();
        $menunggu = Aspirasi::whereIn('id_aspirasi', $ids)->where('status', 'menunggu')->count();
        $diproses = Aspirasi::whereIn('id_aspirasi', $ids)->where('status', 'diproses')->count();
        $selesai  = Aspirasi::whereIn('id_aspirasi', $ids)->where('status', 'selesai')->count();

        $aktif = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('nis', $nis)
            ->join('aspirasi', 'aspirasi.id_aspirasi', '=', 'input_aspirasi.id_pelaporan')
            ->whereIn('aspirasi.status', ['menunggu', 'diproses'])
            ->select('input_aspirasi.*')
            ->orderByDesc('input_aspirasi.id_pelaporan')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact('total', 'menunggu', 'diproses', 'selesai', 'aktif'));
    }

    public function create()
    {
        return view('siswa.input_aspirasi', ['kategoris' => Kategori::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'lokasi'      => 'required|string|max:50',
            'keterangan'  => 'required|string|max:50',
        ]);

        $input = InputAspirasi::create(array_merge($data, ['nis' => $this->nis()]));

        Aspirasi::create([
            'id_aspirasi' => $input->id_pelaporan,
            'id_kategori' => $data['id_kategori'],
            'status'      => 'menunggu',
        ]);

        return redirect()->route('siswa.status')->with('success', 'Aspirasi berhasil dikirim.');
    }

    public function status()
    {
        $aspirasis = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('input_aspirasi.nis', $this->nis())
            ->join('aspirasi', 'aspirasi.id_aspirasi', '=', 'input_aspirasi.id_pelaporan')
            ->whereIn('aspirasi.status', ['menunggu', 'diproses'])
            ->select('input_aspirasi.*')
            ->orderByDesc('input_aspirasi.id_pelaporan')
            ->get();

        return view('siswa.status', compact('aspirasis'));
    }

    public function histori()
    {
        $historis = InputAspirasi::with(['kategori', 'aspirasi'])
            ->where('input_aspirasi.nis', $this->nis())
            ->join('aspirasi', 'aspirasi.id_aspirasi', '=', 'input_aspirasi.id_pelaporan')
            ->where('aspirasi.status', 'selesai')
            ->select('input_aspirasi.*')
            ->orderByDesc('input_aspirasi.id_pelaporan')
            ->get();

        return view('siswa.histori', compact('historis'));
    }
}