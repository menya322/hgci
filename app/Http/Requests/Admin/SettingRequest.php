<?php

namespace App\Http\Requests\Admin;

use Closure;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->is_admin;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'hero_eyebrow' => ['nullable', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['required', 'string', 'max:2000'],

            'impact_children_reached' => ['nullable', 'string', 'max:255'],
            'impact_projects_supported' => ['nullable', 'string', 'max:255'],
            'impact_communities_served' => ['nullable', 'string', 'max:255'],

            'contact_address_line1' => ['nullable', 'string', 'max:255'],
            'contact_address_line2' => ['nullable', 'string', 'max:255'],
            'contact_country' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'string', 'max:255', $this->emailRule()],
            'contact_notification_email' => ['nullable', 'string', 'max:255', $this->emailRule()],
            'contact_office_hours' => ['nullable', 'string', 'max:255'],

            'social_facebook' => ['nullable', 'string', 'max:255'],
            'social_instagram' => ['nullable', 'string', 'max:255'],
            'social_x' => ['nullable', 'string', 'max:255'],
            'social_youtube' => ['nullable', 'string', 'max:255'],

            'giving_mobile_money_provider' => ['nullable', 'string', 'max:255'],
            'giving_mobile_money_account_name' => ['nullable', 'string', 'max:255'],
            'giving_mobile_money_number' => ['nullable', 'string', 'max:255'],
            'giving_bank_name' => ['nullable', 'string', 'max:255'],
            'giving_bank_account_name' => ['nullable', 'string', 'max:255'],
            'giving_bank_account_number' => ['nullable', 'string', 'max:255'],
            'giving_bank_branch' => ['nullable', 'string', 'max:255'],
            'giving_bank_swift' => ['nullable', 'string', 'max:255'],
            'giving_instructions' => ['nullable', 'string', 'max:2000'],
        ];
    }

    /**
     * Accept either a real email address or the [ADD: ...] placeholder.
     */
    private function emailRule(): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail): void {
            if (blank($value) || str_starts_with(trim((string) $value), '[ADD:')) {
                return;
            }

            if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $fail('Enter a valid email address, or keep the [ADD: ...] placeholder.');
            }
        };
    }
}
