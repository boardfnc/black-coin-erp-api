<?php

namespace App\Http\Controllers\Setup;

use App\Http\Controllers\Controller;
use App\Http\Requests\Setup\AdminAccount;
use App\Http\Resources\User\BcAcnutSetupResource;
use App\Models\Common\BcCmmnCd;
use App\Models\User\BcAcnutSetup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminAccountController extends Controller
{
    /**
     *
     * @OA\Get(
     *      path="/setup/admin-account",
     *      summary="계좌 정보 조회 - 슈퍼어드민",
     *      tags={"Setup - SuperAdmin"},
     *      description="계좌 정보 조회 합니다.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="data", ref="#/components/schemas/SetupAdminAccountGet_BcAcnutSetupResource",
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="success",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="필수 항목 미입력",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=false,
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="에러메세지",
     *              ),
     *          )
     *      ),
     *
     *      security={
     *          {"apiAuth": {}}
     *      },
     * )
     */
    public function show()
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $data = BcAcnutSetup::query()->first();

        if(empty($data))
        {
            return response()->json( [
                'status'    => true,
                'data'      => null,
                'message'   => 'success',
            ], 200 );
        }
        else
        {
            return new BcAcnutSetupResource($data);
        }
    }

    /**
     *
     * @OA\Post(
     *     path="/member/admin-account",
     *     summary="계좌 정보 저장 - 슈퍼어드민",
     *     tags={"Setup - SuperAdmin"},
     *     description="계좌 정보 저장 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="ca_rcpmny_bank", type="string", example="1", description="CA입금은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="ca_rcpmny_acnutno", type="string", description="CA입금계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="ca_rcpmny_dpstr", type="string", description="CA입금예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="ca_mumm_rcpmny_am", type="integer", example="100", description="CA최소입금금액"
     *             ),
     *             @OA\Property(
     *                 property="ca_mxmm_rcpmny_am", type="integer", example="100", description="CA최대입금금액"
     *             ),
     *             @OA\Property(
     *                 property="vvip_rcpmny_bank", type="string", example="1", description="VVIP입금은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="vvip_rcpmny_acnutno", type="string", description="VVIP입금계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="vvip_rcpmny_dpstr", type="string", description="VVIP입금예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="vvip_mumm_rcpmny_am", type="integer", example="100", description="VVIP최소입금금액"
     *             ),
     *             @OA\Property(
     *                 property="vvip_mxmm_rcpmny_am", type="integer", example="100", description="VVIP최대입금금액"
     *             ),
     *             @OA\Property(
     *                 property="vvip_mumm_defray_am", type="integer", example="100", description="VVIP최소출금금액"
     *             ),
     *             @OA\Property(
     *                 property="vvip_mxmm_defray_am", type="integer", example="100", description="VVIP최대출금금액"
     *             ),
     *             @OA\Property(
     *                 property="vip_rcpmny_bank", type="string", example="1", description="VIP입금은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="vip_rcpmny_acnutno", type="string", description="VIP입금계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="vip_rcpmny_dpstr", type="string", description="VIP입금예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="vip_mumm_rcpmny_am", type="integer", example="100", description="VIP최소입금금액"
     *             ),
     *             @OA\Property(
     *                 property="vip_mxmm_rcpmny_am", type="integer", example="100", description="VIP최대입금금액"
     *             ),
     *             @OA\Property(
     *                 property="vip_mumm_defray_am", type="integer", example="100", description="VIP최소출금금액"
     *             ),
     *             @OA\Property(
     *                 property="vip_mxmm_defray_am", type="integer", example="100", description="VIP최대출금금액"
     *             ),
     *             @OA\Property(
     *                 property="gnrl_rcpmny_bank", type="string", example="1", description="일반회원입금은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="gnrl_rcpmny_acnutno", type="string", description="일반회원입금계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="gnrl_rcpmny_dpstr", type="string", description="일반회원입금예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="gnrl_mumm_rcpmny_am", type="integer", example="100", description="일반회원최소입금금액"
     *             ),
     *             @OA\Property(
     *                 property="gnrl_mxmm_rcpmny_am", type="integer", example="100", description="일반회원최대입금금액"
     *             ),
     *             @OA\Property(
     *                 property="gnrl_mumm_defray_am", type="integer", example="100", description="일반회원최소출금금액"
     *             ),
     *             @OA\Property(
     *                 property="gnrl_mxmm_defray_am", type="integer", example="100", description="일반회원최대출금금액"
     *             ),
     *             @OA\Property(
     *                 property="new_rcpmny_bank", type="string", example="1", description="신규회원입금은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="new_rcpmny_acnutno", type="string", description="신규회원입금계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="new_rcpmny_dpstr", type="string", description="신규회원입금예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="new_mumm_rcpmny_am", type="integer", example="100", description="신규회원최소입금금액"
     *             ),
     *             @OA\Property(
     *                 property="new_mxmm_rcpmny_am", type="integer", example="100", description="신규회원최대입금금액"
     *             ),
     *             @OA\Property(
     *                 property="new_mumm_defray_am", type="integer", example="100", description="신규회원최소출금금액"
     *             ),
     *             @OA\Property(
     *                 property="new_mxmm_defray_am", type="integer", example="100", description="신규회원최대출금금액"
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status", type="boolean", example="true",
     *             ),
     *             @OA\Property(
     *                 property="message", type="string", example="success",
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="필수 항목 미입력 및 정보 오류",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status", type="boolean", example=false,
     *             ),
     *             @OA\Property(
     *                 property="message", type="string", example="에러메세지"
     *             ),
     *         )
     *     ),
     *     security={
     *         {"apiAuth": {}}
     *     }
     *
     * )
     */
    public function store(AdminAccount $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $bank_code = BcCmmnCd::where('cd_grp', 'BC005')->get();
        $regex = "/^[0-9]+$/";

        if(!empty($request['ca_rcpmny_bank']))
        {
            $bank_check = $bank_code->where('cd', $request['ca_rcpmny_bank'])->first();

            if(empty($bank_check))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 은행코드 입니다.',
                ], 400);
            }
        }

        if(!empty($request['ca_rcpmny_acnutno']))
        {
            if (!preg_match($regex, $request['ca_rcpmny_acnutno'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
                ], 400);
            }
        }

        if(!empty($request['vvip_rcpmny_bank']))
        {
            $bank_check = $bank_code->where('cd', $request['vvip_rcpmny_bank'])->first();

            if(empty($bank_check))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 은행코드 입니다.',
                ], 400);
            }
        }

        if(!empty($request['vvip_rcpmny_acnutno']))
        {
            if (!preg_match($regex, $request['vvip_rcpmny_acnutno'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
                ], 400);
            }
        }

        if(!empty($request['vip_rcpmny_bank']))
        {
            $bank_check = $bank_code->where('cd', $request['vip_rcpmny_bank'])->first();

            if(empty($bank_check))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 은행코드 입니다.',
                ], 400);
            }
        }

        if(!empty($request['vip_rcpmny_acnutno']))
        {
            if (!preg_match($regex, $request['vip_rcpmny_acnutno'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
                ], 400);
            }
        }

        if(!empty($request['gnrl_rcpmny_bank']))
        {
            $bank_check = $bank_code->where('cd', $request['gnrl_rcpmny_bank'])->first();

            if(empty($bank_check))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 은행코드 입니다.',
                ], 400);
            }
        }

        if(!empty($request['gnrl_rcpmny_acnutno']))
        {
            if (!preg_match($regex, $request['gnrl_rcpmny_acnutno'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
                ], 400);
            }
        }

        if(!empty($request['new_rcpmny_bank']))
        {
            $bank_check = $bank_code->where('cd', $request['new_rcpmny_bank'])->first();

            if(empty($bank_check))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 은행코드 입니다.',
                ], 400);
            }
        }

        if(!empty($request['new_rcpmny_acnutno']))
        {
            if (!preg_match($regex, $request['new_rcpmny_acnutno'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
                ], 400);
            }
        }

        if(!is_int($request['ca_mumm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'CA최소입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['ca_mxmm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'CA최대입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vvip_mumm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VVIP최소입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vvip_mxmm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VVIP최대입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vvip_mumm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VVIP최소출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vvip_mxmm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VVIP최대출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vip_mumm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VIP최소입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vip_mxmm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VIP최대입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vip_mumm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VIP최소출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vip_mxmm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'VIP최대출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['gnrl_mumm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반회원최소입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['gnrl_mxmm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반회원최대입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['gnrl_mumm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반회원최소출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['gnrl_mxmm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반회원최대출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['new_mumm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '신규회원최소입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['new_mxmm_rcpmny_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '신규회원최대입금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['new_mumm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '신규회원최소출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['new_mxmm_defray_am']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '신규회원최대출금금액는 정수만 입력 가능 합니다.',
            ], 400);
        }

        $check = BcAcnutSetup::query()->first();

        DB::beginTransaction();

        try {

            $bc_acnut_setup = '';
            if(empty($check))
            {
                $bc_acnut_setup = new BcAcnutSetup();
                $bc_acnut_setup->rgstr_id = $user->mngr_id;
                $bc_acnut_setup->reg_ip = $request->ip();
            }
            else
            {
                $bc_acnut_setup = BcAcnutSetup::find($check->acnut_setup_id);
                $bc_acnut_setup->upd_usr_id = $user->mngr_id;
                $bc_acnut_setup->upd_ip = $request->ip();
            }

            $bc_acnut_setup->ca_rcpmny_bank = empty($request['ca_rcpmny_bank'])?null:$request['ca_rcpmny_bank'];
            $bc_acnut_setup->ca_rcpmny_acnutno = empty($request['ca_rcpmny_acnutno'])?null:$request['ca_rcpmny_acnutno'];
            $bc_acnut_setup->ca_rcpmny_dpstr = empty($request['ca_rcpmny_dpstr'])?null:$request['ca_rcpmny_dpstr'];
            $bc_acnut_setup->ca_mumm_rcpmny_am = $request['ca_mumm_rcpmny_am'];
            $bc_acnut_setup->ca_mxmm_rcpmny_am = $request['ca_mxmm_rcpmny_am'];
            $bc_acnut_setup->vvip_rcpmny_bank = empty($request['vvip_rcpmny_bank'])?null:$request['vvip_rcpmny_bank'];
            $bc_acnut_setup->vvip_rcpmny_acnutno = empty($request['vvip_rcpmny_acnutno'])?null:$request['vvip_rcpmny_acnutno'];
            $bc_acnut_setup->vvip_rcpmny_dpstr = empty($request['vvip_rcpmny_dpstr'])?null:$request['vvip_rcpmny_dpstr'];
            $bc_acnut_setup->vvip_mumm_rcpmny_am = $request['vvip_mumm_rcpmny_am'];
            $bc_acnut_setup->vvip_mxmm_rcpmny_am = $request['vvip_mxmm_rcpmny_am'];
            $bc_acnut_setup->vvip_mumm_defray_am = $request['vvip_mumm_defray_am'];
            $bc_acnut_setup->vvip_mxmm_defray_am = $request['vvip_mxmm_defray_am'];
            $bc_acnut_setup->vip_rcpmny_bank = empty($request['vip_rcpmny_bank'])?null:$request['vip_rcpmny_bank'];
            $bc_acnut_setup->vip_rcpmny_acnutno = empty($request['vip_rcpmny_acnutno'])?null:$request['vip_rcpmny_acnutno'];
            $bc_acnut_setup->vip_rcpmny_dpstr = empty($request['vip_rcpmny_dpstr'])?null:$request['vip_rcpmny_dpstr'];
            $bc_acnut_setup->vip_mumm_rcpmny_am = $request['vip_mumm_rcpmny_am'];
            $bc_acnut_setup->vip_mxmm_rcpmny_am = $request['vip_mxmm_rcpmny_am'];
            $bc_acnut_setup->vip_mumm_defray_am = $request['vip_mumm_defray_am'];
            $bc_acnut_setup->vip_mxmm_defray_am = $request['vip_mxmm_defray_am'];
            $bc_acnut_setup->gnrl_rcpmny_bank = empty($request['gnrl_rcpmny_bank'])?null:$request['gnrl_rcpmny_bank'];
            $bc_acnut_setup->gnrl_rcpmny_acnutno = empty($request['gnrl_rcpmny_acnutno'])?null:$request['gnrl_rcpmny_acnutno'];
            $bc_acnut_setup->gnrl_rcpmny_dpstr = empty($request['gnrl_rcpmny_dpstr'])?null:$request['gnrl_rcpmny_dpstr'];
            $bc_acnut_setup->gnrl_mumm_rcpmny_am = $request['gnrl_mumm_rcpmny_am'];
            $bc_acnut_setup->gnrl_mxmm_rcpmny_am = $request['gnrl_mxmm_rcpmny_am'];
            $bc_acnut_setup->gnrl_mumm_defray_am = $request['gnrl_mumm_defray_am'];
            $bc_acnut_setup->gnrl_mxmm_defray_am = $request['gnrl_mxmm_defray_am'];
            $bc_acnut_setup->new_rcpmny_bank = empty($request['new_rcpmny_bank'])?null:$request['new_rcpmny_bank'];
            $bc_acnut_setup->new_rcpmny_acnutno = empty($request['new_rcpmny_acnutno'])?null:$request['new_rcpmny_acnutno'];
            $bc_acnut_setup->new_rcpmny_dpstr = empty($request['new_rcpmny_dpstr'])?null:$request['new_rcpmny_dpstr'];
            $bc_acnut_setup->new_mumm_rcpmny_am = $request['new_mumm_rcpmny_am'];
            $bc_acnut_setup->new_mxmm_rcpmny_am = $request['new_mxmm_rcpmny_am'];
            $bc_acnut_setup->new_mumm_defray_am = $request['new_mumm_defray_am'];
            $bc_acnut_setup->new_mxmm_defray_am = $request['new_mxmm_defray_am'];
            $bc_acnut_setup->save();

            DB::commit();

        } catch (\Exception $e) {

            Log::error($e);
            DB::rollBack();
            return response()->json([
                'status'    => false,
                'message'   => 'DB 데이터 저장 오류',
            ], 400);

        }

        return response()->json([
            'status'    => true,
            'message'   => 'success',
        ], 201);

    }
}
