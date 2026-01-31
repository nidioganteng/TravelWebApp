<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRecord extends Model
{
    use HasFactory;

    // Agar bisa diisi massal
    protected $guarded = ['id'];

    // Relasi: Satu Track Record memiliki BANYAK Items
    public function items()
    {
        return $this->hasMany(TrackRecordItem::class);
    }
}