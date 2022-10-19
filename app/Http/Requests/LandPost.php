<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LandPost extends FormRequest
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
            'area' => 'required|numeric|min:0',
            'sewer' => 'required',
            'distance_from_metro_station' => 'required',
            'distance_from_stations' => 'required',
            'distance_from_medical_center' => 'required',
            'address' => 'required|string|max:255',
            'land_geometric_appearance' => 'required',
            'purpose' => 'required',
            'front_position_length' => 'required',
            'front_position' => 'required',
            'road_type' => 'required',
            'infrastructure' => 'required',
            'fence_type' => 'required',
            'building' => 'required',
        ];
    }
}
