<?php

namespace App\Http\Requests\Coin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminSaleMember extends FormRequest
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
        if($request->route()->named('CoinAdminSaleMembersGet')) {
            return [
                'search_type'                           => 'in:delng_no,login_id,nm,dpstr,acnutno',
                'search_keyword'                        => 'string|nullable',
                'mber_grd.*'                            => 'in:1,2,3,4|distinct',
                'delng_sttus.*'                         => 'in:21,22,23,24|distinct',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if($request->route()->named('CoinAdminSaleMemberHistoryGet')) {
            return [
                'mber_id'                               => 'required|numeric',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        elseif ($request->route()->named('CoinAdminSaleMemberPost')) {
            return [
                '_bc_mber_delng_dtls.*.mber_delng_dtls_id'      => 'required|numeric',
                '_bc_mber_delng_dtls.*.pymnt_am'                => 'required|numeric'
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
            '_bc_mber_delng_dtls.*.mber_delng_dtls_id.required'     => '회원거래내역ID는 필수 입력해 주세요.',
            '_bc_mber_delng_dtls.*.mber_delng_dtls_id.numeric'      => '회원거래내역ID는 숫자로만 입력해 주세요.',
            '_bc_mber_delng_dtls.*.pymnt_am.required'               => '지급금액는 필수 입력해 주세요.',
            '_bc_mber_delng_dtls.*.pymnt_am.numeric'                => '지급금액는 숫자로만 입력해 주세요.',

            'mber_id.required'                          => '회원ID는 필수 입력 항목입니다.',
            'mber_id.numeric'                           => '회원ID는 숫자만 입력하세요.',

            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'mber_grd.*.in'                             => '잘못된 회원등급 값 입니다.',
            'mber_grd.*.distinct'                       => '회원등급 값에 중복된 값이 있습니다.',
            'delng_sttus.*.in'                          => '잘못된 거래상태 값 입니다.',
            'delng_sttus.*.distinct'                    => '거래상태 값에 중복된 값이 있습니다.',
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
