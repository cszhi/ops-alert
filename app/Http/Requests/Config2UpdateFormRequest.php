<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Config2UpdateFormRequest extends Request
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
            'corpid' => 'required|alpha_num',
            'corpsecret' => 'required|alpha_num',
            'agentid' => 'required|numeric'
        ];
    }

    public function attributes()
    {
        return [

        ];
    }
}
