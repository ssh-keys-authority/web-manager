<?php

namespace App\Http\Requests;

use App\Rules\KeyValidation;
use Illuminate\Foundation\Http\FormRequest;

class KeyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'key' => ['required', new KeyValidation()],
        ];
    }
}
