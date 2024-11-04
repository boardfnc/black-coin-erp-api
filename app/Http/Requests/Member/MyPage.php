<?php

namespace App\Http\Requests\Member;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class MyPage extends FormRequest
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
        if ($request->route()->named('MemberMyPagePasswordUpdatePut')) {
            return [
                'password'                              => 'required|string|min:6|max:20',
            ];
        }
        else if ($request->route()->named('MemberMyPageAccountUpdatePut')) {
            return [
                'prtnr_nm'                              => 'required|string',
                'mp_no'                                 => 'required|string|min:10|max:11',
                'site_adres'                            => 'required|string',
            ];
        }
        else if ($request->route()->named('MemberMyPageAccountNumberUpdatePut')) {
            return [
                'bank'                                  => 'required|string',
                'acnutno'                               => 'required|string',
                'dpstr'                                 => 'required|string',
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
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first()], 400));
    }
}
