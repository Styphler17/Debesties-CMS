<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'body'              => ['required', 'string'],
            'category_id'       => ['required', 'exists:categories,id'],
            'tags'              => ['nullable', 'array'],
            'tags.*'            => ['exists:tags,id'],
            'featured_image_id' => ['nullable', 'exists:media,id'],
            'status'            => ['nullable', 'in:draft,published,scheduled'],
            'excerpt'           => ['nullable', 'string', 'max:500'],
            'subtitle'          => ['nullable', 'string', 'max:255'],
        ];
    }
}
