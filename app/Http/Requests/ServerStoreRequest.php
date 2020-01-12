<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerStoreRequest extends FormRequest
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
            'users' => 'required|array',
            'system_os' => 'required|exists:operating_systems,id',
        ];
    }

    protected function prepareForValidation()
    {
        if ($users = $this->request->get('users')) {
            $users = array_map('trim', explode(',', $users));

            $this->request->set('users', $users);
        }
    }
}
