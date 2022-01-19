<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderStoreRequest extends FormRequest
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
            'supplier_id' => 'required|integer',
            'address' => 'required|string',
            'purchase_order_reference_no' => 'required|string',
            'push_order_date' => 'required|date',
            'project_id' => 'required|integer',
            'location' => 'required|string',
        ];
    }
}
