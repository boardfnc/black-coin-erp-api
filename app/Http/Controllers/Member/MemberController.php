<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\Member;
use App\Http\Resources\User\BcMberCollection;
use App\Http\Resources\User\BcMberResource;
use App\Models\Common\BcCmmnCd;
use App\Models\Dealings\BcMberPymntDtls;
use App\Models\Dealings\BcMberRtrvlDtls;
use App\Models\History\BcCaCoinHis;
use App\Models\History\BcCaStats;
use App\Models\History\BcMberCoinHis;
use App\Models\History\BcMberStats;
use App\Models\User\BcMber;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/members",
     *     summary="회원 목록",
     *     tags={"Member"},
     *     description="회원 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="검색 타입(login_id:회원 아이디)",
     *         @OA\Schema(
     *             type="string", enum={"login_id"}, example="login_id", default="login_id"
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
     *          name="mber_grd",
     *          in="query",
     *          description="회원등급(0:전체, 1:VVIP, 2:VIP, 3:일반회원, 4:신규회원)",
     *          @OA\Schema(
     *              type="string", enum={"0", "1", "2", "3", "4"}, example="0", default="0"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="mber_sttus",
     *          in="query",
     *          description="회원상태(0:전체, 1:정상, 2:차단)",
     *          @OA\Schema(
     *              type="string", enum={"0", "1", "2"}, example="0", default="0"
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
     *             @OA\Property(property="data", ref="#/components/schemas/MemberMembersGet_BcMberCollection"),
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

    public function index(Member $request)
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

        $data = BcMber::where('confm_sttus', '1')->where('mngr_id', $mngr_id);

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

        if(!empty($request->mber_grd))
        {
            $data->searchBy($request->mber_grd, 'mber_grd');
        }

        if(!empty($request->mber_sttus))
        {
            $data->searchBy($request->mber_sttus, 'mber_sttus');
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
     * @OA\Get(
     *      path="/member/member/{id}",
     *      summary="회원 조회",
     *      tags={"Member"},
     *      description="회원 조회 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="data", ref="#/components/schemas/MemberMemberGet_BcMberResource",
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
    public function show($id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID 는 필수 항목입니다.',
            ], 400);
        }

        $data = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($data))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        return new BcMberResource($data);
    }

    /**
     *
     * @OA\Get(
     *      path="/member/member/dealings/{id}",
     *      summary="회원 거래 정보 조회",
     *      tags={"Member"},
     *      description="회원 거래 정보 조회 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="stats_de_start",
     *          in="query",
     *          description="통계일자(시작일:2021-01-01)",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="stats_de_end",
     *          in="query",
     *          description="통계일자(종료일:2021-01-01)",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                   property="data", type="object",
     *                   @OA\Property(property="fee_am", type="integer", description="수수료액", example="1000"),
     *                   @OA\Property(property="purchs_am", type="integer", description="구매액", example="1000"),
     *                   @OA\Property(property="sle_am", type="integer", description="판매액", example="1000"),
     *              ),
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
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
    public function dealings($id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID는 필수 항목입니다.',
            ], 400);
        }

        $regex = "/^([0-9]{4})-([0-9]{1,2})-([0-9]{1,2}).$/";

        if(!empty($request['stats_de_start']))
        {
            if (!preg_match($regex, $request['stats_de_start'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
        }

        if(!empty($request['stats_de_end']))
        {
            if (!preg_match($regex, $request['stats_de_end'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
        }

        $data = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($data))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        $data = BcMberStats::where('mber_id', $id)
            ->selectRaw('
                IFNULL(SUM(purchs_qy), 0) as purchs_qy,
                IFNULL(SUM(sle_qy), 0) as sle_qy,
                IFNULL(SUM(csby_fee_am), 0) as csby_fee_am,
                IFNULL(SUM(purchs_fee_am), 0) as purchs_fee_am,
                IFNULL(SUM(sle_fee_am), 0) as sle_fee_am
            ');

        if(!empty($request->stats_de_start))
        {
            $data->searchBy($request->stats_de_start, 'stats_de_start');
        }

        if(!empty($request->stats_de_end))
        {
            $data->searchBy($request->stats_de_end, 'stats_de_end');
        }

        $data = $data->first();

        $items = array();

        $fee_am = $data->csby_fee_am + $data->purchs_fee_am + $data->sle_fee_am;
        $purchs_am = $data->purchs_qy;
        $sle_am = $data->sle_qy;

        $items['fee_am'] = (int)$fee_am;
        $items['purchs_am'] = (int)$purchs_am;
        $items['sle_am'] = (int)$sle_am;

        return response()->json([
            'data' => $items,
            'status'    => true,
            'message'   => 'success',
        ], 200);
    }

    /**
     *
     * @OA\Put(
     *      path="/member/member/password-update/{id}",
     *      summary="회원 비밀번호 업데이트",
     *      tags={"Member"},
     *      description="회원 비밀번호 정보 업데이트 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="password", type="string", example="123456", description="비밀번호"
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
    public function passwordUpdate(Member $request, $id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->password = bcrypt($request['password']);
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
     * @OA\Put(
     *      path="/member/member/status-update/{id}",
     *      summary="회원 상태 업데이트",
     *      tags={"Member"},
     *      description="회원 상태 정보 업데이트 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="mber_sttus", type="string", description="회원상태(BC001)", example="1",
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
    public function statusUpdate(Member $request, $id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        if($bc_mber->confm_sttus != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원가입 승인 되지 않은 회원ID 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->mber_sttus = $request['mber_sttus'];
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
     * @OA\Put(
     *      path="/member/member/account-number-update/{id}",
     *      summary="회원 계좌 정보 업데이트",
     *      tags={"Member"},
     *      description="회원 계좌 정보 업데이트 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="bank", type="string", example="1", description="은행(BC005)"
     *              ),
     *              @OA\Property(
     *                  property="acnutno", type="string", description="계좌번호", example="12345646",
     *              ),
     *              @OA\Property(
     *                  property="dpstr", type="string", description="예금주", example="예금주",
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
    public function accountNumberUpdate(Member $request, $id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        $bank_code = BcCmmnCd::where('cd_grp', 'BC005')->get();
        $bank_check = $bank_code->where('cd', $request['bank'])->first();

        if(empty($bank_check))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 은행코드 입니다.',
            ], 400);
        }

        $regex = "/^[0-9]+$/";

        if (!preg_match($regex, $request['acnutno'])) {
            return response()->json([
                'status'    => false,
                'message'   => '계좌번호는 숫자만 입력 가능 합니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->bank = $request['bank'];
            $bc_mber->dpstr = $request['dpstr'];
            $bc_mber->acnutno = $request['acnutno'];
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
     * @OA\Put(
     *      path="/member/member/grade-update/{id}",
     *      summary="회원 등급 업데이트",
     *      tags={"Member"},
     *      description="회원 등급 정보 업데이트 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="회원ID",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="mber_grd", type="string", description="회원등급(BC011)", example="1",
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
    public function gradeUpdate(Member $request, $id)
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

        if(empty($id))
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mber->mber_grd = $request['mber_grd'];
            $bc_mber->passiv_grd_at = '1';
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
     *     path="/member/member/retrieval",
     *     summary="회원 코인 회수 ",
     *     tags={"Member"},
     *     description="회원 코인 회수 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="mber_id", type="integer", example="1", description="회원ID"
     *             ),
     *             @OA\Property(
     *                 property="rtrvl_coin", type="integer", example="100", description="회수코인"
     *             ),
     *             @OA\Property(
     *                 property="memo", type="string", description="메모", example="메모",
     *             ),
     *         ),
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
    public function retrieval(Member $request)
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

        $rtrvl_coin = $request->rtrvl_coin ?? 0;

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($request->mber_id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        if($rtrvl_coin > $bc_mber['hold_coin'])
        {
            return response()->json([
                'status'    => false,
                'message'   => '회원이 보유한 코인 이상으로는 회수가 불가능합니다.',
            ], 400);
        }

        $mngr_id = $bc_mber->mngr_id;
        $mber_id = $bc_mber->mber_id;
        $mber_sttus = $bc_mber->mber_sttus;
        $mber_grd = $bc_mber->mber_grd;
        $hold_coin = $bc_mber->hold_coin - $rtrvl_coin;
        $tot_purchs_am = $bc_mber->rcpmny_am;
        $tot_sle_am = $bc_mber->defray_am;

        DB::beginTransaction();

        try {

            $bc_mber_rtrvl_dtls = new BcMberRtrvlDtls();
            $bc_mber_rtrvl_dtls->mber_id = $mber_id;
            $bc_mber_rtrvl_dtls->mngr_id = $mngr_id;
            $bc_mber_rtrvl_dtls->rirvl_mngr_id = $user->mngr_id;
            $bc_mber_rtrvl_dtls->mber_sttus = $mber_sttus;
            $bc_mber_rtrvl_dtls->mber_grd = $mber_grd;
            $bc_mber_rtrvl_dtls->hold_coin = $hold_coin;
            $bc_mber_rtrvl_dtls->tot_purchs_am = $tot_purchs_am;
            $bc_mber_rtrvl_dtls->tot_sle_am = $tot_sle_am;
            $bc_mber_rtrvl_dtls->rtrvl_coin = $rtrvl_coin;
            $bc_mber_rtrvl_dtls->memo = $request->memo;
            $bc_mber_rtrvl_dtls->rgstr_id = $user->mngr_id;
            $bc_mber_rtrvl_dtls->reg_ip = $request->ip();
            $bc_mber_rtrvl_dtls->save();

            $mber_rirvl_dtls_id = $bc_mber_rtrvl_dtls->mber_rirvl_dtls_id;

            $coin = $rtrvl_coin * (-1);

            $bc_mber_coin_his = new BcMberCoinHis();
            $bc_mber_coin_his->mber_id = $mber_id;
            $bc_mber_coin_his->mber_rirvl_dtls_id = $mber_rirvl_dtls_id;
            $bc_mber_coin_his->coin_se = '4';
            $bc_mber_coin_his->ddct_coin = $rtrvl_coin;
            $bc_mber_coin_his->coin = $coin;
            $bc_mber_coin_his->rgstr_id = $user->mngr_id;
            $bc_mber_coin_his->reg_ip = $request->ip();
            $bc_mber_coin_his->save();

            $bc_mber = BcMber::find($mber_id);

            $bc_mber->update([
                'hold_coin' => DB::raw('hold_coin - '.$rtrvl_coin)
            ]);

            $date = date('Y-m-d');
            $bc_mber_stats = BcMberStats::where([['sm_dd', $date], ['mber_id', $mber_id]])->first();

            if(empty($bc_mber_stats))
            {
                $bc_mber_stats = new BcMberStats();
                $bc_mber_stats->mber_id = $mber_id;
                $bc_mber_stats->stats_de = $date;
                $bc_mber_stats->purchs_co = 0;
                $bc_mber_stats->purchs_qy = 0;
                $bc_mber_stats->sle_co = 0;
                $bc_mber_stats->sle_qy = 0;
                $bc_mber_stats->rirvl_qy = $rtrvl_coin;
                $bc_mber_stats->pymnt_qy = 0;
                $bc_mber_stats->csby_fee_am = 0;
                $bc_mber_stats->purchs_fee_am = 0;
                $bc_mber_stats->sle_fee_am = 0;
                $bc_mber_stats->save();
            }
            else
            {
                $update_bc_mber_stats = BcMberStats::find($bc_mber_stats->mber_stats_id);

                $update_bc_mber_stats->update([
                    'rirvl_qy' => DB::raw('rirvl_qy + '.$rtrvl_coin),
                    'upd_usr_id' => $user->mngr_id,
                    'upd_ip' => $request->ip(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $ca_coin = $rtrvl_coin;

            $bc_ca_coin_his = new BcCaCoinHis();
            $bc_ca_coin_his->mber_id = $mber_id;
            $bc_ca_coin_his->mber_rirvl_dtls_id = $mber_rirvl_dtls_id;
            $bc_ca_coin_his->coin_se = '4';
            $bc_ca_coin_his->pymnt_coin = $rtrvl_coin;
            $bc_ca_coin_his->coin = $ca_coin;
            $bc_ca_coin_his->rgstr_id = $user->mngr_id;
            $bc_ca_coin_his->reg_ip = $request->ip();
            $bc_ca_coin_his->save();

            $bc_mngr = BcMngr::find($mngr_id);

            $bc_mngr->update([
                'hold_coin' => DB::raw('hold_coin + '.$rtrvl_coin)
            ]);

            $date = date('Y-m-d');
            $bc_ca_stats = BcCaStats::where([['sm_dd', $date], ['mngr_id', $mngr_id]])->first();

            if(empty($bc_ca_stats))
            {
                $bc_ca_stats = new BcCaStats();
                $bc_ca_stats->mngr_id = $mngr_id;
                $bc_ca_stats->stats_de = $date;
                $bc_ca_stats->purchs_co = 0;
                $bc_ca_stats->purchs_qy = 0;
                $bc_ca_stats->sle_co = 0;
                $bc_ca_stats->sle_qy = 0;
                $bc_ca_stats->rirvl_qy = $rtrvl_coin;
                $bc_ca_stats->pymnt_qy = 0;
                $bc_ca_stats->csby_fee_am = 0;
                $bc_ca_stats->purchs_fee_am = 0;
                $bc_ca_stats->sle_fee_am = 0;
                $bc_ca_stats->save();
            }
            else
            {
                $update_bc_ca_stats = BcCaStats::find($bc_ca_stats->ca_stats_id);

                $update_bc_ca_stats->update([
                    'rirvl_qy' => DB::raw('rirvl_qy + '.$rtrvl_coin),
                    'upd_usr_id' => $user->mngr_id,
                    'upd_ip' => $request->ip(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

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
     *     path="/member/member/payment",
     *     summary="회원 코인 지급",
     *     tags={"Member"},
     *     description="회원 코인 지급 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="mber_id", type="integer", example="1", description="회원ID"
     *             ),
     *             @OA\Property(
     *                 property="pymnt_coin", type="integer", example="100", description="지급코인"
     *             ),
     *             @OA\Property(
     *                 property="memo", type="string", description="메모", example="메모",
     *             ),
     *         ),
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
    public function payment(Member $request)
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

        $pymnt_coin = $request->pymnt_coin ?? 0;

        $bc_mber = BcMber::where('mngr_id', $mngr_id)->find($request->mber_id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        $mngr_id = $bc_mber->mngr_id;
        $mber_id = $bc_mber->mber_id;
        $mber_sttus = $bc_mber->mber_sttus;
        $mber_grd = $bc_mber->mber_grd;
        $hold_coin = $bc_mber->hold_coin - $pymnt_coin;
        $tot_purchs_am = $bc_mber->rcpmny_am;
        $tot_sle_am = $bc_mber->defray_am;

        DB::beginTransaction();

        try {

            $bc_mber_pymnt_dtls = new BcMberPymntDtls();
            $bc_mber_pymnt_dtls->mber_id = $mber_id;
            $bc_mber_pymnt_dtls->mngr_id = $mngr_id;
            $bc_mber_pymnt_dtls->pymnt_mngr_id = $user->mngr_id;
            $bc_mber_pymnt_dtls->mber_sttus = $mber_sttus;
            $bc_mber_pymnt_dtls->mber_grd = $mber_grd;
            $bc_mber_pymnt_dtls->hold_coin = $hold_coin;
            $bc_mber_pymnt_dtls->tot_purchs_am = $tot_purchs_am;
            $bc_mber_pymnt_dtls->tot_sle_am = $tot_sle_am;
            $bc_mber_pymnt_dtls->pymnt_coin = $pymnt_coin;
            $bc_mber_pymnt_dtls->memo = $request->memo;
            $bc_mber_pymnt_dtls->rgstr_id = $user->mngr_id;
            $bc_mber_pymnt_dtls->reg_ip = $request->ip();
            $bc_mber_pymnt_dtls->save();

            $mber_pymnt_dtls_id = $bc_mber_pymnt_dtls->mber_pymnt_dtls_id;

            $coin = $request->pymnt_coin;

            $bc_mber_coin_his = new BcMberCoinHis();
            $bc_mber_coin_his->mber_id = $mber_id;
            $bc_mber_coin_his->mber_pymnt_dtls_id = $mber_pymnt_dtls_id;
            $bc_mber_coin_his->coin_se = '3';
            $bc_mber_coin_his->pymnt_coin = $pymnt_coin;
            $bc_mber_coin_his->coin = $coin;
            $bc_mber_coin_his->rgstr_id = $user->mngr_id;
            $bc_mber_coin_his->reg_ip = $request->ip();
            $bc_mber_coin_his->save();

            $bc_mber = BcMber::find($mber_id);

            $bc_mber->update([
                'hold_coin' => DB::raw('hold_coin + '.$pymnt_coin)
            ]);

            $date = date('Y-m-d');
            $bc_mber_stats = BcMberStats::where([['sm_dd', $date], ['mber_id', $mber_id]])->first();

            if(empty($bc_mber_stats))
            {
                $bc_mber_stats = new BcMberStats();
                $bc_mber_stats->mber_id = $mber_id;
                $bc_mber_stats->stats_de = $date;
                $bc_mber_stats->purchs_co = 0;
                $bc_mber_stats->purchs_qy = 0;
                $bc_mber_stats->sle_co = 0;
                $bc_mber_stats->sle_qy = 0;
                $bc_mber_stats->rirvl_qy = 0;
                $bc_mber_stats->pymnt_qy = $pymnt_coin;
                $bc_mber_stats->csby_fee_am = 0;
                $bc_mber_stats->purchs_fee_am = 0;
                $bc_mber_stats->sle_fee_am = 0;
                $bc_mber_stats->save();
            }
            else
            {
                $update_bc_mber_stats = BcMberStats::find($bc_mber_stats->mber_stats_id);

                $update_bc_mber_stats->update([
                    'pymnt_qy' => DB::raw('pymnt_qy + '.$pymnt_coin),
                    'upd_usr_id' => $user->mngr_id,
                    'upd_ip' => $request->ip(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

            $ca_coin = $request->pymnt_coin * (-1);

            $bc_ca_coin_his = new BcCaCoinHis();
            $bc_ca_coin_his->mngr_id = $mngr_id;
            $bc_ca_coin_his->mber_pymnt_dtls_id = $mber_pymnt_dtls_id;
            $bc_ca_coin_his->coin_se = '3';
            $bc_ca_coin_his->ddct_coin = $pymnt_coin;
            $bc_ca_coin_his->coin = $ca_coin;
            $bc_ca_coin_his->rgstr_id = $user->mngr_id;
            $bc_ca_coin_his->reg_ip = $request->ip();
            $bc_ca_coin_his->save();

            $bc_mngr = BcMngr::find($mngr_id);

            $bc_mngr->update([
                'hold_coin' => DB::raw('hold_coin - '.$pymnt_coin)
            ]);

            $date = date('Y-m-d');
            $bc_ca_stats = BcCaStats::where([['sm_dd', $date], ['mngr_id', $mngr_id]])->first();

            if(empty($bc_ca_stats))
            {
                $bc_ca_stats = new BcCaStats();
                $bc_ca_stats->mngr_id = $mngr_id;
                $bc_ca_stats->stats_de = $date;
                $bc_ca_stats->purchs_co = 0;
                $bc_ca_stats->purchs_qy = 0;
                $bc_ca_stats->sle_co = 0;
                $bc_ca_stats->sle_qy = 0;
                $bc_ca_stats->rirvl_qy = 0;
                $bc_ca_stats->pymnt_qy = $pymnt_coin;
                $bc_ca_stats->csby_fee_am = 0;
                $bc_ca_stats->purchs_fee_am = 0;
                $bc_ca_stats->sle_fee_am = 0;
                $bc_ca_stats->save();
            }
            else
            {
                $update_bc_ca_stats = BcCaStats::find($bc_ca_stats->ca_stats_id);

                $update_bc_ca_stats->update([
                    'pymnt_qy' => DB::raw('pymnt_qy + '.$pymnt_coin),
                    'upd_usr_id' => $user->mngr_id,
                    'upd_ip' => $request->ip(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }

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
