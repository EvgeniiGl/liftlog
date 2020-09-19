<?php

namespace Modules\Records\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordsDoneRequest extends FormRequest
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
            "id"        => 'integer|required',
            "time_done" => 'date_format:d.m.Y H:i|required',
            "theme_end" => 'string|max:1000|nullable',
        ];
    }

}
