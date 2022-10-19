<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApartementPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'sewer' => 'required',
            'distance_from_metro_station' => 'required',
            'distance_from_medical_center' => 'required',
            'distance_from_stations' => 'required',
            'currency' => 'required',
            'files' => 'min:3|max:15',
            'rooms' => 'required',
            'bathroom' => 'required',
            'ceiling_height' => 'required',
            'balcony' => 'required',
            'cover' => 'required',
            'condition' => 'required',
            'building_type' => 'required',
            'floor' => 'required|string|max:255',
            'storeys' => 'required|string|max:255',
            'furniture' => 'required',
            'year' => 'required',
            'degree' => 'required',
        ];
    }
}
