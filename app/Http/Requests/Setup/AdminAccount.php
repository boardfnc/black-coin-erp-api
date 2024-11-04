<?php

namespace App\Http\Requests\Setup;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class AdminAccount extends FormRequest
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
        if ($request->route()->named('SetupAdminAccountPost')) {
            return [
                'ca_mumm_rcpmny_am'                             => 'required|numeric',
                'ca_mxmm_rcpmny_am'                             => 'required|numeric',
                'vvip_mumm_rcpmny_am'                           => 'required|numeric',
                'vvip_mxmm_rcpmny_am'                           => 'required|numeric',
                'vvip_mumm_defray_am'                           => 'required|numeric',
                'vvip_mxmm_defray_am'                           => 'required|numeric',
                'vip_mumm_rcpmny_am'                            => 'required|numeric',
                'vip_mxmm_rcpmny_am'                            => 'required|numeric',
                'vip_mumm_defray_am'                            => 'required|numeric',
                'vip_mxmm_defray_am'                            => 'required|numeric',
                'gnrl_mumm_rcpmny_am'                           => 'required|numeric',
                'gnrl_mxmm_rcpmny_am'                           => 'required|numeric',
                'gnrl_mumm_defray_am'                           => 'required|numeric',
                'gnrl_mxmm_defray_am'                           => 'required|numeric',
                'new_mumm_rcpmny_am'                            => 'required|numeric',
                'new_mxmm_rcpmny_am'                            => 'required|numeric',
                'new_mumm_defray_am'                            => 'required|numeric',
                'new_mxmm_defray_am'                            => 'required|numeric',
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
            'ca_mumm_rcpmny_am.required'                        => 'CA최소입금금액은 필수 입력 항목입니다.',
            'ca_mumm_rcpmny_am.numeric'                         => 'CA최소입금금액은 숫자만 입력하세요.',
            'ca_mxmm_rcpmny_am.required'                        => 'CA최대입금금액은 필수 입력 항목입니다.',
            'ca_mxmm_rcpmny_am.numeric'                         => 'CA최대입금금액은 숫자만 입력하세요.',
            'vvip_mumm_rcpmny_am.required'                      => 'VVIP최소입금금액은 필수 입력 항목입니다.',
            'vvip_mumm_rcpmny_am.numeric'                       => 'VVIP최소입금금액은 숫자만 입력하세요.',
            'vvip_mxmm_rcpmny_am.required'                      => 'VVIP최대입금금액은 필수 입력 항목입니다.',
            'vvip_mxmm_rcpmny_am.numeric'                       => 'VVIP최대입금금액은 숫자만 입력하세요.',
            'vvip_mumm_defray_am.required'                      => 'VVIP최소출금금액은 필수 입력 항목입니다.',
            'vvip_mumm_defray_am.numeric'                       => 'VVIP최소출금금액은 숫자만 입력하세요.',
            'vvip_mxmm_defray_am.required'                      => 'VVIP최대출금금액은 필수 입력 항목입니다.',
            'vvip_mxmm_defray_am.numeric'                       => 'VVIP최대출금금액은 숫자만 입력하세요.',
            'vip_mumm_rcpmny_am.required'                       => 'VIP최소입금금액은 필수 입력 항목입니다.',
            'vip_mumm_rcpmny_am.numeric'                        => 'VIP최소입금금액은 숫자만 입력하세요.',
            'vip_mxmm_rcpmny_am.required'                       => 'VIP최대입금금액은 필수 입력 항목입니다.',
            'vip_mxmm_rcpmny_am.numeric'                        => 'VIP최대입금금액은 숫자만 입력하세요.',
            'vip_mumm_defray_am.required'                       => 'VIP최소출금금액은 필수 입력 항목입니다.',
            'vip_mumm_defray_am.numeric'                        => 'VIP최소출금금액은 숫자만 입력하세요.',
            'vip_mxmm_defray_am.required'                       => 'VIP최대출금금액은 필수 입력 항목입니다.',
            'vip_mxmm_defray_am.numeric'                        => 'VIP최대출금금액은 숫자만 입력하세요.',
            'gnrl_mumm_rcpmny_am.required'                      => '일반회원최소입금금액은 필수 입력 항목입니다.',
            'gnrl_mumm_rcpmny_am.numeric'                       => '일반회원최소입금금액은 숫자만 입력하세요.',
            'gnrl_mxmm_rcpmny_am.required'                      => '일반회원최대입금금액은 필수 입력 항목입니다.',
            'gnrl_mxmm_rcpmny_am.numeric'                       => '일반회원최대입금금액은 숫자만 입력하세요.',
            'gnrl_mumm_defray_am.required'                      => '일반회원최소출금금액은 필수 입력 항목입니다.',
            'gnrl_mumm_defray_am.numeric'                       => '일반회원최소출금금액은 숫자만 입력하세요.',
            'gnrl_mxmm_defray_am.required'                      => '일반회원최대출금금액은 필수 입력 항목입니다.',
            'gnrl_mxmm_defray_am.numeric'                       => '일반회원최대출금금액은 숫자만 입력하세요.',
            'new_mumm_rcpmny_am.required'                       => '신규원최소입금금액은 필수 입력 항목입니다.',
            'new_mumm_rcpmny_am.numeric'                        => '신규회원최소입금금액은 숫자만 입력하세요.',
            'new_mxmm_rcpmny_am.required'                       => '신규회원최대입금금액은 필수 입력 항목입니다.',
            'new_mxmm_rcpmny_am.numeric'                        => '신규회원최대입금금액은 숫자만 입력하세요.',
            'new_mumm_defray_am.required'                       => '신규회원최소출금금액은 필수 입력 항목입니다.',
            'new_mumm_defray_am.numeric'                        => '신규회원최소출금금액은 숫자만 입력하세요.',
            'new_mxmm_defray_am.required'                       => '신규회원최대출금금액은 필수 입력 항목입니다.',
            'new_mxmm_defray_am.numeric'                        => '신규회원최대출금금액은 숫자만 입력하세요.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => $validator->errors()->first()], 400));
    }
}
