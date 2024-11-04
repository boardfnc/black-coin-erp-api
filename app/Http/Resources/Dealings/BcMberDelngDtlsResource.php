<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberDelngDtlsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('CoinAdminPurchaseMembersGet')) {
            return [
                'mber_delng_dtls_id'        => $this->mber_delng_dtls_id,
                'mber_id'                   => $this->mber_id,
                'login_id'                  => $this->bcMber->login_id,
                'nm'                        => $this->bcMber->nm,
                'mngr_id'                   => $this->mngr_id,
                'prtnr_nm'                  => $this->bcMngr->prtnr_nm,
                'delng_se'                  => $this->delng_se,
                'delng_sttus'               => $this->delng_sttus,
                'delng_no'                  => $this->delng_no,
                'rcpmny_bank'               => $this->rcpmny_bank,
                'rcpmny_dpstr'              => $this->rcpmny_dpstr,
                'rcpmny_acnutno'            => $this->rcpmny_acnutno,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'today_purchs_co'           => $this->today_purchs_co
            ];
        }
        else if($request->route()->named('CoinAdminSaleMembersGet')) {
            return [
                'mber_delng_dtls_id'        => $this->mber_delng_dtls_id,
                'mber_id'                   => $this->mber_id,
                'login_id'                  => $this->bcMber->login_id,
                'nm'                        => $this->bcMber->nm,
                'mngr_id'                   => $this->mngr_id,
                'prtnr_nm'                  => $this->bcMngr->prtnr_nm,
                'delng_se'                  => $this->delng_se,
                'delng_sttus'               => $this->delng_sttus,
                'delng_no'                  => $this->delng_no,
                'rcpmny_bank'               => $this->rcpmny_bank,
                'rcpmny_dpstr'              => $this->rcpmny_dpstr,
                'rcpmny_acnutno'            => $this->rcpmny_acnutno,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am
            ];
        }
        else if($request->route()->named('DealingsAdminMemberDetailsGet')) {
            return [
                'mber_delng_dtls_id'        => $this->mber_delng_dtls_id,
                'mber_id'                   => $this->mber_id,
                'login_id'                  => $this->bcMber->login_id,
                'nm'                        => $this->bcMber->nm,
                'delng_se'                  => $this->delng_se,
                'delng_sttus'               => $this->delng_sttus,
                'delng_no'                  => $this->delng_no,
                'rcpmny_bank'               => $this->rcpmny_bank,
                'rcpmny_dpstr'              => $this->rcpmny_dpstr,
                'rcpmny_acnutno'            => $this->rcpmny_acnutno,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am
            ];
        }
        else
        {
            return [
                'mber_delng_dtls_id'        => $this->mber_delng_dtls_id,
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_se'                  => $this->delng_se,
                'delng_sttus'               => $this->delng_sttus,
                'delng_no'                  => $this->delng_no,
                'rcpmny_bank'               => $this->rcpmny_bank,
                'rcpmny_dpstr'              => $this->rcpmny_dpstr,
                'rcpmny_acnutno'            => $this->rcpmny_acnutno,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'today_purchs_co'           => $this->today_purchs_co
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcMberDelngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_bank", type="string", example="1", description="입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_dpstr", type="string", example="예금주", description="입금예금주"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_acnutno", type="string", example="156549841555", description="입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="bank", type="string", example="1", description="은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="dpstr", type="string", example="예금주", description="예금주"
 *      ),
 *      @OA\Property(
 *          property="acnutno", type="string", example="156549841555", description="계좌번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_qy", type="integer", example="100", description="보유수량",
 *      ),
 *      @OA\Property(
 *          property="delng_qy", type="integer", example="100", description="거래수량",
 *      ),
 *      @OA\Property(
 *          property="bnus_qy", type="integer", example="100", description="보너스수량",
 *      ),
 *      @OA\Property(
 *          property="compt_qy", type="integer", example="100", description="완료수량",
 *      ),
 *      @OA\Property(
 *          property="pymnt_am", type="integer", example="100", description="지급금액",
 *      ),
 *      @OA\Property(
 *          property="today_purchs_co", type="integer", example="100", description="당일구매횟수",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminPurchaseMembersGet_BcMberDelngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="nm", type="string", example="회원명", description="회원명"
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_bank", type="string", example="1", description="입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_dpstr", type="string", example="예금주", description="입금예금주"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_acnutno", type="string", example="156549841555", description="입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="bank", type="string", example="1", description="은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="dpstr", type="string", example="예금주", description="예금주"
 *      ),
 *      @OA\Property(
 *          property="acnutno", type="string", example="156549841555", description="계좌번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_qy", type="integer", example="100", description="보유수량",
 *      ),
 *      @OA\Property(
 *          property="delng_qy", type="integer", example="100", description="거래수량",
 *      ),
 *      @OA\Property(
 *          property="bnus_qy", type="integer", example="100", description="보너스수량",
 *      ),
 *      @OA\Property(
 *          property="compt_qy", type="integer", example="100", description="완료수량",
 *      ),
 *      @OA\Property(
 *          property="pymnt_am", type="integer", example="100", description="지급금액",
 *      ),
 *      @OA\Property(
 *          property="today_purchs_co", type="integer", example="100", description="당일구매횟수",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleMembersGet_BcMberDelngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="nm", type="string", example="회원명", description="회원명"
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_bank", type="string", example="1", description="입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_dpstr", type="string", example="예금주", description="입금예금주"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_acnutno", type="string", example="156549841555", description="입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="bank", type="string", example="1", description="은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="dpstr", type="string", example="예금주", description="예금주"
 *      ),
 *      @OA\Property(
 *          property="acnutno", type="string", example="156549841555", description="계좌번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_qy", type="integer", example="100", description="보유수량",
 *      ),
 *      @OA\Property(
 *          property="delng_qy", type="integer", example="100", description="거래수량",
 *      ),
 *      @OA\Property(
 *          property="bnus_qy", type="integer", example="100", description="보너스수량",
 *      ),
 *      @OA\Property(
 *          property="compt_qy", type="integer", example="100", description="완료수량",
 *      ),
 *      @OA\Property(
 *          property="pymnt_am", type="integer", example="100", description="지급금액",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminMemberDetailsGet_BcMberDelngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="nm", type="string", example="회원명", description="회원명"
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_bank", type="string", example="1", description="입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_dpstr", type="string", example="예금주", description="입금예금주"
 *      ),
 *      @OA\Property(
 *          property="rcpmny_acnutno", type="string", example="156549841555", description="입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="bank", type="string", example="1", description="은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="dpstr", type="string", example="예금주", description="예금주"
 *      ),
 *      @OA\Property(
 *          property="acnutno", type="string", example="156549841555", description="계좌번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_qy", type="integer", example="100", description="보유수량",
 *      ),
 *      @OA\Property(
 *          property="delng_qy", type="integer", example="100", description="거래수량",
 *      ),
 *      @OA\Property(
 *          property="bnus_qy", type="integer", example="100", description="보너스수량",
 *      ),
 *      @OA\Property(
 *          property="compt_qy", type="integer", example="100", description="완료수량",
 *      ),
 *      @OA\Property(
 *          property="pymnt_am", type="integer", example="100", description="지급금액",
 *      ),
 * )
 */
