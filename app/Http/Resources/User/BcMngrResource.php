<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMngrResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        if($request->route()->named('MemberAdminManagersGet')) {
            return [
                'mngr_id'                   => $this->mngr_id,
                'mngr_sttus'                => $this->mngr_sttus,
                'login_id'                  => $this->login_id,
                'code'                      => $this->code,
                'mp_no'                     => $this->mp_no,
                'prtnr_nm'                  => $this->prtnr_nm,
                'site_adres'                => $this->site_adres,
                'csby_fee'                  => $this->csby_fee,
                'purchs_fee'                => $this->purchs_fee,
                'sle_fee'                   => $this->sle_fee,
                'hold_coin'                 => $this->hold_coin,
                'tot_purchs_am'             => $this->tot_purchs_am,
                'tot_sle_am'                => $this->tot_sle_am,
                'sbscrb_dt'                 => $this->sbscrb_dt
            ];
        }
        else if($request->route()->named('MemberAdminManagerGet'))
        {
            return [
                'mngr_id'                   => $this->mngr_id,
                'mngr_se'                   => $this->mngr_se,
                'mngr_sttus'                => $this->mngr_sttus,
                'login_id'                  => $this->login_id,
                'code'                      => $this->code,
                'mp_no'                     => $this->mp_no,
                'prtnr_nm'                  => $this->prtnr_nm,
                'site_adres'                => $this->site_adres,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'csby_fee'                  => $this->csby_fee,
                'purchs_fee'                => $this->purchs_fee,
                'sle_fee'                   => $this->sle_fee,
                'hold_coin'                 => $this->hold_coin,
                'tot_purchs_am'             => $this->tot_purchs_am,
                'tot_sle_am'                => $this->tot_sle_am,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'sbscrb_ip'                 => $this->sbscrb_ip,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip,
                'last_conect_os'            => $this->last_conect_os,
                'last_conect_brwsr'         => $this->last_conect_brwsr
            ];
        }
        else if($request->route()->named('MemberAdminMemberGradesGet')) {
            return [
                'mngr_id'                   => $this->mngr_id,
                'code'                      => $this->code,
                'prtnr_nm'                  => $this->prtnr_nm,
                'mber_count'                => $this->mber_count,
                'comput_stdr_se'            => $this->bcGrdComputStdr->first()->comput_stdr_se,
                'vvip_stdr'                 => $this->bcGrdComputStdr->first()->vvip_stdr,
                'vip_stdr'                  => $this->bcGrdComputStdr->first()->vip_stdr,
                'gnrl_stdr'                 => $this->bcGrdComputStdr->first()->gnrl_stdr
            ];
        }
        else if($request->route()->named('MemberMyPageGet'))
        {
            return [
                'mngr_id'                   => $this->mngr_id,
                'mngr_se'                   => $this->mngr_se,
                'mngr_sttus'                => $this->mngr_sttus,
                'login_id'                  => $this->login_id,
                'code'                      => $this->code,
                'mp_no'                     => $this->mp_no,
                'prtnr_nm'                  => $this->prtnr_nm,
                'site_adres'                => $this->site_adres,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'csby_fee'                  => $this->csby_fee,
                'purchs_fee'                => $this->purchs_fee,
                'sle_fee'                   => $this->sle_fee,
                'hold_coin'                 => $this->hold_coin,
                'tot_purchs_am'             => $this->tot_purchs_am,
                'tot_sle_am'                => $this->tot_sle_am,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'sbscrb_ip'                 => $this->sbscrb_ip,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip,
                'last_conect_os'            => $this->last_conect_os,
                'last_conect_brwsr'         => $this->last_conect_brwsr
            ];
        }
        else
        {
            return [
                'mngr_id'                   => $this->mngr_id,
                'mngr_se'                   => $this->mngr_se,
                'mngr_sttus'                => $this->mngr_sttus,
                'login_id'                  => $this->login_id,
                'code'                      => $this->code,
                'mp_no'                     => $this->mp_no,
                'prtnr_nm'                  => $this->prtnr_nm,
                'site_adres'                => $this->site_adres,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'csby_fee'                  => $this->csby_fee,
                'purchs_fee'                => $this->purchs_fee,
                'sle_fee'                   => $this->sle_fee,
                'hold_coin'                 => $this->hold_coin,
                'tot_purchs_am'             => $this->tot_purchs_am,
                'tot_sle_am'                => $this->tot_sle_am,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'sbscrb_ip'                 => $this->sbscrb_ip,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip,
                'last_conect_os'            => $this->last_conect_os,
                'last_conect_brwsr'         => $this->last_conect_brwsr
            ];
        }

    }
}

/**
 * @OA\Schema(
 *      schema="BcMngrResource",
 *
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_se", type="string", example="1", description="관리자구분(BC006)"
 *      ),
 *      @OA\Property(
 *          property="mngr_sttus", type="string", example="1", description="관리자상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="site_adres", type="string", example="https://test.com", description="사이트주소"
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
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="float", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="float", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="tot_purchs_am", type="integer", example="100", description="총구매금액",
 *      ),
 *      @OA\Property(
 *          property="tot_sle_am", type="integer", example="100", description="총판매금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 *      @OA\Property(
 *          property="sbscrb_ip", type="string", example="127.0.0.1", description="가입IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_dt", type="string", example="1900-01-01 00:00:00", description="마지막접속일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_ip", type="string", example="127.0.0.1", description="마지막접속IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_os", type="string", example="마지막접속OS", description="마지막접속OS"
 *      ),
 *      @OA\Property(
 *          property="last_conect_brwsr", type="string", example="마지막접속브라우저", description="마지막접속브라우저"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminManagersGet_BcMngrResource",
 *
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_sttus", type="string", example="1", description="관리자상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="site_adres", type="string", example="https://test.com", description="사이트주소"
 *      ),
 *      @OA\Property(
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="float", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="float", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="tot_purchs_am", type="integer", example="100", description="총구매금액",
 *      ),
 *      @OA\Property(
 *          property="tot_sle_am", type="integer", example="100", description="총판매금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminManagerGet_BcMngrResource",
 *
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_se", type="string", example="1", description="관리자구분(BC006)"
 *      ),
 *      @OA\Property(
 *          property="mngr_sttus", type="string", example="1", description="관리자상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="site_adres", type="string", example="https://test.com", description="사이트주소"
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
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="float", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="float", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="tot_purchs_am", type="integer", example="100", description="총구매금액",
 *      ),
 *      @OA\Property(
 *          property="tot_sle_am", type="integer", example="100", description="총판매금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 *      @OA\Property(
 *          property="sbscrb_ip", type="string", example="127.0.0.1", description="가입IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_dt", type="string", example="1900-01-01 00:00:00", description="마지막접속일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_ip", type="string", example="127.0.0.1", description="마지막접속IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_os", type="string", example="마지막접속OS", description="마지막접속OS"
 *      ),
 *      @OA\Property(
 *          property="last_conect_brwsr", type="string", example="마지막접속브라우저", description="마지막접속브라우저"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMemberGradesGet_BcMngrResource",
 *
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="mber_count", type="integer", example="100", description="회원수",
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
 *      schema="MemberMyPageGet_BcMngrResource",
 *
 *      @OA\Property(
 *          property="mngr_id", type="integer", example="1", description="관리자ID",
 *      ),
 *      @OA\Property(
 *          property="mngr_se", type="string", example="1", description="관리자구분(BC006)"
 *      ),
 *      @OA\Property(
 *          property="mngr_sttus", type="string", example="1", description="관리자상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="code", type="string", example="12ddsds", description="코드"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
 *      ),
 *      @OA\Property(
 *          property="prtnr_nm", type="string", example="파트너사명", description="파트너사명"
 *      ),
 *      @OA\Property(
 *          property="site_adres", type="string", example="https://test.com", description="사이트주소"
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
 *          property="csby_fee", type="integer", example="100", description="건당수수료",
 *      ),
 *      @OA\Property(
 *          property="purchs_fee", type="float", example="1000", description="구매수수료"
 *      ),
 *      @OA\Property(
 *          property="sle_fee", type="float", example="1000", description="판매수수료"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="tot_purchs_am", type="integer", example="100", description="총구매금액",
 *      ),
 *      @OA\Property(
 *          property="tot_sle_am", type="integer", example="100", description="총판매금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 *      @OA\Property(
 *          property="sbscrb_ip", type="string", example="127.0.0.1", description="가입IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_dt", type="string", example="1900-01-01 00:00:00", description="마지막접속일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_ip", type="string", example="127.0.0.1", description="마지막접속IP"
 *      ),
 *      @OA\Property(
 *          property="last_conect_os", type="string", example="마지막접속OS", description="마지막접속OS"
 *      ),
 *      @OA\Property(
 *          property="last_conect_brwsr", type="string", example="마지막접속브라우저", description="마지막접속브라우저"
 *      ),
 * )
 */
