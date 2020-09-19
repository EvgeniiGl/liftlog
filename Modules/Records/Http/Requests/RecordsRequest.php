<?php

namespace Modules\Records\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordsRequest extends FormRequest
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
            "id"               => 'integer|nullable',
            "time_incident"    => 'required|date_format:d.m.Y H:i',
            "ids_selected_adr" => 'string|required',
            "type"             => 'string|required',
            "theme"            => 'string|nullable',
            "evacuation"       => 'boolean',
            "time_evacuation"  => 'nullable|date_format:d.m.Y H:i',
            "time_sent"        => 'nullable|date_format:d.m.Y H:i',
            "maker_id"         => 'numeric|max:10000|nullable',
            "time_take"        => 'nullable|date_format:d.m.Y H:i',
            "time_done"        => 'nullable|date_format:d.m.Y H:i',
            "theme_end"        => 'string|nullable',
            "closer_id"        => 'numeric|max:10000|nullable',
        ];
    }

}
