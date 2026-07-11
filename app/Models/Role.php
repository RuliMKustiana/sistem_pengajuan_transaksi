<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Definisikan kolom yang boleh diisi secara massal
    protected $fillable = ['name'];

    /**
     * Relasi ke tabel users (Satu Role bisa dimiliki oleh banyak User)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}