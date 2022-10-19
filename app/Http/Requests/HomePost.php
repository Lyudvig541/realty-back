<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class HomePost extends FormRequest
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
            'currency' => 'required',
            'address' => 'required|string|max:255',
            'area' => 'required|numeric|min:0',
            'land_area' => 'required|numeric|min:0',
            'sewer' => 'required',
            'distance_from_metro_station' => 'required',
            'distance_from_medical_center' => 'required',
            'distance_from_stations' => 'required',
            'bathroom' => 'required',
            'rooms' => 'required',
            'ceiling_height' => 'required',
            'balcony' => 'required',
            'cover' => 'required',
            'condition' => 'required',
            'building_type' => 'required',
            'storeys' => 'required|string|max:255',
            'furniture' => 'required',
            'year' => 'required',
            'degree' => 'required',
            'files' => 'min:3|max:15',
        ];
    }
}
