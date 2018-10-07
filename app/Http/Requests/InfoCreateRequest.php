<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfoCreateRequest extends FormRequest
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
            'infoName'      => 'required|string|max:255',
            'infoType'      => 'required|numeric',
            'infoFrom'      => 'required|string',
            'infoImage'     => 'required|file',
            'infoText'      => 'required|string',
            'title'         => 'nullable|string|max:255',
            'keywords'      => 'nullable|string',
            'description'   => 'nullable|string'
        ];
    }

    public function messages() {
        return [
            '*.required'        => '信息不能为空',
            'infoName.max'      => '名称长度超过限制',
            'infoType.numeric'  => '值不是数值',
            'infoFrom.*'        => '参数错误',
            'infoText.*'        => '参数错误',
            'title.max'         => '长度超过限制',
            'keywords.*'        => '参数错误',
            'description.*'     => '参数错误',
            'infoImage.file'    => '上传的不是一个文件',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
