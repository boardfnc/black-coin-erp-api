<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\MemberGrade;
use App\Http\Resources\User\BcGrdComputStdrResource;
use App\Models\User\BcGrdComputStdr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberGradeController extends Controller
{
    /**
     *
     * @OA\Get(
     *      path="/member/member-grade",
     *      summary="회원 등급 산출 기준 조회 ",
     *      tags={"Member"},
     *      description="회원 등급 산출 기준 조회 합니다.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="data", ref="#/components/schemas/MemberMemberGradeGet_BcGrdComputStdrResource",
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
        $mngr_id = $user->mngr_id;

        if($user->mngr_se != '2')
        {
            return response()->json([
                'status'    => false,
                'message'   => 'CA 관리자 계정이 아닙니다.',
            ], 400);
        }

        $data = BcGrdComputStdr::where('mngr_id', $mngr_id)->first();

        if(empty($data))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자ID 입니다.',
            ], 400);
        }

        return new BcGrdComputStdrResource($data);
    }

    /**
     *
     * @OA\Put(
     *      path="/member/member-grade",
     *      summary="회원 등급 산출 기준 설정 ",
     *      tags={"Member"},
     *      description="회원 등급 산출 기준 설정 합니다.",
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="comput_stdr_se", type="string", example="1", description="산출기준구분(BC010)"
     *              ),
     *              @OA\Property(
     *                  property="vvip_stdr", type="integer", example="100", description="vvip기준"
     *              ),
     *              @OA\Property(
     *                  property="vip_stdr", type="integer", example="100", description="vip기준"
     *              ),
     *              @OA\Property(
     *                  property="gnrl_stdr", type="integer", example="100", description="일반기준"
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example="true",
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="success",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="필수 항목 미입력 및 정보 오류",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=false,
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="에러메세지"
     *              ),
     *          )
     *      ),
     *     security={
     *         {"apiAuth": {}}
     *     }
     *
     * )
     */
    public function update(MemberGrade $request)
    {
        $user = auth()->user();
        $mngr_id = $user->mngr_id;

        if($user->mngr_se != '2')
        {
            return response()->json([
                'status'    => false,
                'message'   => 'CA 관리자 계정이 아닙니다.',
            ], 400);
        }

        if(!is_int($request['vvip_stdr']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'vvip기준는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['vip_stdr']))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'vip기준는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['gnrl_stdr']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반기준는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if($request['gnrl_stdr'] >= $request['vip_stdr'])
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반기준는 vip기준 보다 크거나 같을 수는 없습니다.',
            ], 400);
        }

        if($request['gnrl_stdr'] >= $request['vvip_stdr'])
        {
            return response()->json([
                'status'    => false,
                'message'   => '일반기준는 vvip기준 보다 크거나 같을 수는 없습니다.',
            ], 400);
        }

        if($request['vip_stdr'] >= $request['vvip_stdr'])
        {
            return response()->json([
                'status'    => false,
                'message'   => 'vip는 vvip기준 보다 크거나 같을 수는 없습니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_grd_comput_stdr = BcGrdComputStdr::where('mngr_id', $mngr_id)->first();

            $grd_comput_stdr_id = $bc_grd_comput_stdr->grd_comput_stdr_id;

            $bc_grd_comput_stdr = BcGrdComputStdr::find($grd_comput_stdr_id);
            $bc_grd_comput_stdr->comput_stdr_se = $request['comput_stdr_se'];
            $bc_grd_comput_stdr->vvip_stdr = $request['vvip_stdr'];
            $bc_grd_comput_stdr->vip_stdr = $request['vip_stdr'];
            $bc_grd_comput_stdr->gnrl_stdr = $request['gnrl_stdr'];
            $bc_grd_comput_stdr->upd_usr_id = $user->mngr_id;
            $bc_grd_comput_stdr->upd_ip = $request->ip();
            $bc_grd_comput_stdr->updated_at = date('Y-m-d H:i:s');
            $bc_grd_comput_stdr->save();

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
