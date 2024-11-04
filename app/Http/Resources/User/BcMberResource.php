<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BcMberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if($request->route()->named('MemberAdminMembersGet')) {
            return [
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'prtnr_nm'                  => $this->bcMngr->prtnr_nm,
                'code'                      => $this->bcMngr->code,
                'mber_sttus'                => $this->mber_sttus,
                'login_id'                  => $this->login_id,
                'mber_grd'                  => $this->mber_grd,
                'hold_coin'                 => $this->hold_coin,
                'rcpmny_am'                 => $this->rcpmny_am,
                'defray_am'                 => $this->defray_am,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip
            ];
        }
        else if($request->route()->named('MemberAdminMemberSubscribesGet')) {
            return [
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'prtnr_nm'                  => $this->bcMngr->prtnr_nm,
                'code'                      => $this->bcMngr->code,
                'login_id'                  => $this->login_id,
                'mp_no'                     => $this->mp_no,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'confm_sttus'               => $this->confm_sttus,
                'sbscrb_dt'                 => $this->sbscrb_dt
            ];
        }
        else if($request->route()->named('MemberAdminMemberGet')) {
            return [
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'prtnr_nm'                  => $this->bcMngr->prtnr_nm,
                'code'                      => $this->bcMngr->code,
                'mber_sttus'                => $this->mber_sttus,
                'login_id'                  => $this->login_id,
                'esntl_key'                 => $this->esntl_key,
                'mp_no'                     => $this->mp_no,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'passiv_grd_at'             => $this->passiv_grd_at,
                'hold_coin'                 => $this->hold_coin,
                'rcppay_co'                 => $this->rcppay_co,
                'rcpmny_am'                 => $this->rcpmny_am,
                'defray_am'                 => $this->defray_am,
                'tot_delng_am'              => $this->tot_delng_am,
                'confm_sttus'               => $this->confm_sttus,
                'confm_dt'                  => $this->confm_dt,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'sbscrb_ip'                 => $this->sbscrb_ip,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip,
                'last_conect_os'            => $this->last_conect_os,
                'last_conect_brwsr'         => $this->last_conect_brwsr
            ];
        }
        else if($request->route()->named('MemberMembersGet')) {
            return [
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'mber_sttus'                => $this->mber_sttus,
                'login_id'                  => $this->login_id,
                'mber_grd'                  => $this->mber_grd,
                'hold_coin'                 => $this->hold_coin,
                'rcpmny_am'                 => $this->rcpmny_am,
                'defray_am'                 => $this->defray_am,
                'sbscrb_dt'                 => $this->sbscrb_dt,
                'last_conect_dt'            => $this->last_conect_dt,
                'last_conect_ip'            => $this->last_conect_ip
            ];
        }
        else if($request->route()->named('MemberMemberGet')) {
            return [
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'mber_sttus'                => $this->mber_sttus,
                'login_id'                  => $this->login_id,
                'esntl_key'                 => $this->esntl_key,
                'mp_no'                     => $this->mp_no,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'passiv_grd_at'             => $this->passiv_grd_at,
                'hold_coin'                 => $this->hold_coin,
                'rcppay_co'                 => $this->rcppay_co,
                'rcpmny_am'                 => $this->rcpmny_am,
                'defray_am'                 => $this->defray_am,
                'tot_delng_am'              => $this->tot_delng_am,
                'confm_sttus'               => $this->confm_sttus,
                'confm_dt'                  => $this->confm_dt,
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
                'mber_id'                   => $this->mber_id,
                'mngr_id'                   => $this->mngr_id,
                'mber_sttus'                => $this->mber_sttus,
                'login_id'                  => $this->login_id,
                'esntl_key'                 => $this->esntl_key,
                'mp_no'                     => $this->mp_no,
                'bank'                      => $this->bank,
                'dpstr'                     => $this->dpstr,
                'acnutno'                   => $this->acnutno,
                'mber_grd'                  => $this->mber_grd,
                'passiv_grd_at'             => $this->passiv_grd_at,
                'hold_coin'                 => $this->hold_coin,
                'rcppay_co'                 => $this->rcppay_co,
                'rcpmny_am'                 => $this->rcpmny_am,
                'defray_am'                 => $this->defray_am,
                'tot_delng_am'              => $this->tot_delng_am,
                'confm_sttus'               => $this->confm_sttus,
                'confm_dt'                  => $this->confm_dt,
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
 *      schema="BcMberResource",
 *
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
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="esntl_key", type="string", example="12ddsds", description="고유키"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
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
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="passiv_grd_at", type="string", example="1", description="수동등급여부(BC003)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="rcppay_co", type="integer", example="100", description="입출금횟수",
 *      ),
 *      @OA\Property(
 *          property="rcpmny_am", type="integer", example="100", description="입금금액",
 *      ),
 *      @OA\Property(
 *          property="defray_am", type="integer", example="100", description="출금금액",
 *      ),
 *      @OA\Property(
 *          property="tot_delng_am", type="integer", example="100", description="총거래금액",
 *      ),
 *      @OA\Property(
 *          property="confm_sttus", type="string", example="1", description="승인상태(BC002)"
 *      ),
 *      @OA\Property(
 *          property="confm_dt", type="string", example="1900-01-01 00:00:00", description="승인일시"
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
 *      schema="MemberAdminMembersGet_BcMberResource",
 *
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
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
 *          property="mber_sttus", type="string", example="1", description="회원상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="rcpmny_am", type="integer", example="100", description="입금금액",
 *      ),
 *      @OA\Property(
 *          property="defray_am", type="integer", example="100", description="출금금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_dt", type="string", example="1900-01-01 00:00:00", description="마지막접속일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_ip", type="string", example="127.0.0.1", description="마지막접속IP"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMemberSubscribesGet_BcMberResource",
 *
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
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
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
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
 *          property="confm_sttus", type="string", example="1", description="승인상태(BC002)"
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberAdminMemberGet_BcMberResource",
 *
 *      @OA\Property(
 *          property="mber_id", type="integer", example="1", description="회원ID",
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
 *          property="mber_sttus", type="string", example="1", description="회원상태(BC001)"
 *      ),
 *      @OA\Property(
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="esntl_key", type="string", example="12ddsds", description="고유키"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
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
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="passiv_grd_at", type="string", example="1", description="수동등급여부(BC003)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="rcppay_co", type="integer", example="100", description="입출금횟수",
 *      ),
 *      @OA\Property(
 *          property="rcpmny_am", type="integer", example="100", description="입금금액",
 *      ),
 *      @OA\Property(
 *          property="defray_am", type="integer", example="100", description="출금금액",
 *      ),
 *      @OA\Property(
 *          property="tot_delng_am", type="integer", example="100", description="총거래금액",
 *      ),
 *      @OA\Property(
 *          property="confm_sttus", type="string", example="1", description="승인상태(BC002)"
 *      ),
 *      @OA\Property(
 *          property="confm_dt", type="string", example="1900-01-01 00:00:00", description="승인일시"
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
 *      schema="MemberMembersGet_BcMberResource",
 *
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
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="rcpmny_am", type="integer", example="100", description="입금금액",
 *      ),
 *      @OA\Property(
 *          property="defray_am", type="integer", example="100", description="출금금액",
 *      ),
 *      @OA\Property(
 *          property="sbscrb_dt", type="string", example="1900-01-01 00:00:00", description="가입일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_dt", type="string", example="1900-01-01 00:00:00", description="마지막접속일시"
 *      ),
 *      @OA\Property(
 *          property="last_conect_ip", type="string", example="127.0.0.1", description="마지막접속IP"
 *      ),
 * )
 */

/**
 * @OA\Schema(
 *      schema="MemberMemberGet_BcMberResource",
 *
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
 *          property="login_id", type="string", example="test", description="로그인ID"
 *      ),
 *      @OA\Property(
 *          property="esntl_key", type="string", example="12ddsds", description="고유키"
 *      ),
 *      @OA\Property(
 *          property="mp_no", type="string", example="01012345678", description="휴대폰번호"
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
 *          property="mber_grd", type="string", example="1", description="회원등급(BC011)"
 *      ),
 *      @OA\Property(
 *          property="passiv_grd_at", type="string", example="1", description="수동등급여부(BC003)"
 *      ),
 *      @OA\Property(
 *          property="hold_coin", type="integer", example="100", description="보유코인",
 *      ),
 *      @OA\Property(
 *          property="rcppay_co", type="integer", example="100", description="입출금횟수",
 *      ),
 *      @OA\Property(
 *          property="rcpmny_am", type="integer", example="100", description="입금금액",
 *      ),
 *      @OA\Property(
 *          property="defray_am", type="integer", example="100", description="출금금액",
 *      ),
 *      @OA\Property(
 *          property="tot_delng_am", type="integer", example="100", description="총거래금액",
 *      ),
 *      @OA\Property(
 *          property="confm_sttus", type="string", example="1", description="승인상태(BC002)"
 *      ),
 *      @OA\Property(
 *          property="confm_dt", type="string", example="1900-01-01 00:00:00", description="승인일시"
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
