<?php

namespace App\Http\Requests\HeavyEquipment;

use Illuminate\Foundation\Http\FormRequest;

class HeavyEquipmentCustomRequest extends FormRequest
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
            'control_number' => 'required',
            'brand_name' => 'required',
            'asset_category_id' => 'required',
        ];
    }
}
