<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsumableStockOutRequest extends FormRequest
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
            'request_materials_form_consumable_item_id' => 'required',
            'actual_quantity_delivered' => 'required',
            'date_delivered' => 'required',
            'remarks' => 'required',
        ];
    }
}
