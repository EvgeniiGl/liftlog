<?php

namespace Modules\Address\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // todo check
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
            'str_search' => 'string|required',
//            'id_city' => 'required|numeric|max:9',
//            'phone' => 'required|numeric|max:11',
//            'min_price' => 'required|numeric|max:11',
//            'max_price' => 'required|numeric|max:11',
//            'price_description' => 'required|max:100',
//            'title' => 'required|max:100',
//            'messengers' => 'required|json|max:100',
//            'url_preview' => 'required|max:100',
//            'description' => 'required|max:1000',
//            'id_age' => 'required|numeric|max:11',
//            'place_description' => 'required|max:100',
//            'longitude' => 'required|regex:/^(\+|-)?(?:180(?:(?:\.0{1,6})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,6})?))$/',
//            'latitude' => 'required|regex:/^(\+|-)?(?:90(?:(?:\.0{1,6})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,6})?))$/',
//            'start_date' => 'required|date_format:d.m.Y H:i|before:end_date',
//            'end_date' => 'required|date_format:d.m.Y H:i',
//            'max_quantity' => 'required|numeric|max:9',
//            'id_type' => 'required|numeric|max:9',
//            'categories' => 'required|json|max:1000',
//            'tickets' => 'required|json|max:1000'
        ];
    }


}
