<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcAcnutSetupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('SetupAdminAccountGet')) {
            return [
                'ca_rcpmny_bank'                    => $this->ca_rcpmny_bank,
                'ca_rcpmny_dpstr'                   => $this->ca_rcpmny_dpstr,
                'ca_rcpmny_acnutno'                 => $this->ca_rcpmny_acnutno,
                'ca_mumm_rcpmny_am'                 => $this->ca_mumm_rcpmny_am,
                'ca_mxmm_rcpmny_am'                 => $this->ca_mxmm_rcpmny_am,
                'vvip_rcpmny_bank'                  => $this->vvip_rcpmny_bank,
                'vvip_rcpmny_dpstr'                 => $this->vvip_rcpmny_dpstr,
                'vvip_rcpmny_acnutno'               => $this->vvip_rcpmny_acnutno,
                'vvip_mumm_rcpmny_am'               => $this->vvip_mumm_rcpmny_am,
                'vvip_mxmm_rcpmny_am'               => $this->vvip_mxmm_rcpmny_am,
                'vvip_mumm_defray_am'               => $this->vvip_mumm_defray_am,
                'vvip_mxmm_defray_am'               => $this->vvip_mxmm_defray_am,
                'vip_rcpmny_bank'                   => $this->vip_rcpmny_bank,
                'vip_rcpmny_dpstr'                  => $this->vip_rcpmny_dpstr,
                'vip_rcpmny_acnutno'                => $this->vip_rcpmny_acnutno,
                'vip_mumm_rcpmny_am'                => $this->vip_mumm_rcpmny_am,
                'vip_mxmm_rcpmny_am'                => $this->vip_mxmm_rcpmny_am,
                'vip_mumm_defray_am'                => $this->vip_mumm_defray_am,
                'vip_mxmm_defray_am'                => $this->vip_mxmm_defray_am,
                'gnrl_rcpmny_bank'                  => $this->gnrl_rcpmny_bank,
                'gnrl_rcpmny_dpstr'                 => $this->gnrl_rcpmny_dpstr,
                'gnrl_rcpmny_acnutno'               => $this->gnrl_rcpmny_acnutno,
                'gnrl_mumm_rcpmny_am'               => $this->gnrl_mumm_rcpmny_am,
                'gnrl_mxmm_rcpmny_am'               => $this->gnrl_mxmm_rcpmny_am,
                'gnrl_mumm_defray_am'               => $this->gnrl_mumm_defray_am,
                'gnrl_mxmm_defray_am'               => $this->gnrl_mxmm_defray_am,
                'new_rcpmny_bank'                   => $this->new_rcpmny_bank,
                'new_rcpmny_dpstr'                  => $this->new_rcpmny_dpstr,
                'new_rcpmny_acnutno'                => $this->new_rcpmny_acnutno,
                'new_mumm_rcpmny_am'                => $this->new_mumm_rcpmny_am,
                'new_mxmm_rcpmny_am'                => $this->new_mxmm_rcpmny_am,
                'new_mumm_defray_am'                => $this->new_mumm_defray_am,
                'new_mxmm_defray_am'                => $this->new_mxmm_defray_am,
            ];
        }
        else
        {
            return [
                'acnut_setup_id'                    => $this->acnut_setup_id,
                'ca_rcpmny_bank'                    => $this->ca_rcpmny_bank,
                'ca_rcpmny_dpstr'                   => $this->ca_rcpmny_dpstr,
                'ca_rcpmny_acnutno'                 => $this->ca_rcpmny_acnutno,
                'ca_mumm_rcpmny_am'                 => $this->ca_mumm_rcpmny_am,
                'ca_mxmm_rcpmny_am'                 => $this->ca_mxmm_rcpmny_am,
                'vvip_rcpmny_bank'                  => $this->vvip_rcpmny_bank,
                'vvip_rcpmny_dpstr'                 => $this->vvip_rcpmny_dpstr,
                'vvip_rcpmny_acnutno'               => $this->vvip_rcpmny_acnutno,
                'vvip_mumm_rcpmny_am'               => $this->vvip_mumm_rcpmny_am,
                'vvip_mxmm_rcpmny_am'               => $this->vvip_mxmm_rcpmny_am,
                'vvip_mumm_defray_am'               => $this->vvip_mumm_defray_am,
                'vvip_mxmm_defray_am'               => $this->vvip_mxmm_defray_am,
                'vip_rcpmny_bank'                   => $this->vip_rcpmny_bank,
                'vip_rcpmny_dpstr'                  => $this->vip_rcpmny_dpstr,
                'vip_rcpmny_acnutno'                => $this->vip_rcpmny_acnutno,
                'vip_mumm_rcpmny_am'                => $this->vip_mumm_rcpmny_am,
                'vip_mxmm_rcpmny_am'                => $this->vip_mxmm_rcpmny_am,
                'vip_mumm_defray_am'                => $this->vip_mumm_defray_am,
                'vip_mxmm_defray_am'                => $this->vip_mxmm_defray_am,
                'gnrl_rcpmny_bank'                  => $this->gnrl_rcpmny_bank,
                'gnrl_rcpmny_dpstr'                 => $this->gnrl_rcpmny_dpstr,
                'gnrl_rcpmny_acnutno'               => $this->gnrl_rcpmny_acnutno,
                'gnrl_mumm_rcpmny_am'               => $this->gnrl_mumm_rcpmny_am,
                'gnrl_mxmm_rcpmny_am'               => $this->gnrl_mxmm_rcpmny_am,
                'gnrl_mumm_defray_am'               => $this->gnrl_mumm_defray_am,
                'gnrl_mxmm_defray_am'               => $this->gnrl_mxmm_defray_am,
                'new_rcpmny_bank'                   => $this->new_rcpmny_bank,
                'new_rcpmny_dpstr'                  => $this->new_rcpmny_dpstr,
                'new_rcpmny_acnutno'                => $this->new_rcpmny_acnutno,
                'new_mumm_rcpmny_am'                => $this->new_mumm_rcpmny_am,
                'new_mxmm_rcpmny_am'                => $this->new_mxmm_rcpmny_am,
                'new_mumm_defray_am'                => $this->new_mumm_defray_am,
                'new_mxmm_defray_am'                => $this->new_mxmm_defray_am,
            ];
        }
    }
}

return [
    'acnut_setup_id'                    => $this->acnut_setup_id,
    'ca_rcpmny_bank'                    => $this->ca_rcpmny_bank,
    'ca_rcpmny_dpstr'                   => $this->ca_rcpmny_dpstr,
    'ca_rcpmny_acnutno'                 => $this->ca_rcpmny_acnutno,
    'ca_mumm_rcpmny_am'                 => $this->ca_mumm_rcpmny_am,
    'ca_mxmm_rcpmny_am'                 => $this->ca_mxmm_rcpmny_am,
    'vvip_rcpmny_bank'                  => $this->vvip_rcpmny_bank,
    'vvip_rcpmny_dpstr'                 => $this->vvip_rcpmny_dpstr,
    'vvip_rcpmny_acnutno'               => $this->vvip_rcpmny_acnutno,
    'vvip_mumm_rcpmny_am'               => $this->vvip_mumm_rcpmny_am,
    'vvip_mxmm_rcpmny_am'               => $this->vvip_mxmm_rcpmny_am,
    'vvip_mumm_defray_am'               => $this->vvip_mumm_defray_am,
    'vvip_mxmm_defray_am'               => $this->vvip_mxmm_defray_am,
    'vip_rcpmny_bank'                   => $this->vip_rcpmny_bank,
    'vip_rcpmny_dpstr'                  => $this->vip_rcpmny_dpstr,
    'vip_rcpmny_acnutno'                => $this->vip_rcpmny_acnutno,
    'vip_mumm_rcpmny_am'                => $this->vip_mumm_rcpmny_am,
    'vip_mxmm_rcpmny_am'                => $this->vip_mxmm_rcpmny_am,
    'vip_mumm_defray_am'                => $this->vip_mumm_defray_am,
    'vip_mxmm_defray_am'                => $this->vip_mxmm_defray_am,
    'gnrl_rcpmny_bank'                  => $this->gnrl_rcpmny_bank,
    'gnrl_rcpmny_dpstr'                 => $this->gnrl_rcpmny_dpstr,
    'gnrl_rcpmny_acnutno'               => $this->gnrl_rcpmny_acnutno,
    'gnrl_mumm_rcpmny_am'               => $this->gnrl_mumm_rcpmny_am,
    'gnrl_mxmm_rcpmny_am'               => $this->gnrl_mxmm_rcpmny_am,
    'gnrl_mumm_defray_am'               => $this->gnrl_mumm_defray_am,
    'gnrl_mxmm_defray_am'               => $this->gnrl_mxmm_defray_am,
    'new_rcpmny_bank'                   => $this->new_rcpmny_bank,
    'new_rcpmny_dpstr'                  => $this->new_rcpmny_dpstr,
    'new_rcpmny_acnutno'                => $this->new_rcpmny_acnutno,
    'new_mumm_rcpmny_am'                => $this->new_mumm_rcpmny_am,
    'new_mxmm_rcpmny_am'                => $this->new_mxmm_rcpmny_am,
    'new_mumm_defray_am'                => $this->new_mumm_defray_am,
    'new_mxmm_defray_am'                => $this->new_mxmm_defray_am,
];

/**
 * @OA\Schema(
 *      schema="BcAcnutSetupResource",
 *
 *      @OA\Property(
 *          property="acnut_setup_id", type="integer", example="1", description="계좌설정ID",
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_bank", type="string", example="1", description="CA입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_dpstr", type="string", example="1", description="CA입금예금주"
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_acnutno", type="string", example="1", description="CA입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="ca_mumm_rcpmny_am", type="integer", example="100", description="CA최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="ca_mxmm_rcpmny_am", type="integer", example="100", description="CA최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_bank", type="string", example="1", description="VVIP입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_dpstr", type="string", example="1", description="VVIP입금예금주"
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_acnutno", type="string", example="1", description="VVIP입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="vvip_mumm_rcpmny_am", type="integer", example="100", description="VVIP최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mxmm_rcpmny_am", type="integer", example="100", description="VVIP최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mumm_defray_am", type="integer", example="100", description="VVIP최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mxmm_defray_am", type="integer", example="100", description="VVIP최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_bank", type="string", example="1", description="VIP입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_dpstr", type="string", example="1", description="VIP입금예금주"
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_acnutno", type="string", example="1", description="VIP입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="vip_mumm_rcpmny_am", type="integer", example="100", description="VIP최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mxmm_rcpmny_am", type="integer", example="100", description="VIP최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mumm_defray_am", type="integer", example="100", description="VIP최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mxmm_defray_am", type="integer", example="100", description="VIP최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_bank", type="string", example="1", description="일반회원입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_dpstr", type="string", example="1", description="일반회원입금예금주"
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_acnutno", type="string", example="1", description="일반회원입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="gnrl_mumm_rcpmny_am", type="integer", example="100", description="일반회원최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mxmm_rcpmny_am", type="integer", example="100", description="일반회원최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mumm_defray_am", type="integer", example="100", description="일반회원최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mxmm_defray_am", type="integer", example="100", description="일반회원최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_bank", type="string", example="1", description="신규회원입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_dpstr", type="string", example="1", description="신규원입금예금주"
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_acnutno", type="string", example="1", description="신규회원입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="new_mumm_rcpmny_am", type="integer", example="100", description="신규회원최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mxmm_rcpmny_am", type="integer", example="100", description="신규회원최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mumm_defray_am", type="integer", example="100", description="신규회원최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mxmm_defray_am", type="integer", example="100", description="신규회원최대출금금액",
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="SetupAdminAccountGet_BcAcnutSetupResource",
 *
 *      @OA\Property(
 *          property="acnut_setup_id", type="integer", example="1", description="계좌설정ID",
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_bank", type="string", example="1", description="CA입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_dpstr", type="string", example="1", description="CA입금예금주"
 *      ),
 *      @OA\Property(
 *          property="ca_rcpmny_acnutno", type="string", example="1", description="CA입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="ca_mumm_rcpmny_am", type="integer", example="100", description="CA최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="ca_mxmm_rcpmny_am", type="integer", example="100", description="CA최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_bank", type="string", example="1", description="VVIP입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_dpstr", type="string", example="1", description="VVIP입금예금주"
 *      ),
 *      @OA\Property(
 *          property="vvip_rcpmny_acnutno", type="string", example="1", description="VVIP입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="vvip_mumm_rcpmny_am", type="integer", example="100", description="VVIP최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mxmm_rcpmny_am", type="integer", example="100", description="VVIP최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mumm_defray_am", type="integer", example="100", description="VVIP최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="vvip_mxmm_defray_am", type="integer", example="100", description="VVIP최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_bank", type="string", example="1", description="VIP입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_dpstr", type="string", example="1", description="VIP입금예금주"
 *      ),
 *      @OA\Property(
 *          property="vip_rcpmny_acnutno", type="string", example="1", description="VIP입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="vip_mumm_rcpmny_am", type="integer", example="100", description="VIP최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mxmm_rcpmny_am", type="integer", example="100", description="VIP최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mumm_defray_am", type="integer", example="100", description="VIP최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="vip_mxmm_defray_am", type="integer", example="100", description="VIP최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_bank", type="string", example="1", description="일반회원입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_dpstr", type="string", example="1", description="일반회원입금예금주"
 *      ),
 *      @OA\Property(
 *          property="gnrl_rcpmny_acnutno", type="string", example="1", description="일반회원입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="gnrl_mumm_rcpmny_am", type="integer", example="100", description="일반회원최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mxmm_rcpmny_am", type="integer", example="100", description="일반회원최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mumm_defray_am", type="integer", example="100", description="일반회원최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="gnrl_mxmm_defray_am", type="integer", example="100", description="일반회원최대출금금액",
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_bank", type="string", example="1", description="신규회원입금은행(BC005)"
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_dpstr", type="string", example="1", description="신규원입금예금주"
 *      ),
 *      @OA\Property(
 *          property="new_rcpmny_acnutno", type="string", example="1", description="신규회원입금계좌번호"
 *      ),
 *      @OA\Property(
 *          property="new_mumm_rcpmny_am", type="integer", example="100", description="신규회원최소입금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mxmm_rcpmny_am", type="integer", example="100", description="신규회원최대입금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mumm_defray_am", type="integer", example="100", description="신규회원최소출금금액",
 *      ),
 *      @OA\Property(
 *          property="new_mxmm_defray_am", type="integer", example="100", description="신규회원최대출금금액",
 *      ),
 * )
 */
