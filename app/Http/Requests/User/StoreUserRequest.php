<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;

class StoreUserRequest extends ApiFormRequest
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
            'first_name' => [
                'required',
                'string'
            ],
            'position' => [
                'required'
            ],
            'entry_date' => [
                'required'
            ],
            'birthday' => [
                'required'
            ],
            'place_of_birth' => [
                'required'
            ],
            'emp_status' => [
                'required'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'unique:users'
            ],
            'password' => [
                'required',
                'string',
                'min:8'
            ],
        ];
    }
}
