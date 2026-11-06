<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Buku\Http\Requests\BukuRequest;
use Modules\Buku\Models\Buku;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q'));

        $buku = Buku::query()
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($w) use ($keyword) {
                    $w->where('judul', 'like', "%{$keyword}%")
                      ->orWhere('penulis', 'like', "%{$keyword}%")
                      ->orWhere('penerbit', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('judul')
            ->paginate(10)
            ->withQueryString();

        return view('buku::index', compact('buku', 'keyword'));
    }

    public function create()
    {
        return view('buku::form');
    }

    public function store(BukuRequest $request)
    {
        Buku::create($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        return view('buku::form', compact('buku'));
    }

    public function update(BukuRequest $request, Buku $buku)
    {
        $buku->update($request->validated());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
