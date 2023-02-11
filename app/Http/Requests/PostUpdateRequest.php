<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->route('post')->user_id === $this->user()->id;
    }

    public function rules(): array
    {
        return PostStoreRequest::rules();
    }
}
