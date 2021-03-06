<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class UsersRequest extends FormRequest
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

        switch($this->method()){

            case 'POST':
                return  [

                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:6',
                    'verification_key' => 'required|string',
                    'verification_code' => 'required|string',
                    //
                ];
                break;

            case 'PATCH':
                $userId = \Auth::guard('api')->id();
                return  [

                    'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,'.$userId,
                    'email' => 'email',
                    'introduction' => 'max:100',
                    'avatar_image_id' => 'exists:images,id,type,avatar,user_id,'.$userId,
                    //表中id是否存在，type 是否为 avatar，用户id是否是当前登录的用户id
                    //表单验证参考 https://laravel-china.org/docs/laravel/5.5/validation/1302#rule-exists
                ];

                break;

        }

    }

    public function attributes()
    {

        return [
            'verification_key' => '验证码key',
            'verification_code' => '验证码',
        ];

    }


    public function messages()
    {

        return [

            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.unique' => '用户名已被占用，请重新输入',
            'name.between' => '用户名必须介于3-25字符之间',
            'name.required' => '用户名不能为空',

        ];

    }
}
