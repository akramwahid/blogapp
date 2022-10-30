<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'max:255'],
            'body' => ['required', 'max:60000'],
            'image' => ['required', 'max:255'],
            'author_id' => ['required', 'integer', 'exists:authors,id,deleted_at,NULL']
        ];
    }
}
