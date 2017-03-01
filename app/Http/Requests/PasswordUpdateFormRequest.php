<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PasswordUpdateFormRequest extends Request
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
        \Validator::extend('old_password', function ($attribute, $value, $parameters, $validator) {
            return \Hash::check($value, current($parameters));
        });
        return [
            'oldpassword'=>'string|min:6|old_password:'.\Auth::user()->password,
            'password'=>'string|min:6|confirmed',
            'password_confirmation'=>'string|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'oldpassword' => '旧密码'
        ];
    }

    public function messages()
    {
        return [
            'oldpassword.old_password' => '旧密码错误'
        ];
    }
}
