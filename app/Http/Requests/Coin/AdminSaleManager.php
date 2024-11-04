<?php

namespace App\Http\Requests\Coin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminSaleManager extends FormRequest
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
        if($request->route()->named('CoinAdminSaleManagersGet')) {
            return [
                'search_type'                           => 'in:delng_no,login_id,prtnr_nm,code,dpstr,acnutno',
                'search_keyword'                        => 'string|nullable',
                'delng_sttus.*'                         => 'in:21,22,23,24|distinct',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        else if($request->route()->named('CoinAdminSaleManagerHistoryGet')) {
            return [
                'mngr_id'                               => 'required|numeric',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        elseif ($request->route()->named('CoinAdminSaleManagerPost')) {
            return [
                '_bc_ca_delng_dtls.*.ca_delng_dtls_id'      => 'required|numeric',
                '_bc_ca_delng_dtls.*.pymnt_am'              => 'required|numeric'
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
            '_bc_ca_delng_dtls.*.ca_delng_dtls_id.required'     => 'CA거래내역ID는 필수 입력해 주세요.',
            '_bc_ca_delng_dtls.*.ca_delng_dtls_id.numeric'      => 'CA거래내역ID는 숫자로만 입력해 주세요.',
            '_bc_ca_delng_dtls.*.pymnt_am.required'             => '지급금액는 필수 입력해 주세요.',
            '_bc_ca_delng_dtls.*.pymnt_am.numeric'              => '지급금액는 숫자로만 입력해 주세요.',

            'mngr_id.required'                          => '관리자ID는 필수 입력 항목입니다.',
            'mngr_id.numeric'                           => '관리자ID는 숫자만 입력하세요.',
            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
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
