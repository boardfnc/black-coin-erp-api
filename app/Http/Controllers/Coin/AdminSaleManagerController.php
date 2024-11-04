<?php

namespace App\Http\Controllers\Coin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\AdminSaleManager;
use App\Http\Resources\Dealings\BcCaDelngDtlsChghstCollection;
use App\Http\Resources\Dealings\BcCaDelngDtlsCollection;
use App\Models\Dealings\BcCaDelngDtls;
use App\Models\Dealings\BcCaDelngDtlsChghst;
use App\Models\History\BcCaCoinHis;
use App\Models\History\BcCaStats;
use App\Models\History\BcDelngFeeDtls;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;

class AdminSaleManagerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coin/admin-sale-managers",
     *     summary="코인 판매(CA) 목록 - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="코인 판매(CA)에 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="검색 타입(delng_no:거래번호, login_id:회원 아이디, prtnr_nm:파트너사명, code:코드, dpstr:예금주, acnutno:계좌번호)",
     *         @OA\Schema(
     *             type="string", enum={"delng_no", "login_id", "prtnr_nm", "code", "dpstr", "acnutno"}, example="delng_no", default="delng_no"
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
     *             @OA\Property(property="data", ref="#/components/schemas/CoinAdminSaleManagersGet_BcCaDelngDtlsCollection"),
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

    public function index(AdminSaleManager $request)
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

        $data = BcCaDelngDtls::where('delng_se', '1')->with(
            'bcMngr'
        );

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
     *     path="/coin/admin-sale-manager",
     *     summary="코인 판매(CA)(판매액 입금) - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="판매액 입금 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="_bc_ca_delng_dtls",
     *                 type="array",
     *                 description="CA거래내역 정보",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="ca_delng_dtls_id", type="integer", description="CA거래내역ID", example="1",
     *                     ),
     *                     @OA\Property(
     *                         property="pymnt_am", type="integer", description="지급금액", example="1",
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data", type="array",
     *                 @OA\Items(
     *                     type="integer", description="실패 CA거래내역ID", example=1
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
    public function store(AdminSaleManager $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $ca_delng_dtls_id_array = array();
        $pymnt_am_array = array();
        foreach ($request->_bc_ca_delng_dtls as $dtls)
        {
            $ca_delng_dtls_id_array[] = $dtls['ca_delng_dtls_id'];
            $pymnt_am_array[$dtls['ca_delng_dtls_id']] = $dtls['pymnt_am'];
        }

        $bc_ca_delng_dtls = BcCaDelngDtls::whereIn('ca_delng_dtls_id', $ca_delng_dtls_id_array)->with(
            'bcMngr'
        )->get();

        if(count($bc_ca_delng_dtls) != count($request->_bc_ca_delng_dtls))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 CA거래내역ID 입니다.',
            ], 400);
        }

        $mngr_id_array = array();

        foreach ($bc_ca_delng_dtls as $dtl)
        {
            if($dtl->delng_se != '1')
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 CA거래내역ID 입니다.',
                ], 400);
            }

            if($dtl->delng_sttus == '23' || $dtl->delng_sttus == '24')
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 CA거래내역ID 입니다.',
                ], 400);
            }

            if(in_array($dtl->mngr_id, $mngr_id_array))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '중복된 관리자ID 입니다.',
                ], 400);
            }
            else
            {
                $mngr_id_array[] = $dtl->mngr_id;
            }

            $ca_delng_dtls_id = $dtl->ca_delng_dtls_id;

            if($dtl->delng_qy < $pymnt_am_array[$ca_delng_dtls_id])
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 지급금액 입니다.',
                ], 400);
            }
        }

        $fail_ca_coin_his_id_array = array();
        foreach ($bc_ca_delng_dtls as $dtl)
        {
            $ca_delng_dtls_id = $dtl->ca_delng_dtls_id;
            $mngr_id = $dtl->mngr_id;
            $csby_fee_policy = $dtl->bcMngr->csby_fee;
            $purchs_fee_policy = $dtl->bcMngr->purchs_fee;
            $sle_fee_policy = $dtl->bcMngr->sle_fee;

            $pymnt_am = $pymnt_am_array[$ca_delng_dtls_id];
            $delng_qy = $dtl->delng_qy;
            $delng_no = $dtl->delng_no;

            $csby_fee = (empty($csby_fee_policy))?0:$csby_fee_policy;
            $sle_fee = 0;

            if(!empty($sle_fee_policy))
            {
                $sle_fee = floor($pymnt_am * ($sle_fee_policy*0.01));
            }

            DB::beginTransaction();

            try {

                $coin = $pymnt_am * (-1);

                $bc_ca_coin_his = new BcCaCoinHis();
                $bc_ca_coin_his->mngr_id = $mngr_id;
                $bc_ca_coin_his->ca_delng_dtls_id = $ca_delng_dtls_id;
                $bc_ca_coin_his->coin_se = '1';
                $bc_ca_coin_his->ddct_coin = $pymnt_am;
                $bc_ca_coin_his->coin = $coin;
                $bc_ca_coin_his->rgstr_id = $user->mngr_id;
                $bc_ca_coin_his->reg_ip = $request->ip();
                $bc_ca_coin_his->save();

                $bc_mngr = BcMngr::find($mngr_id);

                $hold_qy = $bc_mngr->hold_coin - $pymnt_am;

                $bc_mngr->update([
                    'hold_coin' => DB::raw('hold_coin - '.$pymnt_am),
                    'tot_sle_am' => DB::raw('tot_sle_am + '.$pymnt_am)
                ]);

                $bc_ca_delng_dtls_chghst = new BcCaDelngDtlsChghst();
                $bc_ca_delng_dtls_chghst->ca_delng_dtls_id = $ca_delng_dtls_id;
                $bc_ca_delng_dtls_chghst->mngr_id = $mngr_id;
                $bc_ca_delng_dtls_chghst->delng_sttus = '23';
                $bc_ca_delng_dtls_chghst->hold_qy = $hold_qy;
                $bc_ca_delng_dtls_chghst->delng_qy = $delng_qy;
                $bc_ca_delng_dtls_chghst->pymnt_am = $pymnt_am;
                $bc_ca_delng_dtls_chghst->rgstr_id = $user->mngr_id;
                $bc_ca_delng_dtls_chghst->reg_ip = $request->ip();
                $bc_ca_delng_dtls_chghst->save();

                $update_bc_ca_delng_dtls = BcCaDelngDtls::find($ca_delng_dtls_id);

                $update_bc_ca_delng_dtls->update([
                    'delng_sttus' => '23',
                    'pymnt_am' => $pymnt_am,
                    'upd_usr_id' => $user->mngr_id,
                    'upd_ip' => $request->ip(),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);

                $fee_blce = 0;

                $first_bc_delng_fee_dtls = BcDelngFeeDtls::where('mngr_id', $mngr_id)->orderByDesc('delng_fee_dtls_id')->first();

                if(!empty($first_bc_delng_fee_dtls))
                {
                    $fee_blce = $first_bc_delng_fee_dtls->fee_blce+$csby_fee+$sle_fee;
                }
                else
                {
                    $fee_blce = $csby_fee+$sle_fee;
                }

                $bc_delng_fee_dtls = new BcDelngFeeDtls();
                $bc_delng_fee_dtls->mngr_id = $mngr_id;
                $bc_delng_fee_dtls->ca_delng_dtls_id = $ca_delng_dtls_id;
                $bc_delng_fee_dtls->delng_se = '1';
                $bc_delng_fee_dtls->delng_no = $delng_no;
                $bc_delng_fee_dtls->csby_fee_policy = $csby_fee_policy;
                $bc_delng_fee_dtls->purchs_fee_policy = $purchs_fee_policy;
                $bc_delng_fee_dtls->sle_fee_policy = $sle_fee_policy;
                $bc_delng_fee_dtls->csby_fee = $csby_fee;
                $bc_delng_fee_dtls->sle_fee = $sle_fee;
                $bc_delng_fee_dtls->fee_blce = $fee_blce;
                $bc_delng_fee_dtls->ca_coin_blce = $hold_qy;
                $bc_delng_fee_dtls->rgstr_id = $user->mngr_id;
                $bc_delng_fee_dtls->reg_ip = $request->ip();
                $bc_delng_fee_dtls->save();

                $date = date('Y-m-d');
                $bc_ca_stats = BcCaStats::where([['sm_dd', $date], ['mngr_id', $mngr_id]])->first();

                if(empty($bc_ca_stats))
                {
                    $bc_ca_stats = new BcCaStats();
                    $bc_ca_stats->mngr_id = $mngr_id;
                    $bc_ca_stats->stats_de = $date;
                    $bc_ca_stats->purchs_co = 0;
                    $bc_ca_stats->purchs_qy = 0;
                    $bc_ca_stats->sle_co = 1;
                    $bc_ca_stats->sle_qy = $pymnt_am ?? 0;
                    $bc_ca_stats->rirvl_qy = 0;
                    $bc_ca_stats->pymnt_qy = 0;
                    $bc_ca_stats->csby_fee_am = $csby_fee ?? 0;
                    $bc_ca_stats->purchs_fee_am = 0;
                    $bc_ca_stats->sle_fee_am = $sle_fee ?? 0;
                    $bc_ca_stats->save();
                }
                else
                {
                    $update_bc_ca_stats = BcCaStats::find($bc_ca_stats->ca_stats_id);

                    $update_bc_ca_stats->update([
                        'sle_co' => DB::raw('sle_co + 1'),
                        'sle_qy' => DB::raw('sle_qy + '.$pymnt_am ?? 0),
                        'csby_fee_am' => DB::raw('csby_fee_am + '.$csby_fee ?? 0),
                        'sle_fee_am' => DB::raw('sle_fee_am + '.$sle_fee ?? 0),
                        'upd_usr_id' => $user->mngr_id,
                        'upd_ip' => $request->ip(),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }

                DB::commit();

            } catch (\Exception $e) {

                DB::rollBack();
                $fail_ca_coin_his_id_array[] = $ca_delng_dtls_id;
            }
        }

        if(count($request->_bc_ca_delng_dtls) == count($fail_ca_coin_his_id_array))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'DB 데이터 저장 오류',
            ], 400);
        }

        if(count($fail_ca_coin_his_id_array) == 0)
        {
            $fail_ca_coin_his_id_array = null;
        }

        return response()->json([
            'data'     => $fail_ca_coin_his_id_array,
            'status'    => true,
            'message'   => 'success',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/coin/admin-sale-manager/history",
     *     summary="코인 판매(CA) 상세 이력 - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="코인 판매(CA) 상세 이력에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="mngr_id",
     *         in="query",
     *         required=true,
     *         description="관리자ID",
     *         @OA\Schema(
     *             type="integer"
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
     *             @OA\Property(property="data", ref="#/components/schemas/CoinAdminSaleManagerHistoryGet_BcCaDelngDtlsChghstCollection"),
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

    public function history(AdminSaleManager $request)
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

        $bc_mngr = BcMngr::where('mngr_se', '2')->find($request->mngr_id);

        if(empty($bc_mngr))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자ID 입니다.',
            ], 400);
        }


        $data = BcCaDelngDtlsChghst::where('mngr_id', $request->mngr_id);

        $data->searchBy('1', 'delng_se');

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcCaDelngDtlsChghstCollection($data);

    }
}
