<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'guest_type',
        'place',
        'waiter',
        'priority',
        'table_number',
        'pax',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
        'user_id',
        'completed_at',
    ];

  

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        $lastOrder = self::whereDate('created_at', today())->latest()->first();
        $number = $lastOrder ? intval(substr($lastOrder->order_number, 1)) + 1 : 1;
        return 'F' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals()
    {
        $this->subtotal = $this->items->sum(function ($item) {
            return $item->quantity * $item->price;
        });
        
        $this->tax = $this->subtotal * 0.06; // 6% tax
        $this->donation = 1.00; // Fixed donation
        $this->total = $this->subtotal + $this->tax + $this->donation;
        
        $this->save();
    }
}