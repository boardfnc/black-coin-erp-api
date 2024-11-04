<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminMember extends FormRequest
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
        if($request->route()->named('MemberAdminMembersGet')) {
            return [
                'search_type'                           => 'in:login_id,prtnr_nm,code',
                'search_keyword'                        => 'string|nullable',
                'mber_grd'                              => 'in:0,1,2,3,4|nullable',
                'mber_sttus'                            => 'in:0,1,2|nullable',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberPasswordUpdatePut')) {
            return [
                'password'                              => 'required|string|min:6|max:20',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberStatusUpdatePut')) {
            return [
                'mber_sttus'                            => 'required|in:1,2',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberAccountNumberUpdatePut')) {
            return [
                'bank'                                  => 'required|string',
                'acnutno'                               => 'required|string',
                'dpstr'                                 => 'required|string',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberGradeUpdatePut')) {
            return [
                'mber_grd'                              => 'required|in:1,2,3,4',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberRetrievalPost')) {
            return [
                'mber_id'                               => 'required|numeric',
                'rtrvl_coin'                            => 'required|numeric',
            ];
        }
        else if ($request->route()->named('MemberAdminMemberPaymentPost')) {
            return [
                'mber_id'                               => 'required|numeric',
                'pymnt_coin'                            => 'required|numeric',
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
            'rtrvl_coin.required'                       => '회수코인는 필수 입력 항목입니다.',
            'rtrvl_coin.numeric'                        => '회수코인는 숫자만 입력하세요.',
            'pymnt_coin.required'                       => '지급코인는 필수 입력 항목입니다.',
            'pymnt_coin.numeric'                        => '지급코인는 숫자만 입력하세요.',

            'password.required'                         => '비밀번호를 입력해 주세요.',
            'password.min'                              => '비밀번호는 6~20자리 까지 설정 가능합니다.',
            'password.max'                              => '비밀번호는 6~20자리 까지 설정 가능합니다.',
            'mber_sttus.required'                       => '회원상태는 필수 입력 항목입니다.',
            'bank.required'                             => '은행명은 필수 선택 항목입니다.',
            'acnutno.required'                          => '계좌번호은 필수 입력 항목입니다.',
            'dpstr.required'                            => '예금주명은 필수 입력 항목입니다.',
            'mber_grd.required'                         => '회원등급는 필수 입력 항목입니다.',

            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'mber_grd.in'                               => '잘못된 회원등급 값 입니다.',
            'mber_sttus.in'                             => '잘못된 회원상태 값 입니다.',
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
