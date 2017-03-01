<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GroupEditFormRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:30|alpha_dash',
            'type' => 'required|in:weixin,email,all',
            'users' => 'required|array',
            // 'token' => 'required|min:16|max:16|alpha_num'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '用户名',
            'type' => '报警方式',
            'users' => '成员'
        ];
    }

    public function messages()
    {
        return [
            'token.min' => 'token 必须为16个字符',
            'token.max' => 'token 必须为16个字符'
        ];
    }
}
