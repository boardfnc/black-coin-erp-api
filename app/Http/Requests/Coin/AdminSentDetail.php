<?php

namespace App\Http\Requests\Coin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminSentDetail extends FormRequest
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
        if($request->route()->named('CoinAdminSentDetailsGet')) {
            return [
                'search_type'                           => 'in:prtnr_nm,code,login_id,nm',
                'search_keyword'                        => 'string|nullable',
                'mber_grd.*'                            => 'in:1,2,3,4|distinct',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
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
            'search_type.in'                            => '잘못된 검색 타입 값 입니다.',
            'mber_grd.*.in'                             => '잘못된 회원등급 값 입니다.',
            'mber_grd.*.distinct'                       => '회원등급 값에 중복된 값이 있습니다.',
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
