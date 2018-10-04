<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DangKy2Request extends FormRequest
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
            'TenDangNhap' => 'unique:users,name',
            'Email' => 'unique:users,email',
            'Password' => 'min:3|max:30',
            'PasswordAgain' => 'same:Password',
        ];
    }

    public function messages(){
        return [
            'TenDangNhap.unique' => 'Tài khoản đã tồn tại',
            'Email.unique' => 'Email đã tồn tại',
            'Password.min' => 'Mật khẩu có ít nhất :min ký tự',
            'Password.max' => 'Mật khẩu không được quá :max ký tự',
            'PasswordAgain.same' => 'Mật khẩu nhập chưa khớp',
        ];
    }
}
