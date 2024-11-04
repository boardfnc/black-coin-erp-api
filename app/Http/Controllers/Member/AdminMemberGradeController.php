<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\AdminMemberGrade;
use App\Http\Resources\User\BcMngrCollection;
use App\Models\User\BcGrdComputStdr;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminMemberGradeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/admin-member-grades",
     *     summary="회원 등급 산출 기준 목록 - 슈퍼어드민",
     *     tags={"Member - SuperAdmin"},
     *     description="회원 등급 산출 기준에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="search_type",
     *         in="query",
     *         description="검색 타입(prtnr_nm:파트너사명, code:코드)",
     *         @OA\Schema(
     *             type="string", enum={"prtnr_nm", "code"}, example="prtnr_nm", default="prtnr_nm"
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="search_keyword",
     *         in="query",
     *         description="검색 키워드",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=true,
     *         description="페이지 번호",
     *         @OA\Schema(
     *             type="integer",
     *             example="1"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=true,
     *         description="페이지당 노출 갯수",
     *         @OA\Schema(
     *             type="integer",
     *             example="20"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="orderby[]",
     *         in="query",
     *         description="정렬 컬럼명(sbscrb_dt:가입일시)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", default="sbscrb_dt desc")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/MemberAdminMemberGradesGet_BcMngrCollection"),
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="success"),
     *             @OA\Property(property="pagination", type="object",
     *                 @OA\Property(property="total", type="integer", example="100"),
     *                 @OA\Property(property="count", type="integer", example="20"),
     *                 @OA\Property(property="per_page", type="string", example="20"),
     *                 @OA\Property(property="current_page", type="integer", example="1"),
     *                 @OA\Property(property="total_pages", type="integer", example="5")
     *             )
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
     * )
     */

    public function index(AdminMemberGrade $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $orderby = array();
        if(empty($request->orderby))
        {
            $orderby[] =  'sbscrb_dt desc';
        }
        else
        {
            if(is_array($request->orderby))
            {
                $orderby = $request->orderby;
            }
            else
            {
                $orderby[] = $request->orderby;
            }
        }

        $data = BcMngr::where('mngr_se', '2')->with(
            'bcGrdComputStdr'
        )->withCount([
            'bcMber AS mber_count' => function ($query) {
                $query->where('confm_sttus', '1');
            }
        ]);

        if(!empty($request->search_type))
        {
            if(!empty($request->search_keyword))
            {
                $data->searchBy($request->search_keyword, $request->search_type);
            }
        }

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcMngrCollection($data);

    }

    /**
     *
     * @OA\Put(
     *      path="/member/admin-member-grade/{id}",
     *      summary="회원 등급 산출 기준 설정 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="회원 등급 산출 기준 설정 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="관리자ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
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
    public function update(AdminMemberGrade $request, $id)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '관리자 ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_mngr = BcMngr::find($id);

        if(empty($bc_mngr))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자 ID 입니다.',
            ], 400);
        }

        if($bc_mngr->mngr_se != '2')
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자구분 입니다.',
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

            $bc_grd_comput_stdr = BcGrdComputStdr::where('mngr_id', $id)->first();

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
