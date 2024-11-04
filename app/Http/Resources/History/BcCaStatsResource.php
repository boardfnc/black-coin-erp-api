<?php

namespace App\Http\Resources\History;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcCaStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('StatisticsAdminDatesGet')) {
            return [
                'ca_stats_id'                   => $this->ca_stats_id,
                'mngr_id'                       => $this->mngr_id,
                'prtnr_nm'                      => $this->bcMngr->prtnr_nm,
                'code'                          => $this->bcMngr->code,
                'stats_de'                      => $this->stats_de,
                'purchs_co'                     => $this->purchs_co,
                'purchs_qy'                     => $this->purchs_qy,
                'sle_co'                        => $this->sle_co,
                'sle_qy'                        => $this->sle_qy,
                'rirvl_qy'                      => $this->rirvl_qy,
                'csby_fee_am'                   => $this->csby_fee_am,
                'purchs_fee_am'                 => $this->purchs_fee_am,
                'sle_fee_am'                    => $this->sle_fee_am
            ];
        }
        else if($request->route()->named('StatisticsDatesGet')) {
            return [
                'ca_stats_id'                   => $this->ca_stats_id,
                'mngr_id'                       => $this->mngr_id,
                'stats_de'                      => $this->stats_de,
                'purchs_co'                     => $this->purchs_co,
                'purchs_qy'                     => $this->purchs_qy,
                'sle_co'                        => $this->sle_co,
                'sle_qy'                        => $this->sle_qy,
                'rirvl_qy'                      => $this->rirvl_qy,
                'csby_fee_am'                   => $this->csby_fee_am,
                'purchs_fee_am'                 => $this->purchs_fee_am,
                'sle_fee_am'                    => $this->sle_fee_am
            ];
        }
        else
        {
            return [
                'ca_stats_id'                   => $this->ca_stats_id,
                'mngr_id'                       => $this->mngr_id,
                'stats_de'                      => $this->stats_de,
                'purchs_co'                     => $this->purchs_co,
                'purchs_qy'                     => $this->purchs_qy,
                'sle_co'                        => $this->sle_co,
                'sle_qy'                        => $this->sle_qy,
                'rirvl_qy'                      => $this->rirvl_qy,
                'csby_fee_am'                   => $this->csby_fee_am,
                'purchs_fee_am'                 => $this->purchs_fee_am,
                'sle_fee_am'                    => $this->sle_fee_am
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcCaStatsResource",
 *
 *      @OA\Property(
 *          property="ca_stats_id", type="integer", example="1", description="CA통계ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="stats_de", type="string", example="2023-01-01", description="통계일자"
 *      ),
 *      @OA\Property(
 *          property="purchs_co", type="integer", example="1", description="구매건수",
 *      ),
 *      @OA\Property(
 *          property="purchs_qy", type="integer", example="1", description="구매수량",
 *      ),
 *      @OA\Property(
 *          property="sle_co", type="integer", example="1", description="판매건수",
 *      ),
 *      @OA\Property(
 *          property="sle_qy", type="integer", example="1", description="판매수량",
 *      ),
 *      @OA\Property(
 *          property="rirvl_qy", type="integer", example="100", description="회수수량",
 *      ),
 *      @OA\Property(
 *          property="csby_fee_am", type="integer", example="100", description="건당수수료금액",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_am", type="integer", example="100", description="구매수수료금액",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_am", type="integer", example="100", description="판매수수료금액",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="StatisticsAdminDatesGet_BcCaStatsResource",
 *
 *      @OA\Property(
 *          property="ca_stats_id", type="integer", example="1", description="CA통계ID",
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
 *          property="stats_de", type="string", example="2023-01-01", description="통계일자"
 *      ),
 *      @OA\Property(
 *          property="purchs_co", type="integer", example="1", description="구매건수",
 *      ),
 *      @OA\Property(
 *          property="purchs_qy", type="integer", example="1", description="구매수량",
 *      ),
 *      @OA\Property(
 *          property="sle_co", type="integer", example="1", description="판매건수",
 *      ),
 *      @OA\Property(
 *          property="sle_qy", type="integer", example="1", description="판매수량",
 *      ),
 *      @OA\Property(
 *          property="rirvl_qy", type="integer", example="100", description="회수수량",
 *      ),
 *      @OA\Property(
 *          property="csby_fee_am", type="integer", example="100", description="건당수수료금액",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_am", type="integer", example="100", description="구매수수료금액",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_am", type="integer", example="100", description="판매수수료금액",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="StatisticsDatesGet_BcCaStatsResource",
 *
 *      @OA\Property(
 *          property="ca_stats_id", type="integer", example="1", description="CA통계ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="stats_de", type="string", example="2023-01-01", description="통계일자"
 *      ),
 *      @OA\Property(
 *          property="purchs_co", type="integer", example="1", description="구매건수",
 *      ),
 *      @OA\Property(
 *          property="purchs_qy", type="integer", example="1", description="구매수량",
 *      ),
 *      @OA\Property(
 *          property="sle_co", type="integer", example="1", description="판매건수",
 *      ),
 *      @OA\Property(
 *          property="sle_qy", type="integer", example="1", description="판매수량",
 *      ),
 *      @OA\Property(
 *          property="rirvl_qy", type="integer", example="100", description="회수수량",
 *      ),
 *      @OA\Property(
 *          property="csby_fee_am", type="integer", example="100", description="건당수수료금액",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee_am", type="integer", example="100", description="구매수수료금액",
 *      ),
 *      @OA\Property(
 *          property="sle_fee_am", type="integer", example="100", description="판매수수료금액",
 *      ),
 * )
 */
