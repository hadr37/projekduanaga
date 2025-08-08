<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * AdminLTE: URL ke halaman profil
     */
    public function getProfileUrlAttribute()
    {
        return route('profile'); // pastikan route profile ada
    }

    /**
     * AdminLTE: Deskripsi di bawah nama user
     */
    public function getUsermenuDescAttribute()
    {
        return ucfirst($this->role); // contoh: "Admin" atau "User"
    }

    /**
     * AdminLTE: Foto profil user
     */
    public function getUsermenuImageAttribute()
    {
        // Bisa ganti dengan path foto dari database kalau ada
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0D8ABC&color=fff';
    }
}
