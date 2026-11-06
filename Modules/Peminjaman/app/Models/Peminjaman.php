<?php

namespace Modules\Peminjaman\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'nama_peminjam',
        'judul_buku',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'bukti',
    ];

    protected $appends = ['bukti_url'];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam'  => 'date:Y-m-d',
            'tanggal_kembali' => 'date:Y-m-d',
        ];
    }

    protected function buktiUrl(): Attribute
    {
        return Attribute::get(fn () => $this->bukti ? asset('storage/' . $this->bukti) : null);
    }
}
