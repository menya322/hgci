<?php

namespace App\Models;

use Database\Factories\SponsorshipEnquiryFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SponsorshipEnquiry extends Model
{
    /** @use HasFactory<SponsorshipEnquiryFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'preferred_child_age',
        'message',
        'consent',
        'status',
        'read_at',
    ];

    protected function casts(): array
    {
        return [
            'consent' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    protected function fullName(): Attribute
    {
        return Attribute::get(fn (): string => trim($this->first_name.' '.$this->last_name));
    }
}
