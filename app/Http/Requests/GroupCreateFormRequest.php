<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GroupCreateFormRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:30|unique:groups,name|alpha_dash',
            'type' => 'required|min:1|max:30|in:weixin,email,all',
            'users' => 'required|array'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '用户名',
            'type' => '报警类型',
            'users' => '成员'
        ];
    }

    public function messages()
    {
        return [
            'name1.required' => 'Please provide a brief link description',
            'url.required' => 'Please provide a URL',
            'url.url' => 'A valid URL is required',
            'category.required' => 'Please associate this link with a category',
            'category.min' => 'Please associate this link with a category'
        ];
    }
}
