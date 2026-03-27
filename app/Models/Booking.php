<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
        'stripe_session_id',
        'contact_email', 
        'contact_phone',
    ];

    // Relasi: Satu booking dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Satu booking terkait dengan satu Produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Satu booking bisa punya banyak peserta (BookingParticipant)
    public function participants()
    {
        return $this->hasMany(BookingParticipant::class);
    }

}