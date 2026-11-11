<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRecordItem extends Model
{
    use HasFactory;

    protected $fillable = ['track_record_id', 'title', 'description', 'image'];

    public function trackRecord()
    {
        return $this->belongsTo(TrackRecord::class);
    }
}
