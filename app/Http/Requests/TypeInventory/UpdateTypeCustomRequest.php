<?php

namespace App\Http\Requests\TypeInventory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTypeCustomRequest extends FormRequest
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
            'name' => 'required',
            'resource_type' => 'required'
        ];
    }
}
