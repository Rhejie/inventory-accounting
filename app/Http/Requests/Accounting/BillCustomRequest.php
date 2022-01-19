<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class BillCustomRequest extends FormRequest
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
            'bill_date' => 'required|date',
            'due_date' => 'required|date',
            'bill_number' => 'required',
            'type' => 'required|string',
            'orders.*.file' => 'required|file'
        ];
    }
}
