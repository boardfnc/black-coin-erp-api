<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminMemberSubscribe extends FormRequest
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
        if($request->route()->named('MemberAdminMemberSubscribesGet')) {
            return [
                'search_type'                           => 'in:login_id,prtnr_nm,code,dpstr,acnutno',
                'search_keyword'                        => 'string|nullable',
                'confm_sttus'                           => 'in:0,2,3|nullable',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberSubscribeConsentPost')) {
            return [
                'mber_id'                               => 'required|numeric',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberSubscribeRejectionPost')) {
            return [
                'mber_id'                               => 'required|numeric',
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
            'mber_id.required'                          => '회원ID는 필수 입력 항목입니다.',
            'mber_id.numeric'                           => '회원ID는 숫자만 입력하세요.',

            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'confm_sttus.in'                            => '잘못된 승인상태 값 입니다.',
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
