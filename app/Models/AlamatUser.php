<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'namapenerima',
        'no_telepon',
        'alamat',
        'kecamatan_id',
        'kabupaten_id',
        'provinsi_id',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

