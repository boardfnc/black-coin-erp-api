<?php

namespace App\Http\Resources\Dealings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberRtrvlDtlsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('MemberAdminRetrievalMembersGet')) {
            return [
                'mber_rirvl_dtls_id'            => $this->mber_rirvl_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => $this->bcMber->login_id,
                'mber_sttus'                    => $this->mber_sttus,
                'mber_grd'                      => $this->mber_grd,
                'prtnr_nm'                      => $this->bcMngr->prtnr_nm,
                'code'                          => $this->bcMngr->code,
                'rirvl_login_id'                => $this->bcRirvlMngr->login_id,
                'hold_coin'                     => $this->hold_coin,
                'tot_purchs_am'                 => $this->tot_purchs_am,
                'tot_sle_am'                    => $this->tot_sle_am,
                'rtrvl_coin'                    => $this->rtrvl_coin,
                'created_at'                    => $this->created_at->toDateTimeString()
            ];
        }
        else if($request->route()->named('MemberRetrievalMembersGet')) {
            return [
                'mber_rirvl_dtls_id'            => $this->mber_rirvl_dtls_id,
                'mber_id'                       => $this->mber_id,
                'login_id'                      => $this->bcMber->login_id,
                'mber_sttus'                    => $this->mber_sttus,
                'mber_grd'                      => $this->mber_grd,
                'rirvl_login_id'                => $this->bcRirvlMngr->login_id,
                'hold_coin'                     => $this->hold_coin,
                'tot_purchs_am'                 => $this->tot_purchs_am,
                'tot_sle_am'                    => $this->tot_sle_am,
                'rtrvl_coin'                    => $this->rtrvl_coin,
                'created_at'                    => $this->created_at->toDateTimeString()
            ];
        }
        else
        {
            return [
                'mber_rirvl_dtls_id'            => $this->mber_rirvl_dtls_id,
                'mber_id'                       => $this->mber_id,
                'mngr_id'                       => $this->mngr_id,
                'mber_sttus'                    => $this->mber_sttus,
                'mber_grd'                      => $this->mber_grd,
                'hold_coin'                     => $this->hold_coin,
                'tot_purchs_am'                 => $this->tot_purchs_am,
                'tot_sle_am'                    => $this->tot_sle_am,
                'rtrvl_coin'                    => $this->rtrvl_coin,
                'memo'                          => $this->memo
            ];
        }
    }
}

/**
 * @OA\Schema(
 *      schema="BcMberRtrvlDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_rirvl_dtls_id", type="integer", example="1", description="회원회수내역ID",
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
 *          property="rtrvl_coin", type="integer", example="100", description="회수코인",
 *      ),
 *      @OA\Property(
 *          property="memo", type="string", example="메모", description="메모"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminRetrievalMembersGet_BcMberRtrvlDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_rirvl_dtls_id", type="integer", example="1", description="회원회수내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="mber_sttus", type="string", example="1", description="회원상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="rirvl_login_id", type="string", example="test", description="회수로그인ID"
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
 *          property="rtrvl_coin", type="integer", example="100", description="회수코인",
 *      ),
 *      @OA\Property(
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberRetrievalMembersGet_BcMberRtrvlDtlsResource",
 *
 *      @OA\Property(
 *          property="mber_rirvl_dtls_id", type="integer", example="1", description="회원회수내역ID",
 *      ),
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="mber_sttus", type="string", example="1", description="회원상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="rirvl_login_id", type="string", example="test", description="회수로그인ID"
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
 *          property="rtrvl_coin", type="integer", example="100", description="회수코인",
 *      ),
 *      @OA\Property(
 *          property="created_at", type="string", example="1900-01-01 00:00:00", description="등록일시"
 *      ),
 * )
 */
