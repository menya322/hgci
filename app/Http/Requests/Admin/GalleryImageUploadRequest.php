<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryImageUploadRequest extends FormRequest
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
            'images' => ['required', 'array', 'min:1', 'max:20'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'images.required' => 'Choose at least one photo to upload.',
            'images.max' => 'Upload no more than 20 photos at a time.',
            'images.*.image' => 'Each file must be a valid image.',
            'images.*.mimes' => 'Photos must be JPG, PNG or WebP files.',
            'images.*.max' => 'Each photo must be 2 MB or smaller.',
        ];
    }
}
