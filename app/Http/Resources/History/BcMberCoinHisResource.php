<?php

namespace App\Http\Resources\History;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberCoinHisResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'mber_coin_his_id'              => $this->mber_coin_his_id,
            'mber_id'                       => $this->mber_id,
            'mber_delng_dtls_id'            => $this->mber_delng_dtls_id,
            'mber_exchng_dtls_id'           => $this->mber_exchng_dtls_id,
            'mber_rirvl_dtls_id'            => $this->mber_rirvl_dtls_id,
            'mber_pymnt_dtls_id'            => $this->mber_pymnt_dtls_id,
            'coin_se'                       => $this->coin_se,
            'pymnt_coin'                    => $this->pymnt_coin,
            'ddct_coin'                     => $this->ddct_coin,
            'coin'                          => $this->coin
        ];
    }
}

/**
 * @OA\Schema(
 *      schema="BcMberCoinHisResource",
 *
 *      @OA\Property(
 *          property="mber_coin_his_id", type="integer", example="1", description="회원코인이력ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="mber_delng_dtls_id", type="integer", example="1", description="회원거래내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_exchng_dtls_id", type="integer", example="1", description="회원교환내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_rirvl_dtls_id", type="integer", example="1", description="회원회수내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_pymnt_dtls_id", type="integer", example="1", description="회원지급내역ID",
 *      ),
 *      @OA\Property(
 *          property="coin_se", type="string", example="1", description="코인구분(BC007)"
 *      ),
 *      @OA\Property(
 *          property="pymnt_coin", type="integer", example="100", description="지급코인",
 *      ),
 *      @OA\Property(
 *          property="ddct_coin", type="integer", example="100", description="차감코인",
 *      ),
 *      @OA\Property(
 *          property="coin", type="integer", example="100", description="코인",
 *      ),
 * )
 */