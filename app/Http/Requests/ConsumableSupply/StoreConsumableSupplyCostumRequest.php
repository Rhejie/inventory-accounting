<?php

namespace App\Http\Requests\ConsumableSupply;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsumableSupplyCostumRequest extends FormRequest
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
            // 'item_code' => 'required',
            // 'item_name' => 'required',
            // 'bar_code' => 'required',
            // 'lot_number' => 'required',
            // 'description' => 'required',
            // 'unit_of_measure' => 'required',
            // 'quantity' => 'required',
            // 'stock_on_hand' => 'required',
            // 'reorder_point' => 'required',
        ];
    }
}
