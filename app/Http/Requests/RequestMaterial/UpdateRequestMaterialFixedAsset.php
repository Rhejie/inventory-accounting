<?php

namespace App\Http\Requests\RequestMaterial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequestMaterialFixedAsset extends FormRequest
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
            'date_requested' => 'required|date',
        ];
    }
}
