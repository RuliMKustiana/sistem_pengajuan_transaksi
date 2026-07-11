<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = ['submission_id', 'user_id', 'status', 'notes'];

    /**
     * Relasi balik ke data pengajuan utama
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Relasi ke data user atasan yang memberikan persetujuan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}