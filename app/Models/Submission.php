<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_number',
        'submission_date',
        'user_id',
        'category_id',
        'amount',
        'description',
        'attachment',
        'status'
    ];

    /**
     * Relasi balik ke tabel users (Setiap pengajuan dimiliki oleh satu orang Staff pengaju)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi balik ke tabel categories (Setiap pengajuan terikat pada satu Kategori tertentu)
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke riwayat pelacak persetujuan (Satu pengajuan bisa memiliki banyak catatan approval atasan)
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }
}