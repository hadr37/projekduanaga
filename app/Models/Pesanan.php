<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'jenis_pembayaran',
        'bank',
        'no_rekening',
        'pesan',
        'alamat',
    ];

    public function details()
    {
        return $this->hasMany(PesananDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
