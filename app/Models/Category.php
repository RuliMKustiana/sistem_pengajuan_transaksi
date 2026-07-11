<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi ke tabel submissions (Satu kategori bisa memiliki banyak pengajuan)
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Relasi ke tabel budgets (Satu kategori mengikat satu data budget limit)
     */
    public function budget()
    {
        return $this->hasOne(Budget::class);
    }
}