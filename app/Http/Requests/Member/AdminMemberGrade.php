<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminMemberGrade extends FormRequest
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
        if($request->route()->named('MemberAdminMemberGradesGet')) {
            return [
                'search_type'                           => 'in:prtnr_nm,code',
                'search_keyword'                        => 'string|nullable',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberGradePut')) {
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

            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'page.numeric'                              => '페이지 번호는 숫자만 입력하세요.',
            'page.min'                                  => '페이지 번호는 1이상의 숫자만 입력하세요.',
            'per_page.numeric'                          => '페이지당 노출 갯수는 숫자만 입력하세요.',
            'per_page.min'                              => '페이지당 노출 갯수는 1이상의 숫자만 입력하세요.',
            'orderby.*.distinct'                        => '정렬에 중복된 값이 있습니다.'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first()], 400));
    }
}
