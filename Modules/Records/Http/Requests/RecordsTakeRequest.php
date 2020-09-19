<?php

namespace Modules\Records\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordsTakeRequest extends FormRequest
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
        "id"               => 'integer|required'
    ];
}

}
