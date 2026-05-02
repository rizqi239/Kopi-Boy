<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice', 'user_id', 'total', 'payment_method', 'status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payments relation (multiple payments possible), and a single helper relation `payment`
     * is provided for convenience to match existing whereHas/whereDoesntHave calls.
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        // return latest payment if multiple exist
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
