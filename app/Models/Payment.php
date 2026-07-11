<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'user_id', 'payment_date'];

    /**
     * Relasi balik ke data pengajuan utama yang dibayarkan
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Relasi ke data user (tim Finance) yang memproses pembayaran ini
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}