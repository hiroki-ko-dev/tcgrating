<?php

namespace App\Http\Requests\Api\Post;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'title' => ['required', 'string', 'max:200'],
            'image_url' => ['string', 'max:500'],
            'body' => ['required', 'string', 'max:2000'],
        ];
    }
}
