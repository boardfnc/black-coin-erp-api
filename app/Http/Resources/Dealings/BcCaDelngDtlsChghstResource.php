<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcCaDelngDtlsChghstResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('CoinAdminPurchaseManagerHistoryGet')) {
            return [
                'ca_delng_dtls_chghst_id'   => $this->ca_delng_dtls_chghst_id,
                'ca_delng_dtls_id'          => $this->ca_delng_dtls_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_sttus'               => $this->delng_sttus,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'created_at'                => $this->created_at->toDateTimeString()
            ];
        }
        else if($request->route()->named('CoinAdminSaleManagerHistoryGet')) {
            return [
                'ca_delng_dtls_chghst_id'   => $this->ca_delng_dtls_chghst_id,
                'ca_delng_dtls_id'          => $this->ca_delng_dtls_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_sttus'               => $this->delng_sttus,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'created_at'                => $this->created_at->toDateTimeString()
            ];
        }
        else if($request->route()->named('DealingsAdminManagerDetailHistoryGet')) {
            return [
                'ca_delng_dtls_chghst_id'   => $this->ca_delng_dtls_chghst_id,
                'ca_delng_dtls_id'          => $this->ca_delng_dtls_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_sttus'               => $this->delng_sttus,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'created_at'                => $this->created_at->toDateTimeString()
            ];
        }
        else if($request->route()->named('DealingsManagerDetailHistoryGet')) {
            return [
                'ca_delng_dtls_chghst_id'   => $this->ca_delng_dtls_chghst_id,
                'ca_delng_dtls_id'          => $this->ca_delng_dtls_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_sttus'               => $this->delng_sttus,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am,
                'created_at'                => $this->created_at->toDateTimeString()
            ];
        }
        else
        {
            return [
                'ca_delng_dtls_chghst_id'   => $this->ca_delng_dtls_chghst_id,
                'ca_delng_dtls_id'          => $this->ca_delng_dtls_id,
                'mngr_id'                   => $this->mngr_id,
                'delng_sttus'               => $this->delng_sttus,
                'hold_qy'                   => $this->hold_qy,
                'delng_qy'                  => $this->delng_qy,
                'bnus_qy'                   => $this->bnus_qy,
                'compt_qy'                  => $this->compt_qy,
                'pymnt_am'                  => $this->pymnt_am
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcCaDelngDtlsChghstResource",
 *
 *      @OA\Property(
 *          property="ca_delng_dtls_chghst_id", type="integer", example="1", description="CA거래내역변경이력ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
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
 *      schema="CoinAdminPurchaseManagerHistoryGet_BcCaDelngDtlsChghstResource",
 *
 *      @OA\Property(
 *          property="ca_delng_dtls_chghst_id", type="integer", example="1", description="CA거래내역변경이력ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
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
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="CoinAdminSaleManagerHistoryGet_BcCaDelngDtlsChghstResource",
 *
 *      @OA\Property(
 *          property="ca_delng_dtls_chghst_id", type="integer", example="1", description="CA거래내역변경이력ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
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
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsAdminManagerDetailHistoryGet_BcCaDelngDtlsChghstResource",
 *
 *      @OA\Property(
 *          property="ca_delng_dtls_chghst_id", type="integer", example="1", description="CA거래내역변경이력ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
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
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="DealingsManagerDetailHistoryGet_BcCaDelngDtlsChghstResource",
 *
 *      @OA\Property(
 *          property="ca_delng_dtls_chghst_id", type="integer", example="1", description="CA거래내역변경이력ID",
 *      ),
 *      @OA\Property(
 *          property="ca_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="delng_sttus", type="string", example="1", description="거래상태(BC008)"
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
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */
