<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            //
            'content' => 'required|min:2',
            //'topic_id' => 'required|exists:topics,id',
        ];
    }


//    public function messages()
//    {
//
//        return [
//
//            'topic_id.exists' => '此话题不存在，无法回复',
//
//        ];
//
//    }
}
