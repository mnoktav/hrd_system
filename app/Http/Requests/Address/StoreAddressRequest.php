<?php

namespace App\Http\Requests\Address;

use App\Http\Requests\ApiFormRequest;

class StoreAddressRequest extends ApiFormRequest
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
            'type' => [
                'required'
            ],
            'address' => [
                'required'
            ],
            'id_user' => [
                'required'
            ]
        ];
    }
}
