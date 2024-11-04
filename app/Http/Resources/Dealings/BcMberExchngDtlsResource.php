<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberExchngDtlsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('CoinAdminReceivedDetailsGet')) {
            return [
                'mber_exchng_dtls_id'           => $this->mber_exchng_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => $this->bcMber->login_id,
                'nm'                            => $this->bcMber->nm,
                'mngr_id'                       => $this->mngr_id,
                'prtnr_nm'                      => $this->bcMngr->prtnr_nm,
                'code'                          => $this->bcMngr->code,
                'exchng_se'                     => $this->exchng_se,
                'mber_grd'                      => $this->mber_grd,
                'ca_coin_bnt'                   => $this->ca_coin_bnt,
                'mber_coin_bnt'                 => $this->mber_coin_bnt,
                'send_coin_qy'                  => $this->send_coin_qy,
                'receive_coin_qy'               => $this->receive_coin_qy,
                'send_money_qy'                 => $this->send_money_qy,
                'receive_money_qy'              => $this->receive_money_qy
            ];
        }
        else if($request->route()->named('CoinAdminSentDetailsGet')) {
            return [
                'mber_exchng_dtls_id'           => $this->mber_exchng_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => $this->bcMber->login_id,
                'nm'                            => $this->bcMber->nm,
                'mngr_id'                       => $this->mngr_id,
                'prtnr_nm'                      => $this->bcMngr->prtnr_nm,
                'code'                          => $this->bcMngr->code,
                'exchng_se'                     => $this->exchng_se,
                'mber_grd'                      => $this->mber_grd,
                'ca_coin_bnt'                   => $this->ca_coin_bnt,
                'mber_coin_bnt'                 => $this->mber_coin_bnt,
                'send_coin_qy'                  => $this->send_coin_qy,
                'receive_coin_qy'               => $this->receive_coin_qy,
                'send_money_qy'                 => $this->send_money_qy,
                'receive_money_qy'              => $this->receive_money_qy
            ];
        }
        else if($request->route()->named('CoinReceivedDetailsGet')) {
            return [
                'mber_exchng_dtls_id'           => $this->mber_exchng_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => $this->bcMber->login_id,
                'nm'                            => $this->bcMber->nm,
                'mngr_id'                       => $this->mngr_id,
                'exchng_se'                     => $this->exchng_se,
                'mber_grd'                      => $this->mber_grd,
                'ca_coin_bnt'                   => $this->ca_coin_bnt,
                'mber_coin_bnt'                 => $this->mber_coin_bnt,
                'send_coin_qy'                  => $this->send_coin_qy,
                'receive_coin_qy'               => $this->receive_coin_qy,
                'send_money_qy'                 => $this->send_money_qy,
                'receive_money_qy'              => $this->receive_money_qy
            ];
        }
        else
        {
            return [
                'mber_exchng_dtls_id'           => $this->mber_exchng_dtls_id,
                'mber_id'                       => $this->mber_id,
                'mngr_id'                       => $this->mngr_id,
                'exchng_se'                     => $this->exchng_se,
                'mber_grd'                      => $this->mber_grd,
                'ca_coin_bnt'                   => $this->ca_coin_bnt,
                'mber_coin_bnt'                 => $this->mber_coin_bnt,
                'send_coin_qy'                  => $this->send_coin_qy,
                'receive_coin_qy'               => $this->receive_coin_qy,
                'send_money_qy'                 => $this->send_money_qy,
                'receive_money_qy'              => $this->receive_money_qy
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcMberExchngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="exchng_se", type="string", example="1", description="교환구분(BC009)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_bnt", type="integer", example="100", description="CA코인잔량",
 *      ),
 *      @OA\Property(
 *          property="mber_coin_bnt", type="integer", example="100", description="회원코인잔량",
 *      ),
 *      @OA\Property(
 *          property="send_coin_qy", type="integer", example="100", description="보낸코인수량",
 *      ),
 *      @OA\Property(
 *          property="receive_coin_qy", type="integer", example="100", description="받은코인수량",
 *      ),
 *      @OA\Property(
 *          property="send_money_qy", type="integer", example="100", description="보낸머니수량",
 *      ),
 *      @OA\Property(
 *          property="receive_money_qy", type="integer", example="100", description="받은머니수량",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminReceivedDetailsGet_BcMberExchngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
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
 *          property="exchng_se", type="string", example="1", description="교환구분(BC009)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_bnt", type="integer", example="100", description="CA코인잔량",
 *      ),
 *      @OA\Property(
 *          property="mber_coin_bnt", type="integer", example="100", description="회원코인잔량",
 *      ),
 *      @OA\Property(
 *          property="send_coin_qy", type="integer", example="100", description="보낸코인수량",
 *      ),
 *      @OA\Property(
 *          property="receive_coin_qy", type="integer", example="100", description="받은코인수량",
 *      ),
 *      @OA\Property(
 *          property="send_money_qy", type="integer", example="100", description="보낸머니수량",
 *      ),
 *      @OA\Property(
 *          property="receive_money_qy", type="integer", example="100", description="받은머니수량",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSentDetailsGet_BcMberExchngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
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
 *          property="exchng_se", type="string", example="1", description="교환구분(BC009)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_bnt", type="integer", example="100", description="CA코인잔량",
 *      ),
 *      @OA\Property(
 *          property="mber_coin_bnt", type="integer", example="100", description="회원코인잔량",
 *      ),
 *      @OA\Property(
 *          property="send_coin_qy", type="integer", example="100", description="보낸코인수량",
 *      ),
 *      @OA\Property(
 *          property="receive_coin_qy", type="integer", example="100", description="받은코인수량",
 *      ),
 *      @OA\Property(
 *          property="send_money_qy", type="integer", example="100", description="보낸머니수량",
 *      ),
 *      @OA\Property(
 *          property="receive_money_qy", type="integer", example="100", description="받은머니수량",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinReceivedDetailsGet_BcMberExchngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
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
 *          property="exchng_se", type="string", example="1", description="교환구분(BC009)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_bnt", type="integer", example="100", description="CA코인잔량",
 *      ),
 *      @OA\Property(
 *          property="mber_coin_bnt", type="integer", example="100", description="회원코인잔량",
 *      ),
 *      @OA\Property(
 *          property="send_coin_qy", type="integer", example="100", description="보낸코인수량",
 *      ),
 *      @OA\Property(
 *          property="receive_coin_qy", type="integer", example="100", description="받은코인수량",
 *      ),
 *      @OA\Property(
 *          property="send_money_qy", type="integer", example="100", description="보낸머니수량",
 *      ),
 *      @OA\Property(
 *          property="receive_money_qy", type="integer", example="100", description="받은머니수량",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinSentDetailsGet_BcMberExchngDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
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
 *          property="exchng_se", type="string", example="1", description="교환구분(BC009)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="ca_coin_bnt", type="integer", example="100", description="CA코인잔량",
 *      ),
 *      @OA\Property(
 *          property="mber_coin_bnt", type="integer", example="100", description="회원코인잔량",
 *      ),
 *      @OA\Property(
 *          property="send_coin_qy", type="integer", example="100", description="보낸코인수량",
 *      ),
 *      @OA\Property(
 *          property="receive_coin_qy", type="integer", example="100", description="받은코인수량",
 *      ),
 *      @OA\Property(
 *          property="send_money_qy", type="integer", example="100", description="보낸머니수량",
 *      ),
 *      @OA\Property(
 *          property="receive_money_qy", type="integer", example="100", description="받은머니수량",
 *      ),
 * )
 */
