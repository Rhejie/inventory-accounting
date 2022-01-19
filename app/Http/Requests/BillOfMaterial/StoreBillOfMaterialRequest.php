<?php

namespace App\Http\Requests\BillOfMaterial;

use Illuminate\Foundation\Http\FormRequest;

class StoreBillOfMaterialRequest extends FormRequest
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
            'bill_of_material_item_id' => 'required',
            'bill_of_material_description_id' => 'required',
            'unit' => 'required',
            'unit_cost' => 'required',
            'quantity' => 'required',
            'amount' => 'required',
        ];
    }
}
