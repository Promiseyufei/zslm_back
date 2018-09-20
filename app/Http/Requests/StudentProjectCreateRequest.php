<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentProjectCreateRequest extends FormRequest
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
            'projectName'            => 'required|string|max:100',
            'minCost'                => 'required|numeric',
            'maxCost'                => 'required|numeric',
            'cost'                   => 'required|string|max:255',
            'studentCount'           => 'required|string|max:255',
            'language'               => 'required|string|max:255',
            'classSituation'         => 'required|string',
            'eductionalSystme'       => 'required|numeric',
            'canConditions'          => 'required|string',
            'scoreDescribe'          => 'required|string',
            'graduationCertificate'  => 'required|string',
            'recruitmentPattern'     => 'required|numeric',
            'enrollmentMode'         => 'required|numeric',
            'professionalDirection'  => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            '*.required'                    =>  '信息不能为空',
            'projectName.max'               => '名称长度超过限制',
            'minCost.numeric'               => '值不是数值',
            'maxCost.numeric'               => '值不是数值',
            'cost.max'                      => '长度超过限制',
            'studentCount.max'              => '长度超过限制',
            'language.max'                  => '长度超过限制',
            'classSituation.*'              => '参数错误',
            'eductionalSystme.numeric'      => '值不是数值',
            'canConditions.*'               => '参数错误',
            'scoreDescribe.*'               => '参数错误',
            'graduationCertificate.*'       => '参数错误',
            'recruitmentPattern.numeric'    => '值不是数值',
            'enrollmentMode.numeric'        => '值不是数值',
            'professionalDirection.numeric' => '值不是数值'
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        return responseToJson(1, $validator->getMessageBag()->toArray()[0]);
    }
}
