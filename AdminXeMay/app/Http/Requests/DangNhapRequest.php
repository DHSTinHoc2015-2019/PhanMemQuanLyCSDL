<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangNhapRequest extends FormRequest
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
            'password' => 'max:30|min:3',
        ];
    }

    public function messages()
    {
        return [
           'password.max' => 'Mật khẩu không được quá :max ký tự',
           'password.min' => 'Mật khẩu phải có ít nhất :min ký tự',
       ];
   }
}
