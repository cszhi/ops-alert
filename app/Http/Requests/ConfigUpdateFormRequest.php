<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConfigUpdateFormRequest extends Request
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
            'host' => 'required',
            'fromname' => 'required|min:1|max:30',
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'host' => '邮件服务器',
            'from' => '发件名称',
            'email' => '邮箱帐号',
            'password' => '邮箱密码'

        ];
    }
}
