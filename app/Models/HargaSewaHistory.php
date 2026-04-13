<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaSewaHistory extends Model
{
    protected $table = 'harga_sewa_histories';
    protected $fillable = ['fasilitas_id', 'harga_lama', 'harga_baru', 'persen_perubahan'];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'fasilitas_id');
    }
}
