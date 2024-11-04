<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\AdminMemberSubscribe;
use App\Http\Resources\User\BcMberCollection;
use App\Models\User\BcMber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminMemberSubscribeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/admin-member-subscribes",
     *     summary="회원 가입 요청 목록 - 슈퍼어드민",
     *     tags={"Member - SuperAdmin"},
     *     description="회원 가입 요청에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="sbscrb_dt_start",
     *         in="query",
     *         description="가입일(시작일:2021-01-01)",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="sbscrb_dt_end",
     *         in="query",
     *         description="가입일(종료일:2021-01-01)",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="search_type",
     *         in="query",
     *         description="검색 타입(login_id:회원 아이디, prtnr_nm:파트너사명, code:코드, dpstr:예금주, acnutno:계좌번호)",
     *         @OA\Schema(
     *             type="string", enum={"login_id", "prtnr_nm", "code", "dpstr", "acnutno"}, example="login_id", default="login_id"
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
     *          name="confm_sttus",
     *          in="query",
     *          description="승인상태(0:전체, 2:대기, 3:거절)",
     *          @OA\Schema(
     *              type="string", enum={"0", "2", "3"}, example="0", default="0"
     *          )
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
     *             @OA\Property(property="data", ref="#/components/schemas/MemberAdminMemberSubscribesGet_BcMberCollection"),
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

    public function index(AdminMemberSubscribe $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $regex = "/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}).$/";

        if(!empty($request['sbscrb_dt_start']))
        {
            if (!preg_match($regex, $request['sbscrb_dt_start'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
        }

        if(!empty($request['sbscrb_dt_end']))
        {
            if (!preg_match($regex, $request['sbscrb_dt_end'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
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

        $data = BcMber::where('confm_sttus', '!=', '1')->with(
            'bcMngr'
        );

        if(!empty($request->sbscrb_dt_start))
        {
            $data->searchBy($request->sbscrb_dt_start, 'sbscrb_dt_start');
        }

        if(!empty($request->sbscrb_dt_end))
        {
            $data->searchBy($request->sbscrb_dt_end, 'sbscrb_dt_end');
        }

        if(!empty($request->search_type))
        {
            if(!empty($request->search_keyword))
            {
                $data->searchBy($request->search_keyword, $request->search_type);
            }
        }

        if(!empty($request->confm_sttus))
        {
            $data->searchBy($request->mber_sttus, 'confm_sttus');
        }

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcMberCollection($data);

    }

    /**
     *
     * @OA\Post(
     *      path="/member/admin-member-subscribe/consent",
     *      summary="회원 가입 승인 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="회원 가입 승인 합니다.",
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="mber_id", type="integer", example="1", description="회원ID"
     *              ),
     *          ),
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
    public function consent(AdminMemberSubscribe $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $bc_mber = BcMber::find($request->mber_id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        if($bc_mber->confm_sttus == '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '이미 회원가입 승인된 회원ID 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->mber_sttus = '1';
            $bc_mber->confm_sttus = '1';
            $bc_mber->confm_dt = date('Y-m-d H:i:s');
            $bc_mber->save();

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

    /**
     *
     * @OA\Post(
     *      path="/member/admin-member-subscribe/rejection",
     *      summary="회원 가입 거절 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="회원 가입 거절 합니다.",
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="mber_id", type="integer", example="1", description="회원ID"
     *              ),
     *          ),
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
    public function rejection(AdminMemberSubscribe $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $bc_mber = BcMber::find($request->mber_id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        if($bc_mber->confm_sttus == '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '이미 회원가입 승인된 회원ID 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->confm_sttus = '3';
            $bc_mber->save();

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
