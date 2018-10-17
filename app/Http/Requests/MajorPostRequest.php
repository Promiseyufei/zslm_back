<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MajorPostRequest extends FormRequest
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
            'approval'      => 'nullable|string|max:25',
            'majorAuth'     => 'nullable|numeric',
            'majorNature'   => 'nullable|numeric',
            'majorProvince' => 'nullable|string',
            'majorAddress'  => 'nullable|string|max:255',
            'phone'         => 'nullable|alpha_num|max:15',
            'admissionsWeb' => ['nullable',"regex:$pattern"],
            'indexWeb'      => ['nullable',"regex:$pattern"],
            'wcImage'       => 'nullable|file',
            'wbImage'       => 'nullable|file',
            'schoolId'      => 'required|numeric',
            'majorName'     => 'required|string|max:45',
            'majorType'     => 'nullable|numeric',
            'magorLogo'     => 'nullable|file',
            'title'         => 'nullable|string',
            'keywords'      => 'nullable|string',
            'description'   => 'nullable|string',
        ];
    }

    public function messages() 
    {
        return [
            'approval.max'      => '文本超过长度',
            'majorAuth.*'     => '参数错误',
            'majorNature.*'   => '参数错误',
            'majorProvince.*' => '参数错误',
            'majorAddress.max'  => '文本超过长度',
            'phone.*'         => '这不是有效的手机号',
            'admissionsWeb.*' => '网址格式不正确',
            'indexWeb.*'      => '网址格式不正确',
            'wcImage.file'       => '这不是一个文件',
            'wbImage.file'       => '这不是一个文件',
            'schoolId.required'      => '所属学校不能为空',
            'majorName.required'     => '专业名称不能为空',
            'majorName.string'     => '专业名称必须是字符串',
            'majorName.max'     => '文本超过长度',
            'majorType.*'     => '参数错误',
            'magorLogo.file'     => '这不是一个文件',
            'title.*'         => '参数错误',
            'keywords.*'      => '参数错误',
            'description.*'   => '参数错误',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
