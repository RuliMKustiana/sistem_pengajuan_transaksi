<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'amount', 'fiscal_year'];

    /**
     * Relasi balik ke tabel categories
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}