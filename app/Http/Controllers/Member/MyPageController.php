<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\MyPage;
use App\Http\Resources\User\BcMngrResource;
use App\Models\Common\BcCmmnCd;
use App\Models\History\BcCaStats;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MyPageController extends Controller
{
    /**
     *
     * @OA\Get(
     *      path="/member/my-page",
     *      summary="계정 정보 조회",
     *      tags={"Member"},
     *      description="계정 정보 조회 합니다.",
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="data", ref="#/components/schemas/MemberMyPageGet_BcMngrResource",
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

        $data = BcMngr::find($mngr_id);

        if(empty($data))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자 ID 입니다.',
            ], 400);
        }

        return new BcMngrResource($data);
    }

    /**
     *
     * @OA\Get(
     *      path="/member/my-page/dealings",
     *      summary="거래 정보 조회",
     *      tags={"Member"},
     *      description="거래 정보 조회 합니다.",
     *
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
    public function dealings()
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

        $data = BcCaStats::where('mngr_id', $mngr_id)
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
     *      path="/member/my-page/password-update",
     *      summary="비밀번호 업데이트",
     *      tags={"Member"},
     *      description="비밀번호 정보 업데이트 합니다.",
     *
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
    public function passwordUpdate(MyPage $request, $id)
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

        DB::beginTransaction();

        try {

            $bc_mngr = BcMngr::find($mngr_id);
            $bc_mngr->password = bcrypt($request['password']);
            $bc_mngr->save();

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
     *      path="/member/my-page/account-update",
     *      summary="계정 정보 업데이트",
     *      tags={"Member"},
     *      description="계정 정보 업데이트 합니다.",
     *
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="prtnr_nm", type="string", example="파트너", description="파트너사명"
     *              ),
     *              @OA\Property(
     *                  property="mp_no", type="string", example="01023456789", description="담당자연락처"
     *              ),
     *              @OA\Property(
     *                  property="site_adres", type="string", example="http://test.com", description="사이트주소"
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
    public function accountUpdate(MyPage $request, $id)
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

        $regex = "/^[0-9]+$/";

        if (!preg_match($regex, $request['mp_no'])) {
            return response()->json([
                'status'    => false,
                'message'   => '담당자 연락처는 숫자만 입력 가능 합니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mngr = BcMngr::find($mngr_id);
            $bc_mngr->mp_no = $request['mp_no'];
            $bc_mngr->prtnr_nm = $request['prtnr_nm'];
            $bc_mngr->site_adres = $request['site_adres'];
            $bc_mngr->save();

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
     *      path="/member/my-page/account-number-update",
     *      summary="계좌 정보 업데이트",
     *      tags={"Member"},
     *      description="계좌 정보 업데이트 합니다.",
     *
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
    public function accountNumberUpdate(MyPage $request, $id)
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

        $bank_code = BcCmmnCd::where('cd_grp', 'BC005')->get();
        $bank_check = $bank_code->where('cd', $request['bank'])->first();

        if(empty($bank_check))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 은행코드 입니다.',
            ], 400);
        }

        $regex = "/^[0-9\-]+$/";

        if (!preg_match($regex, $request['acnutno'])) {
            return response()->json([
                'status'    => false,
                'message'   => '계좌번호는 숫자와 -만 입력 가능 합니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_mngr = BcMngr::find($mngr_id);
            $bc_mngr->bank = $request['bank'];
            $bc_mngr->dpstr = $request['dpstr'];
            $bc_mngr->acnutno = $request['acnutno'];
            $bc_mngr->save();

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
