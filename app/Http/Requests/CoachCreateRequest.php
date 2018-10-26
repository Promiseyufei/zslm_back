<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoachCreateRequest extends FormRequest
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
        $pattern="/(\\w+(-\\w+)*)(\\.(\\w+(-\\w+)*))*(\\?\\S*)?/";
        return [
            'coach_name'         => 'required|string|max:255',
            'provice'           => 'required|string',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string|max:255',
            'web_url'            => ['required',"regex:$pattern"],
            'father_id'         => 'required|numeric',
            'if_back_money'     => 'required|numeric',
            'cover_name'         => 'nullable|file',
            'logo_name'          => 'nullable|file',
        ];
    }

    public function messages() {
        return [
            '*.required'                =>  '信息不能为空',
            'coach_name.max'             => '名称长度超过限制',
            'provice.*'                 => '参数错误',
            'phone.max'                 => '长度超过限制',
            'address.max'               => '长度超过限制',
            'web_url.max'                => '长度超过限制',
            'father_id.numeric'         => '值不是数值',
            'if_back_money.numeric'     => '值不是数值',
            'cover_name.file'            => '上传的不是一个文件',
            'logo_name.file'             => '上传的不是一个文件',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        print_r( $validator->getMessageBag()->toArray());
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
