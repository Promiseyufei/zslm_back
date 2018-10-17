<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityCreateRequest extends FormRequest
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
            'activityName'  => 'required|string|max:255',
            'activityType'  => 'required|numeric',
            'majorType'     => 'required|numeric',
            'province'      => 'required|string|max:255',
            'address'       => 'required|string|max:255',
            'beginTime'     => 'required|date|after:tomorrow',
            'endTime'       => 'required|date|after:beginTime',
            'signUpState'   => 'required|numeric',
            'activeImg'     => 'required|file',
        ];
    }

    public function messages() {
        return [
            '*.required'              =>  '信息不能为空',
            'activityName.max'        => '名称长度超过限制',
            'activityType.numeric'    => '值不是数值',
            'majorType.numeric'       => '值不是数值',
            'province.max'            => '长度超过限制',
            'address.max'             => '长度超过限制',
            'beginTime.date'          => '时间参数错误',
            'beginTime.after'         => '选择的开始时间至少在昨天之后',
            'endTime.date'            => '时间参数错误',
            'endTime.after'           => '选择的结束时间需在开始时间之后',
            'signUpState.numeric'     => '值不是数值',
            'activeImg.file'          => '上传的不是一个文件',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        var_dump( $validator->getMessageBag());
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
