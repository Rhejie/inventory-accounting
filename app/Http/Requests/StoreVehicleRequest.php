<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
        
            
            'brand_name' => ['required'],
            'plate_number' => ['required'],
            'date_acquired' => ['nullable','date'],
            'photo' => ['image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
         
        ];
    }
}
