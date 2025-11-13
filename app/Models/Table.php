<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

      protected $fillable = [
        'table_number',
        'capacity',
        'status',
        'notes'
    ];

    protected $casts = [
        'capacity' => 'integer',
    ];

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'available' => 'success',
            'occupied' => 'danger',
            'reserved' => 'warning',
            'maintenance' => 'secondary',
            default => 'secondary'
        };
    }

    // Get status icon
    public function getStatusIconAttribute()
    {
        return match($this->status) {
            'available' => '✓',
            'occupied' => '●',
            'reserved' => '◷',
            'maintenance' => '⚠',
            default => '?'
        };
    }
}
