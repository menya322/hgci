<?php

namespace App\Models;

use Database\Factories\DonationPledgeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationPledge extends Model
{
    /** @use HasFactory<DonationPledgeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'amount',
        'currency',
        'frequency',
        'method',
        'message',
        'consent',
        'status',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'consent' => 'boolean',
            'read_at' => 'datetime',
        ];
    }
}
