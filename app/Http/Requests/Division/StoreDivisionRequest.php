<?php

namespace App\Http\Requests\Division;

use App\Http\Requests\ApiFormRequest;

class StoreDivisionRequest extends ApiFormRequest
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
            'name' => [
                'required'
            ],
            'id_branch' => [
                'required'
            ]
        ];
    }
}
