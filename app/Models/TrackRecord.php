<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackRecord extends Model
{
    use HasFactory;

    protected $fillable = ['city_name', 'description', 'year', 'banner_image', 'slug'];

    public function items()
    {
        return $this->hasMany(TrackRecordItem::class);
    }
}
