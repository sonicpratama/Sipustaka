<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Buku\Models\Buku;
use Modules\Peminjaman\Http\Requests\PeminjamanRequest;
use Modules\Peminjaman\Models\Peminjaman;

class PeminjamanController extends Controller
{
    /** Halaman utama (hanya kerangka; data dimuat via AJAX) */
    public function index()
    {
        $daftarBuku = Buku::orderBy('judul')->pluck('judul');

        return view('peminjaman::index', compact('daftarBuku'));
    }

    /** AJAX: daftar semua peminjaman */
    public function data()
    {
        return response()->json(Peminjaman::latest('id')->get());
    }

    /** AJAX: satu data (untuk form ubah) */
    public function show(Peminjaman $peminjaman)
    {
        return response()->json($peminjaman);
    }

    /** AJAX: tambah */
    public function store(PeminjamanRequest $request)
    {
        $data = $request->safe()->except('bukti');

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        Peminjaman::create($data);

        return response()->json(['message' => 'Data peminjaman berhasil ditambahkan.'], 201);
    }

    /** AJAX: ubah (berkas lama diganti jika ada berkas baru) */
    public function update(PeminjamanRequest $request, Peminjaman $peminjaman)
    {
        $data = $request->safe()->except('bukti');

        if ($request->hasFile('bukti')) {
            if ($peminjaman->bukti) {
                Storage::disk('public')->delete($peminjaman->bukti);
            }
            $data['bukti'] = $request->file('bukti')->store('bukti', 'public');
        }

        $peminjaman->update($data);

        return response()->json(['message' => 'Data peminjaman berhasil diubah.']);
    }

    /** AJAX: hapus (berkas ikut terhapus dari storage) */
    public function destroy(Peminjaman $peminjaman)
    {
        if ($peminjaman->bukti) {
            Storage::disk('public')->delete($peminjaman->bukti);
        }

        $peminjaman->delete();

        return response()->json(['message' => 'Data peminjaman berhasil dihapus.']);
    }
}
