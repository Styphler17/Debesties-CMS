<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required_without:layout', 'nullable', 'string'],
            'layout' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:draft,published'],
        ];
    }
}
