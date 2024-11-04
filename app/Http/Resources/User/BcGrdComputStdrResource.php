<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcGrdComputStdrResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('MemberMemberGradeGet')) {
            return [
                'grd_comput_stdr_id'        => $this->grd_comput_stdr_id,
                'mngr_id'                   => $this->mngr_id,
                'comput_stdr_se'            => $this->comput_stdr_se,
                'vvip_stdr'                 => $this->vvip_stdr,
                'vip_stdr'                  => $this->vip_stdr,
                'gnrl_stdr'                 => $this->gnrl_stdr
            ];
        }
        else
        {
            return [
                'grd_comput_stdr_id'        => $this->grd_comput_stdr_id,
                'mngr_id'                   => $this->mngr_id,
                'comput_stdr_se'            => $this->comput_stdr_se,
                'vvip_stdr'                 => $this->vvip_stdr,
                'vip_stdr'                  => $this->vip_stdr,
                'gnrl_stdr'                 => $this->gnrl_stdr
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcGrdComputStdrResource",
 *
 *      @OA\Property(
 *          property="grd_comput_stdr_id", type="integer", example="1", description="등급산출기준ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="comput_stdr_se", type="string", example="1", description="산출기준구분(BC010)"
 *      ),
 *      @OA\Property(
 *          property="vvip_stdr", type="integer", example="100", description="vvip기준",
 *      ),
 *      @OA\Property(
 *          property="vip_stdr", type="float", example="1000", description="vip기준"
 *      ),
 *      @OA\Property(
 *          property="gnrl_stdr", type="float", example="1000", description="일반기준"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberMemberGradeGet_BcGrdComputStdrResource",
 *
 *      @OA\Property(
 *          property="grd_comput_stdr_id", type="integer", example="1", description="등급산출기준ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="comput_stdr_se", type="string", example="1", description="산출기준구분(BC010)"
 *      ),
 *      @OA\Property(
 *          property="vvip_stdr", type="integer", example="100", description="vvip기준",
 *      ),
 *      @OA\Property(
 *          property="vip_stdr", type="float", example="1000", description="vip기준"
 *      ),
 *      @OA\Property(
 *          property="gnrl_stdr", type="float", example="1000", description="일반기준"
 *      ),
 * )
 */
