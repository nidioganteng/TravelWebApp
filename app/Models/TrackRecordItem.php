<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRecordItem extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Relasi: Item ini milik satu Track Record induk
    public function trackRecord()
    {
        return $this->belongsTo(TrackRecord::class);
    }
}