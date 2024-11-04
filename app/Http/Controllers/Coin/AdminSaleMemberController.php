<?php

namespace App\Http\Controllers\Coin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coin\AdminSaleMember;
use App\Http\Resources\Dealings\BcMberDelngDtlsChghstCollection;
use App\Http\Resources\Dealings\BcMberDelngDtlsCollection;
use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberDelngDtlsChghst;
use App\Models\History\BcDelngFeeDtls;
use App\Models\History\BcMberCoinHis;
use App\Models\History\BcMberStats;
use App\Models\User\BcMber;
use Illuminate\Support\Facades\DB;

class AdminSaleMemberController extends Controller
{
    /**
     * @OA\Get(
     *     path="/coin/admin-sale-members",
     *     summary="코인 판매(일반) 목록 - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="코인 판매(일반)에 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="검색 타입(delng_no:거래번호, login_id:회원 아이디, nm:회원명, dpstr:예금주, acnutno:계좌번호)",
     *         @OA\Schema(
     *             type="string", enum={"delng_no", "login_id", "nm", "dpstr", "acnutno"}, example="delng_no", default="delng_no"
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
     *         name="mber_grd[]",
     *         in="query",
     *         description="회원등급(1:VVIP, 2:VIP, 3:일반회원, 4:신규회원)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", enum={1, 2, 3, 4}, default="1")
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
     *             @OA\Property(property="data", ref="#/components/schemas/CoinAdminSaleMembersGet_BcMberDelngDtlsCollection"),
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

    public function index(AdminSaleMember $request)
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

        $data = BcMberDelngDtls::where('delng_se', '1')->with(
            'bcMber',
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

        if(!empty($request->mber_grd))
        {
            if(count($request->mber_grd) > 0)
            {
                $data->searchBy($request->mber_grd, 'mber_grd');
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

        return new BcMberDelngDtlsCollection($data);

    }

    /**
     *
     * @OA\Post(
     *     path="/coin/admin-sale-member",
     *     summary="코인 판매(일반)(판매액 입금) - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="판매액 입금 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="_bc_mber_delng_dtls",
     *                 type="array",
     *                 description="회원거래내역 정보",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="mber_delng_dtls_id", type="integer", description="회원거래내역ID", example="1",
     *                     ),
     *                     @OA\Property(
     *                         property="pymnt_am", type="integer", description="완료수량", example="1",
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
     *                     type="integer", description="실패 회원거래내역ID", example=1
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
    public function store(AdminSaleMember $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $mber_delng_dtls_id_array = array();
        $pymnt_am_array = array();
        foreach ($request->_bc_mber_delng_dtls as $dtls)
        {
            if($dtls['bnus_qy'] >= $dtls['compt_qy'])
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '지급 수량 보다 보너스 수량이 크거나 같을 수는 없습니다.',
                ], 400);
            }

            $mber_delng_dtls_id_array[] = $dtls['mber_delng_dtls_id'];
            $pymnt_am_qy_array[$dtls['mber_delng_dtls_id']] = $dtls['pymnt_am'];
        }

        $bc_mber_delng_dtls = BcMberDelngDtls::whereIn('mber_delng_dtls_id', $mber_delng_dtls_id_array)->with(
            'bcMber',
            'bcMngr'
        )->get();

        if(count($bc_mber_delng_dtls) != count($request->_bc_mber_delng_dtls))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원거래내역ID 입니다.',
            ], 400);
        }

        $mber_id_array = array();

        foreach ($bc_mber_delng_dtls as $dtl)
        {
            if($dtl->delng_se != '1')
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 회원거래내역ID 입니다.',
                ], 400);
            }

            if($dtl->delng_sttus == '23' || $dtl->delng_sttus == '24')
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 회원거래내역ID 입니다.',
                ], 400);
            }

            if(in_array($dtl->mber_id, $mber_id_array))
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '중복된 회원ID 입니다.',
                ], 400);
            }
            else
            {
                $mber_id_array[] = $dtl->mber_id;
            }

            $mber_delng_dtls_id = $dtl->mber_delng_dtls_id;

            if($dtl->delng_qy < $pymnt_am_array[$mber_delng_dtls_id])
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '잘못된 지급금액 입니다.',
                ], 400);
            }
        }

        $fail_mber_coin_his_id_array = array();
        foreach ($bc_mber_delng_dtls as $dtl)
        {
            $mber_delng_dtls_id = $dtl->mber_delng_dtls_id;
            $mngr_id = $dtl->mngr_id;
            $mber_id = $dtl->mber_id;
            $mber_grd = $dtl->mber_grd;
            $csby_fee_policy = $dtl->bcMngr->csby_fee;
            $purchs_fee_policy = $dtl->bcMngr->purchs_fee;
            $sle_fee_policy = $dtl->bcMngr->sle_fee;

            $pymnt_am = $pymnt_am_array[$mber_delng_dtls_id];
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

                $bc_mber_coin_his = new BcMberCoinHis();
                $bc_mber_coin_his->mber_id = $mber_id;
                $bc_mber_coin_his->mber_delng_dtls_id = $mber_delng_dtls_id;
                $bc_mber_coin_his->coin_se = '1';
                $bc_mber_coin_his->ddct_coin = $pymnt_am;
                $bc_mber_coin_his->coin = $coin;
                $bc_mber_coin_his->rgstr_id = $user->mngr_id;
                $bc_mber_coin_his->reg_ip = $request->ip();
                $bc_mber_coin_his->save();

                $bc_mber = BcMber::find($mber_id);

                $hold_qy = $bc_mber->hold_coin - $pymnt_am;

                $bc_mber->update([
                    'hold_coin' => DB::raw('hold_coin - '.$pymnt_am),
                    'rcppay_co' => DB::raw('rcppay_co + 1'),
                    'defray_am' => DB::raw('defray_am + '.$pymnt_am),
                    'tot_delng_am' => DB::raw('tot_delng_am + '.$pymnt_am)
                ]);

                $bc_mber_delng_dtls_chghst = new BcMberDelngDtlsChghst();
                $bc_mber_delng_dtls_chghst->mber_delng_dtls_id = $mber_delng_dtls_id;
                $bc_mber_delng_dtls_chghst->mber_id = $mber_id;
                $bc_mber_delng_dtls_chghst->delng_sttus = '23';
                $bc_mber_delng_dtls_chghst->hold_qy = $hold_qy;
                $bc_mber_delng_dtls_chghst->delng_qy = $delng_qy;
                $bc_mber_delng_dtls_chghst->pymnt_am = $pymnt_am;
                $bc_mber_delng_dtls_chghst->rgstr_id = $user->mngr_id;
                $bc_mber_delng_dtls_chghst->reg_ip = $request->ip();
                $bc_mber_delng_dtls_chghst->save();

                $update_bc_mber_delng_dtls = BcMberDelngDtls::find($mber_delng_dtls_id);

                $update_bc_mber_delng_dtls->update([
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
                $bc_delng_fee_dtls->mber_id = $mber_id;
                $bc_delng_fee_dtls->mngr_id = $mngr_id;
                $bc_delng_fee_dtls->mber_delng_dtls_id = $mber_delng_dtls_id;
                $bc_delng_fee_dtls->delng_se = '1';
                $bc_delng_fee_dtls->delng_no = $delng_no;
                $bc_delng_fee_dtls->mber_grd = $mber_grd;
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
                $bc_mber_stats = BcMberStats::where([['sm_dd', $date], ['mber_id', $mber_id]])->first();

                if(empty($bc_mber_stats))
                {
                    $bc_mber_stats = new BcMberStats();
                    $bc_mber_stats->mber_id = $mber_id;
                    $bc_mber_stats->stats_de = $date;
                    $bc_mber_stats->purchs_co = 0;
                    $bc_mber_stats->purchs_qy = 0;
                    $bc_mber_stats->sle_co = 1;
                    $bc_mber_stats->sle_qy = $pymnt_am ?? 0;
                    $bc_mber_stats->rirvl_qy = 0;
                    $bc_mber_stats->pymnt_qy = 0;
                    $bc_mber_stats->csby_fee_am = $csby_fee ?? 0;
                    $bc_mber_stats->purchs_fee_am = 0;
                    $bc_mber_stats->sle_fee_am = $sle_fee ?? 0;
                    $bc_mber_stats->save();
                }
                else
                {
                    $update_bc_mber_stats = BcMberStats::find($bc_mber_stats->mber_stats_id);

                    $update_bc_mber_stats->update([
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
                $fail_mber_coin_his_id_array[] = $mber_delng_dtls_id;
            }
        }

        if(count($request->_bc_mber_delng_dtls) == count($fail_mber_coin_his_id_array))
        {
            return response()->json([
                'status'    => false,
                'message'   => 'DB 데이터 저장 오류',
            ], 400);
        }

        if(count($fail_mber_coin_his_id_array) == 0)
        {
            $fail_mber_coin_his_id_array = null;
        }

        return response()->json([
            'data'     => $fail_mber_coin_his_id_array,
            'status'    => true,
            'message'   => 'success',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/coin/admin-sale-member/history",
     *     summary="코인 판매(일반) 상세 이력 - 슈퍼어드민",
     *     tags={"Coin - SuperAdmin"},
     *     description="코인 판매(일반) 상세 이력에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="mber_id",
     *         in="query",
     *         required=true,
     *         description="회원ID",
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
     *             @OA\Property(property="data", ref="#/components/schemas/CoinAdminSaleMemberHistoryGet_BcMberDelngDtlsChghstCollection"),
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

    public function history(AdminSaleMember $request)
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

        $bc_mber = BcMber::where('confm_sttus', '1')->find($request->mber_id);

        if(empty($bc_mber))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 회원ID 입니다.',
            ], 400);
        }

        $data = BcMberDelngDtlsChghst::where('mber_id', $request->mber_id);

        $data->searchBy('1', 'delng_se');

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcMberDelngDtlsChghstCollection($data);

    }
}
