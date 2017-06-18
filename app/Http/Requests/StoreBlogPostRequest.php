<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreBlogPostRequest extends Request
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
            'title' => 'required|max:225',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        // 可改寫到語系檔：resources/lang/xx/validation.php的custom中
        return [
            'title.required' => '標題是必填的',
            'title.max' => '標題不可超過 :max 字元',
            'content.required'  => '內容是必填的',
        ];
    }
}
