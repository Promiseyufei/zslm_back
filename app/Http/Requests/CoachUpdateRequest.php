<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoachUpdateRequest extends FormRequest
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
            'coachName'         => 'required|string|max:255',
            'coachType'         => 'required|numeric',
            'provice'           => 'required|string',
            'phone'             => 'required|string|max:20',
            'address'           => 'required|string|max:255',
            'webUrl'            => ['required',"regex:$pattern"],
            'CoachForm'         => 'required|numeric',
            'totalCoachId'      => 'required|numeric',
            'backMoneyType'     => 'required|numeric',
            'coverName'         => 'nullable|file',
            'logoName'          => 'nullable|file',
            'title'             => 'nullable|string',
            'keywords'          => 'nullable|string',
            'description'       => 'nullable|string',
        ];
    }

    public function messages() {
        return [
            '*.required'                =>  '信息不能为空',
            'coachName.max'             => '名称长度超过限制',
            'coachType.numeric'         => '值不是数值',
            'provice.*'                 => '参数错误',
            'phone.max'                 => '长度超过限制',
            'address.max'               => '长度超过限制',
            'webUrl.max'                => '长度超过限制',
            'CoachForm.numeric'         => '值不是数值',
            'totalCoachId.numeric'      => '值不是数值',
            'backMoneyType.numeric'     => '值不是数值',
            'coverName.file'            => '上传的不是一个文件',
            'logoName.file'             => '上传的不是一个文件',
            'title.*'                   => '参数错误',
            'keywords.*'                => '参数错误',
            'description.*'             => '参数错误',
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
