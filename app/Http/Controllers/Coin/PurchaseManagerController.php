<?php

namespace App\Http\Controllers\Coin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\PurchaseManager;
use App\Http\Resources\Dealings\BcCaDelngDtlsCollection;
use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcCaDelngDtlsChghst;
use App\Models\User\BcAcnutSetup;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PurchaseManagerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coin/purchase-managers",
     *     summary="코인 구매 목록",
     *     tags={"Coin"},
     *     description="코인 구매에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="created_at_start",
     *         in="query",
     *         description="신청일(시작일:2021-01-01)",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="created_at_end",
     *         in="query",
     *         description="신청일(종료일:2021-01-01)",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="search_type",
     *         in="query",
     *         description="검색 타입(delng_no:거래번호)",
     *         @OA\Schema(
     *             type="string", enum={"delng_no"}, example="delng_no", default="delng_no"
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
     *         name="delng_sttus[]",
     *         in="query",
     *         description="거래상태(11:구매신청, 12:구매대기, 13:구매완료, 14:구매취소)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", enum={11, 12, 13, 14}, default="11")
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
     *         description="정렬 컬럼명(created_at:신청일시)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", default="created_at desc")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/CoinPurchaseManagersGet_BcCaDelngDtlsCollection"),
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

    public function index(PurchaseManager $request)
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

        if(!empty($request['created_at_start']))
        {
            if (!preg_match($regex, $request['created_at_start'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
        }

        if(!empty($request['created_at_end']))
        {
            if (!preg_match($regex, $request['created_at_end'])) {
                return response()->json([
                    'status'    => false,
                    'message'   => '날짜 형식이 올바르지 않습니다.',
                ], 400);
            }
        }

        $orderby = array();
        if(empty($request->orderby))
        {
            $orderby[] =  'created_at desc';
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

        $data = BcCaDelngDtls::where('delng_se', '2')->where('mngr_id', $mngr_id);

        if(!empty($request->created_at_start))
        {
            $data->searchBy($request->created_at_start, 'created_at_start');
        }

        if(!empty($request->created_at_end))
        {
            $data->searchBy($request->created_at_end, 'created_at_end');
        }

        if(!empty($request->search_type))
        {
            if(!empty($request->search_keyword))
            {
                $data->searchBy($request->search_keyword, $request->search_type);
            }
        }

        if(!empty($request->delng_sttus))
        {
            if(count($request->delng_sttus) > 0)
            {
                $data->searchBy($request->delng_sttus, 'delng_sttus');
            }
        }

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcCaDelngDtlsCollection($data);

    }

    /**
     *
     * @OA\Post(
     *     path="/coin/purchase-manager",
     *     summary="코인 구매",
     *     tags={"Coin"},
     *     description="코인 구매 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="delng_qy", type="integer", description="거래수량", example="1",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data", type="object",
     *                 @OA\Property(
     *                     property="rcpmny_bank", type="string", example="1", description="입금은행(BC005)"
     *                 ),
     *                 @OA\Property(
     *                     property="rcpmny_dpstr", type="string", example="예금주", description="입금예금주"
     *                 ),
     *                 @OA\Property(
     *                     property="rcpmny_acnutno", type="string", example="156549841555", description="입금계좌번호"
     *                 ),
     *                 @OA\Property(
     *                     property="rcpmny_am", type="integer", example="1000", description="입금금액"
     *                 ),
     *             ),
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
    public function store(PurchaseManager $request)
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

        $bc_ca_delng_dtls_count = BcCaDelngDtls::whereIn('delng_sttus', array('11', '12'))->where('delng_se', '2')->where('mngr_id', $mngr_id)->count();

        if($bc_ca_delng_dtls_count > 0)
        {
            return response()->json([
                'status'    => false,
                'message'   => '코인 구매가 진행중인 내용이 있습니다.',
            ], 400);
        }

        $items = array();

        $bc_mngr = BcMngr::find($mngr_id);

        $delng_qy = $request->delng_qy;
        $hold_qy = $bc_mngr->hold_coin;
        $bank = $bc_mngr->bank;
        $dpstr = $bc_mngr->dpstr;
        $acnutno = $bc_mngr->acnutno;

        $bc_acnut_setup = BcAcnutSetup::query()->first();
        $ca_rcpmny_bank = $bc_acnut_setup->ca_rcpmny_bank;
        $ca_rcpmny_dpstr = $bc_acnut_setup->ca_rcpmny_dpstr;
        $ca_rcpmny_acnutno = $bc_acnut_setup->ca_rcpmny_acnutno;
        $ca_mumm_rcpmny_am = $bc_acnut_setup->ca_mumm_rcpmny_am;
        $ca_mxmm_rcpmny_am = $bc_acnut_setup->ca_mxmm_rcpmny_am;

        if($ca_mumm_rcpmny_am > $delng_qy)
        {
            return response()->json([
                'status'    => false,
                'message'   => '구매 수량이 최소 구매 수량 보다 작습니다.',
            ], 400);
        }

        if($ca_mxmm_rcpmny_am < $delng_qy)
        {
            return response()->json([
                'status'    => false,
                'message'   => '구매 수량이 최대 구매 수량 보다 큽니다.',
            ], 400);
        }

        $items['rcpmny_bank'] = $ca_rcpmny_bank;
        $items['rcpmny_dpstr'] = $ca_rcpmny_dpstr;
        $items['rcpmny_acnutno'] = $ca_rcpmny_acnutno;
        $items['rcpmny_am'] = $delng_qy;

        $delng_no = 'C'.substr(date('YmdHis', time()), 2) . sprintf('%02d', rand(1,99));

        DB::beginTransaction();

        try {

            $bc_ca_delng_dtls = new BcCaDelngDtls();
            $bc_ca_delng_dtls->mngr_id = $mngr_id;
            $bc_ca_delng_dtls->delng_se = '2';
            $bc_ca_delng_dtls->delng_sttus = '11';
            $bc_ca_delng_dtls->delng_no = $delng_no;
            $bc_ca_delng_dtls->rcpmny_bank = $ca_rcpmny_bank;
            $bc_ca_delng_dtls->rcpmny_dpstr = $ca_rcpmny_dpstr;
            $bc_ca_delng_dtls->rcpmny_acnutno = $ca_rcpmny_acnutno;
            $bc_ca_delng_dtls->bank = $bank;
            $bc_ca_delng_dtls->dpstr = $dpstr;
            $bc_ca_delng_dtls->acnutno = $acnutno;
            $bc_ca_delng_dtls->hold_qy = $hold_qy;
            $bc_ca_delng_dtls->delng_qy = $delng_qy;
            $bc_ca_delng_dtls->rgstr_id = $user->mngr_id;
            $bc_ca_delng_dtls->reg_ip = $request->ip();
            $bc_ca_delng_dtls->save();

            $ca_delng_dtls_id = $bc_ca_delng_dtls->ca_delng_dtls_id;

            $bc_ca_delng_dtls_chghst = new BcCaDelngDtlsChghst();
            $bc_ca_delng_dtls_chghst->ca_delng_dtls_id = $ca_delng_dtls_id;
            $bc_ca_delng_dtls_chghst->mngr_id = $mngr_id;
            $bc_ca_delng_dtls_chghst->delng_sttus = '11';
            $bc_ca_delng_dtls_chghst->hold_qy = $hold_qy;
            $bc_ca_delng_dtls_chghst->delng_qy = $delng_qy;
            $bc_ca_delng_dtls_chghst->rgstr_id = $user->mngr_id;
            $bc_ca_delng_dtls_chghst->reg_ip = $request->ip();
            $bc_ca_delng_dtls_chghst->save();

            DB::commit();

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'    => false,
                'message'   => 'DB 데이터 저장 오류',
            ], 400);
        }

        return response()->json([
            'data'     => $items,
            'status'    => true,
            'message'   => 'success',
        ], 201);
    }

    /**
     *
     * @OA\Put(
     *      path="/coin/purchase-manager/cancel/{id}",
     *      summary="코인 구매(취소)",
     *      tags={"Coin"},
     *      description="취소 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="CA거래내역ID",
     *          @OA\Schema(
     *              type="integer",
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
    public function cancel(PurchaseManager $request, $id)
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
                'message'   => 'CA거래내역ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_ca_delng_dtls = BcCaDelngDtls::where('mngr_id', $mngr_id)->where('delng_se', '2')->find($id);

        if(empty($bc_ca_delng_dtls))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 CA거래내역ID 입니다.',
            ], 400);
        }

        if($bc_ca_delng_dtls->delng_sttus != '11')
        {
            return response()->json([
                'status'    => false,
                'message'   => '취소 할 수 없는 거래상태 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_ca_delng_dtls->delng_sttus = '14';
            $bc_ca_delng_dtls->upd_usr_id = $user->mngr_id;
            $bc_ca_delng_dtls->upd_ip = $request->ip();
            $bc_ca_delng_dtls->updated_at = date('Y-m-d H:i:s');
            $bc_ca_delng_dtls->save();

            $bc_mngr = BcMngr::find($mngr_id);
            $hold_qy = $bc_mngr->hold_coin;

            $bc_ca_delng_dtls_chghst = new BcCaDelngDtlsChghst();
            $bc_ca_delng_dtls_chghst->ca_delng_dtls_id = $id;
            $bc_ca_delng_dtls_chghst->mngr_id = $mngr_id;
            $bc_ca_delng_dtls_chghst->delng_sttus = '14';
            $bc_ca_delng_dtls_chghst->hold_qy = $hold_qy;
            $bc_ca_delng_dtls_chghst->delng_qy = $bc_ca_delng_dtls->delng_qy;
            $bc_ca_delng_dtls_chghst->rgstr_id = $user->mngr_id;
            $bc_ca_delng_dtls_chghst->reg_ip = $request->ip();
            $bc_ca_delng_dtls_chghst->save();

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
     *      path="/coin/purchase-manager/completion/{id}",
     *      summary="코인 구매(입금완료)",
     *      tags={"Coin"},
     *      description="입금완료 합니다.",
     *
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="CA거래내역ID",
     *          @OA\Schema(
     *              type="integer",
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
    public function completion(PurchaseManager $request, $id)
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
                'message'   => 'CA거래내역ID는 필수 항목입니다.',
            ], 400);
        }

        $bc_ca_delng_dtls = BcCaDelngDtls::where('mngr_id', $mngr_id)->where('delng_se', '2')->find($id);

        if(empty($bc_ca_delng_dtls))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 CA거래내역ID 입니다.',
            ], 400);
        }

        if($bc_ca_delng_dtls->delng_sttus != '11')
        {
            return response()->json([
                'status'    => false,
                'message'   => '입금완료 할 수 없는 거래상태 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_ca_delng_dtls->delng_sttus = '12';
            $bc_ca_delng_dtls->upd_usr_id = $user->mngr_id;
            $bc_ca_delng_dtls->upd_ip = $request->ip();
            $bc_ca_delng_dtls->updated_at = date('Y-m-d H:i:s');
            $bc_ca_delng_dtls->save();

            $bc_mngr = BcMngr::find($mngr_id);
            $hold_qy = $bc_mngr->hold_coin;

            $bc_ca_delng_dtls_chghst = new BcCaDelngDtlsChghst();
            $bc_ca_delng_dtls_chghst->ca_delng_dtls_id = $id;
            $bc_ca_delng_dtls_chghst->mngr_id = $mngr_id;
            $bc_ca_delng_dtls_chghst->delng_sttus = '12';
            $bc_ca_delng_dtls_chghst->hold_qy = $hold_qy;
            $bc_ca_delng_dtls_chghst->delng_qy = $bc_ca_delng_dtls->delng_qy;
            $bc_ca_delng_dtls_chghst->rgstr_id = $user->mngr_id;
            $bc_ca_delng_dtls_chghst->reg_ip = $request->ip();
            $bc_ca_delng_dtls_chghst->save();

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
