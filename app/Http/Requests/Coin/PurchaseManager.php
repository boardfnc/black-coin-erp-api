<?php

namespace App\Http\Requests\Coin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class PurchaseManager extends FormRequest
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
        if($request->route()->named('CoinPurchaseManagersGet')) {
            return [
                'search_type'                           => 'in:delng_no',
                'search_keyword'                        => 'string|nullable',
                'delng_sttus.*'                         => 'in:11,12,13,14|distinct',
                'page'                                  => 'required|numeric|min:1',
                'per_page'                              => 'required|numeric|min:1',
                'orderby.*'                             => 'string|distinct|nullable',
            ];
        }
        elseif ($request->route()->named('CoinPurchaseManagerPost')) {
            return [
                'delng_qy'                              => 'required|numeric'
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
            'delng_qy.required'                         => '거래수량는 필수 입력해 주세요.',
            'delng_qy.numeric'                          => '거래수량는 숫자로만 입력해 주세요.',

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
