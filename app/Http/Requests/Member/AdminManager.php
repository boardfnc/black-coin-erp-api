<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminManager extends FormRequest
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
        if ($request->route()->named('MemberAdminManagerPost')) {
            return [
                'login_id'                              => 'required|string|min:4|max:20|unique:bc_mngr,login_id',
                'password'                              => 'required|string|min:6|max:20',
                'prtnr_nm'                              => 'required|string',
                'mp_no'                                 => 'required|string|min:10|max:11',
                'site_adres'                            => 'required|string',
                'bank'                                  => 'required|string',
                'acnutno'                               => 'required|string',
                'dpstr'                                 => 'required|string',
                'csby_fee'                              => 'required|numeric',
                'purchs_fee'                            => 'required|numeric',
                'sle_fee'                               => 'required|numeric',
            ];
        }
        else if($request->route()->named('MemberAdminManagersGet')) {
            return [
                'search_type'                           => 'in:login_id,prtnr_nm,code',
                'search_keyword'                        => 'string|nullable',
                'mngr_sttus'                            => 'in:0,1,2|nullable',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if ($request->route()->named('MemberAdminManagerAccountUpdatePut')) {
            return [
                'prtnr_nm'                              => 'required|string',
                'mp_no'                                 => 'required|string|min:10|max:11',
                'site_adres'                            => 'required|string',
            ];
        }
        else if ($request->route()->named('MemberAdminManagerAccountNumberUpdatePut')) {
            return [
                'bank'                                  => 'required|string',
                'acnutno'                               => 'required|string',
                'dpstr'                                 => 'required|string',
            ];
        }
        else if ($request->route()->named('MemberAdminManagerFeeUpdatePut')) {
            return [
                'csby_fee'                              => 'required|numeric',
                'purchs_fee'                            => 'required|numeric',
                'sle_fee'                               => 'required|numeric',
            ];
        }
        else if ($request->route()->named('MemberAdminManagerStatusUpdatePut')) {
            return [
                'mngr_sttus'                            => 'required|in:1,2',
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
            'login_id.required'                         => 'CA 회원 아이디는 필수 입력 항목입니다.',
            'login_id.min'                              => 'CA 회원 아이디는 최소 4글자 까지 입력 하셔야 합니다.',
            'login_id.max'                              => 'CA 회원 아이디는 최대 20글자 까지 입력 하셔야 합니다.',
            'login_id.unique'                           => '이미 사용중인 아이디 입니다.',
            'password.required'                         => '비밀번호를 입력해 주세요.',
            'password.min'                              => '비밀번호는 6~20자리 까지 설정 가능합니다.',
            'password.max'                              => '비밀번호는 6~20자리 까지 설정 가능합니다.',
            'prtnr_nm.required'                         => '파트너사명은 필수 입력 항목입니다.',
            'mp_no.required'                            => '담당자 연락처를 입력해 주세요.',
            'mp_no.min'                                 => '담당자 연락처가 유효하지 않습니다.',
            'mp_no.max'                                 => '담당자 연락처번호가 유효하지 않습니다.',
            'site_adres.required'                       => '사이트주소은 필수 입력 항목입니다.',
            'bank.required'                             => '은행명은 필수 선택 항목입니다.',
            'acnutno.required'                          => '계좌번호은 필수 입력 항목입니다.',
            'dpstr.required'                            => '예금주명은 필수 입력 항목입니다.',
            'csby_fee.required'                         => '건당수수료은 필수 입력 항목입니다.',
            'csby_fee.numeric'                          => '건당수수료은 숫자만 입력하세요.',
            'purchs_fee.required'                       => '구매수수료은 필수 입력 항목입니다.',
            'purchs_fee.numeric'                        => '구매수수료은 숫자만 입력하세요.',
            'sle_fee.required'                          => '판매수수료은 필수 입력 항목입니다.',
            'sle_fee.numeric'                           => '판매수수료은 숫자만 입력하세요.',

            'mngr_sttus.required'                       => '관리자상태는 필수 입력 항목입니다.',

            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'mngr_sttus.in'                             => '잘못된 관리자상태 값 입니다.',
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
