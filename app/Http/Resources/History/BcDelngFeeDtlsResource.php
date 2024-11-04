<?php

namespace App\Http\Resources\History;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcDelngFeeDtlsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('CoinAdminDealingsFeeDetailsGet')) {
            return [
                'delng_fee_dtls_id'             => $this->delng_fee_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => (empty($this->bcMber))?null:$this->bcMber->login_id,
                'nm'                            => (empty($this->bcMber))?null:$this->bcMber->nm,
                'mngr_id'                       => $this->mngr_id,
                'prtnr_nm'                      => $this->bcMngr->prtnr_nm,
                'code'                          => $this->bcMngr->code,
                'mber_delng_dtls_id'            => $this->mber_delng_dtls_id,
                'ca_delng_dtls_id'              => $this->ca_delng_dtls_id,
                'delng_se'                      => $this->delng_se,
                'delng_no'                      => $this->delng_no,
                'mber_grd'                      => $this->mber_grd,
                'csby_fee_policy'               => $this->csby_fee_policy,
                'purchs_fee_policy'             => $this->purchs_fee_policy,
                'sle_fee_policy'                => $this->sle_fee_policy,
                'csby_fee'                      => $this->csby_fee,
                'purchs_fee'                    => $this->purchs_fee,
                'sle_fee'                       => $this->sle_fee,
                'fee_blce'                      => $this->fee_blce,
                'ca_coin_blce'                  => $this->ca_coin_blce
            ];
        }
        else if($request->route()->named('CoinDealingsFeeDetailsGet')) {
            return [
                'delng_fee_dtls_id'             => $this->delng_fee_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => (empty($this->bcMber))?null:$this->bcMber->login_id,
                'nm'                            => (empty($this->bcMber))?null:$this->bcMber->nm,
                'mngr_id'                       => $this->mngr_id,
                'mber_delng_dtls_id'            => $this->mber_delng_dtls_id,
                'ca_delng_dtls_id'              => $this->ca_delng_dtls_id,
                'delng_se'                      => $this->delng_se,
                'delng_no'                      => $this->delng_no,
                'mber_grd'                      => $this->mber_grd,
                'csby_fee_policy'               => $this->csby_fee_policy,
                'purchs_fee_policy'             => $this->purchs_fee_policy,
                'sle_fee_policy'                => $this->sle_fee_policy,
                'csby_fee'                      => $this->csby_fee,
                'purchs_fee'                    => $this->purchs_fee,
                'sle_fee'                       => $this->sle_fee,
                'fee_blce'                      => $this->fee_blce,
                'ca_coin_blce'                  => $this->ca_coin_blce
            ];
        }
        else
        {
            return [
                'delng_fee_dtls_id'             => $this->delng_fee_dtls_id,
                'mber_id'                       => $this->mber_id,
                'mngr_id'                       => $this->mngr_id,
                'mber_delng_dtls_id'            => $this->mber_delng_dtls_id,
                'ca_delng_dtls_id'              => $this->ca_delng_dtls_id,
                'delng_se'                      => $this->delng_se,
                'delng_no'                      => $this->delng_no,
                'mber_grd'                      => $this->mber_grd,
                'csby_fee_policy'               => $this->csby_fee_policy,
                'purchs_fee_policy'             => $this->purchs_fee_policy,
                'sle_fee_policy'                => $this->sle_fee_policy,
                'csby_fee'                      => $this->csby_fee,
                'purchs_fee'                    => $this->purchs_fee,
                'sle_fee'                       => $this->sle_fee,
                'fee_blce'                      => $this->fee_blce,
                'ca_coin_blce'                  => $this->ca_coin_blce
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcDelngFeeDtlsResource",
 *
 *      @OA\Property(
 *          property="delng_fee_dtls_id", type="integer", example="1", description="거래수수료내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="CA거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="csby_fee_policy", type="integer", example="100", description="건당수수료정책",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_policy", type="float", example="100", description="구매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_policy", type="float", example="100", description="판매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="integer", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="integer", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="fee_blce", type="integer", example="1000", description="수수료잔액"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_blce", type="integer", example="1000", description="CA코인잔액"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminDealingsFeeDetailsGet_BcDelngFeeDtlsResource",
 *
 *      @OA\Property(
 *          property="delng_fee_dtls_id", type="integer", example="1", description="거래수수료내역ID",
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
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="CA거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="csby_fee_policy", type="integer", example="100", description="건당수수료정책",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_policy", type="float", example="100", description="구매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_policy", type="float", example="100", description="판매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="integer", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="integer", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="fee_blce", type="integer", example="1000", description="수수료잔액"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_blce", type="integer", example="1000", description="CA코인잔액"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinDealingsFeeDetailsGet_BcDelngFeeDtlsResource",
 *
 *      @OA\Property(
 *          property="delng_fee_dtls_id", type="integer", example="1", description="거래수수료내역ID",
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
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="CA거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="delng_se", type="string", example="1", description="거래구분(BC004)"
 *      ),
 *      @OA\Property(
 *          property="delng_no", type="string", example="12331224141", description="거래번호"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="csby_fee_policy", type="integer", example="100", description="건당수수료정책",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_policy", type="float", example="100", description="구매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_policy", type="float", example="100", description="판매수수료정책",
 *      ),
 *      @OA\Property(
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="integer", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="integer", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="fee_blce", type="integer", example="1000", description="수수료잔액"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_blce", type="integer", example="1000", description="CA코인잔액"
 *      ),
 * )
 */

