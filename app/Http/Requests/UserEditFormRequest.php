<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserEditFormRequest extends Request
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

    public function rules()
    {
        return [
            'name' => 'required|min:1|max:30',
            'weixin' => 'required|min:1|max:30|alpha_dash',
            'email' => 'required|min:1|max:30|email'
        ];
    }

    public function attributes()
    {
        return [
            'name' => '用户名',
            'weixin' => '微信名',
            'email' => '邮箱'
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
