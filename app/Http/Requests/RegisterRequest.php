<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterRequest extends Request
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
            'name' => 'required|unique:users|min:3',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'password_verify' => 'required|min:6|same:password',
        ];
    }

    public function messages()
    {
        // 可改寫到語系檔：resources/lang/xx/validation.php的custom中
        return [
            'name.required' => '帳號是必填的',
            'name.unique' => '此帳號已被註冊過',
            'name.min' => '帳號最少 :min 字元',

            'email.required'  => '信箱是必填的',
            'email.unique'  => '此信箱已被註冊過',

            'password.required' => '密碼是必填的',
            'password.min' => '密碼最少 :min 字元',

            'password_verify.required'  => '確認密碼是必填的',
            'password_verify.min' => '確認密碼最少 :min 字元',
            'password_verify.same'  => '請輸入兩次相同的密碼',
        ];
    }
}
