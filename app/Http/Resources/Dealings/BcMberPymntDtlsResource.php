<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberPymntDtlsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mber_pymnt_dtls_id'            => $this->mber_pymnt_dtls_id,
            'mber_id'                       => $this->mber_id,
            'mngr_id'                       => $this->mngr_id,
            'mber_sttus'                    => $this->mber_sttus,
            'mber_grd'                      => $this->mber_grd,
            'hold_coin'                     => $this->hold_coin,
            'tot_purchs_am'                 => $this->tot_purchs_am,
            'tot_sle_am'                    => $this->tot_sle_am,
            'pymnt_coin'                    => $this->pymnt_coin,
            'memo'                          => $this->memo
        ];
    }
}

/**
 * @OA\Schema(
 *      schema="BcMberPymntDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_pymnt_dtls_id", type="integer", example="1", description="회원지급내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mber_sttus", type="string", example="1", description="회원상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="tot_purchs_am", type="integer", example="100", description="총구매액",
 *      ),
 *      @OA\Property(
 *          property="tot_sle_am", type="integer", example="100", description="총판매액",
 *      ),
 *      @OA\Property(
 *          property="pymnt_coin", type="integer", example="100", description="지급코인",
 *      ),
 *      @OA\Property(
 *          property="memo", type="string", example="메모", description="메모"
 *      ),
 * )
 */
