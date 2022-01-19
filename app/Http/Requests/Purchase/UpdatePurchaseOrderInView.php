<?php

namespace App\Http\Requests\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePurchaseOrderInView extends FormRequest
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

            'address' => 'required|string',
            'contact_person' => 'required|string',
            'quote_reference_no' => 'required|string',
            'material_reference_no' => 'required|string',
            'date_needed' => 'required|date',
            'purchase_order_reference_no' => 'required|string',
            'push_order_date' => 'required|date',
            'location' => 'required|string',
            'requested_by' => 'required|string',
            'terms_of_payment' => 'required|string',
            'mode_of_payment' => 'required|string',
            'remarks' => 'required|string',
            'prepared_by' => 'required|string',
            'noted_by' => 'required|string',
            'checked_by' => 'required|string',
            'approved_by' => 'required|string',
        ];
    }
}
