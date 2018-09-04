<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class TopicRequest extends FormRequest
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

                return [

                    'title'       => 'required|min:2',
                    'body'        => 'required|min:3',
                    'category_id' => 'required|numeric|exits:categories,id',

                ];
                break;
            case 'PATCH':

                break;
            case 'GET':

                break;
            case 'DELETE':

                break;
        }

        return [
            //
        ];
    }

    public function attributes()
    {
        return [
            'title' => '标题',
            'body' => '话题内容',
            'category_id' => '分类',
        ];
    }

}
