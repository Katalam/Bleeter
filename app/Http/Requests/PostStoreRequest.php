<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'body' => 'required|string|max:255|min:3',
            'image' => 'nullable|image|max:1024',
            'parent_id' => 'nullable|exists:posts,id',
        ];
    }
}
