<?php

namespace App\Http\Controllers\Coin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\SaleManager;
use App\Http\Resources\Dealings\BcCaDelngDtlsCollection;
use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcCaDelngDtlsChghst;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;

class SaleManagerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coin/sale-managers",
     *     summary="코인 판매 목록 - 슈퍼어드민",
     *     tags={"Coin"},
     *     description="코인 판매에 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="거래상태(21:판매신청, 22:판매접수, 23:판매완료, 24:판매취소)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", enum={21, 22, 23, 24}, default="21")
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
     *             @OA\Property(property="data", ref="#/components/schemas/CoinSaleManagersGet_BcCaDelngDtlsCollection"),
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

    public function index(SaleManager $request)
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

        $data = BcCaDelngDtls::where('delng_se', '1')->where('mngr_id', $mngr_id);

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
     *     path="/coin/sale-manager",
     *     summary="코인 판매",
     *     tags={"Coin"},
     *     description="코인 판매 합니다.",
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
     *                     property="bank", type="string", example="1", description="은행(BC005)"
     *                 ),
     *                 @OA\Property(
     *                     property="dpstr", type="string", example="예금주", description="예금주"
     *                 ),
     *                 @OA\Property(
     *                     property="acnutno", type="string", example="156549841555", description="계좌번호"
     *                 ),
     *                 @OA\Property(
     *                     property="pymnt_am", type="integer", example="1000", description="지급금액"
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
    public function store(SaleManager $request)
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

        $bc_ca_delng_dtls_count = BcCaDelngDtls::whereIn('delng_sttus', array('21', '22'))->where('delng_se', '1')->where('mngr_id', $mngr_id)->count();

        if($bc_ca_delng_dtls_count > 0)
        {
            return response()->json([
                'status'    => false,
                'message'   => '코인 판매가 진행중인 내용이 있습니다.',
            ], 400);
        }

        $items = array();

        $bc_mngr = BcMngr::find($mngr_id);

        $delng_qy = $request->delng_qy;
        $hold_qy = $bc_mngr->hold_coin;
        $bank = $bc_mngr->bank;
        $dpstr = $bc_mngr->dpstr;
        $acnutno = $bc_mngr->acnutno;

        if($hold_qy < $delng_qy)
        {
            return response()->json([
                'status'    => false,
                'message'   => '판매 수량은 내 보유 코인 수량을 초과할 수 없습니다.',
            ], 400);
        }

        $items['bank'] = $bank;
        $items['dpstr'] = $dpstr;
        $items['acnutno'] = $acnutno;
        $items['pymnt_am'] = $delng_qy;

        $delng_no = 'C'.substr(date('YmdHis', time()), 2) . sprintf('%02d', rand(1,99));

        DB::beginTransaction();

        try {

            $bc_ca_delng_dtls = new BcCaDelngDtls();
            $bc_ca_delng_dtls->mngr_id = $mngr_id;
            $bc_ca_delng_dtls->delng_se = '1';
            $bc_ca_delng_dtls->delng_sttus = '21';
            $bc_ca_delng_dtls->delng_no = $delng_no;
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
            $bc_ca_delng_dtls_chghst->delng_sttus = '21';
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
     *      path="/coin/sale-manager/cancel/{id}",
     *      summary="코인 판매(취소)",
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
    public function cancel(SaleManager $request, $id)
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

        $bc_ca_delng_dtls = BcCaDelngDtls::where('mngr_id', $mngr_id)->where('delng_se', '1')->find($id);

        if(empty($bc_ca_delng_dtls))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 CA거래내역ID 입니다.',
            ], 400);
        }

        if($bc_ca_delng_dtls->delng_sttus != '21')
        {
            return response()->json([
                'status'    => false,
                'message'   => '취소 할 수 없는 거래상태 입니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

            $bc_ca_delng_dtls->delng_sttus = '24';
            $bc_ca_delng_dtls->upd_usr_id = $user->mngr_id;
            $bc_ca_delng_dtls->upd_ip = $request->ip();
            $bc_ca_delng_dtls->updated_at = date('Y-m-d H:i:s');
            $bc_ca_delng_dtls->save();

            $bc_mngr = BcMngr::find($mngr_id);
            $hold_qy = $bc_mngr->hold_coin;

            $bc_ca_delng_dtls_chghst = new BcCaDelngDtlsChghst();
            $bc_ca_delng_dtls_chghst->ca_delng_dtls_id = $id;
            $bc_ca_delng_dtls_chghst->mngr_id = $mngr_id;
            $bc_ca_delng_dtls_chghst->delng_sttus = '24';
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
