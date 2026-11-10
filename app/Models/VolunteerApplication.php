<?php

namespace App\Models;

use Database\Factories\VolunteerApplicationFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerApplication extends Model
{
    /** @use HasFactory<VolunteerApplicationFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'location',
        'skills',
        'availability',
        'motivation',
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
