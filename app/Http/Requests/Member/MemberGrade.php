<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class MemberGrade extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        if ($request->route()->named('MemberMemberGradePut')) {
            return [
                'comput_stdr_se'                        => 'required|in:1,2,3,4',
                'vvip_stdr'                             => 'required|numeric',
                'vip_stdr'                              => 'required|numeric',
                'gnrl_stdr'                             => 'required|numeric',
            ];
        }
        else
        {
            return [

            ];
        }
    }

    public function messages()
    {
        return [
            'comput_stdr_se.required'                   => '산출기준구분은 필수 입력 항목입니다.',
            'comput_stdr_se.in'                         => '잘못된 산출기준구분 값 입니다.',
            'vvip_stdr.required'                        => 'vvip기준은 필수 입력 항목입니다.',
            'vvip_stdr.numeric'                         => 'vvip기준은 숫자만 입력하세요.',
            'vip_stdr.required'                         => 'vip기준은 필수 입력 항목입니다.',
            'vip_stdr.numeric'                          => 'vip기준은 숫자만 입력하세요.',
            'gnrl_stdr.required'                        => '일반기준은 필수 입력 항목입니다.',
            'gnrl_stdr.numeric'                         => '일반기준은 숫자만 입력하세요.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first()], 400));
    }
}
