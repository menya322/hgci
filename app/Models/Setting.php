<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $setting = static::query()->where('key', $key)->first();

        if (! $setting || $setting->value === null) {
            return $default;
        }

        return $setting->typedValue();
    }

    /**
     * Return every setting as a key => typed value array for a single page.
     *
     * @return array<string, mixed>
     */
    public static function allKeyed(): array
    {
        return static::query()
            ->get()
            ->mapWithKeys(fn (self $setting): array => [$setting->key => $setting->typedValue()])
            ->all();
    }

    public function typedValue(): mixed
    {
        if ($this->value === null) {
            return null;
        }

        return match ($this->type) {
            'boolean' => filter_var($this->value, FILTER_VALIDATE_BOOL),
            'integer' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }

    public static function put(string $key, mixed $value, string $type = 'text', ?string $group = null): self
    {
        if (is_bool($value)) {
            $value = $value ? '1' : '0';
            $type = 'boolean';
        } elseif (is_array($value) || is_object($value)) {
            $value = json_encode($value);
            $type = 'json';
        }

        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type, 'group' => $group],
        );
    }

    /**
     * Resolve the address that should receive public form notifications.
     */
    public static function adminEmail(): string
    {
        $candidates = [
            static::get('contact.notification_email'),
            static::get('contact.email'),
            config('mail.from.address'),
        ];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && filter_var($candidate, FILTER_VALIDATE_EMAIL)) {
                return $candidate;
            }
        }

        return 'hello@example.com';
    }
}
