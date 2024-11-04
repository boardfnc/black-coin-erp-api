<?php

namespace App\Http\Controllers\Dealings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dealings\AdminMemberDetail;
use App\Http\Resources\Dealings\BcMberDelngDtlsChghstCollection;
use App\Http\Resources\Dealings\BcMberDelngDtlsCollection;
use App\Models\Dealings\BcMberDelngDtls;
use App\Models\Dealings\BcMberDelngDtlsChghst;
use App\Models\User\BcMber;

class AdminMemberDetailController extends Controller
{
    /**
     * @OA\Get(
     *     path="/dealings/admin-member-details",
     *     summary="회원 거래 내역 목록 - 슈퍼어드민",
     *     tags={"Dealings - SuperAdmin"},
     *     description="회원 거래 내역 에 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="검색 타입(delng_no:거래번호, login_id:회원 아이디, nm:회원명)",
     *         @OA\Schema(
     *             type="string", enum={"delng_no", "login_id", "nm"}, example="delng_no", default="delng_no"
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
     *          name="delng_se",
     *          in="query",
     *          description="거래구분(1:판매, 2:구매, 4:취소)",
     *          @OA\Schema(
     *              type="string", enum={"1", "2", "4"}, example="1", default="1"
     *          )
     *     ),
     *     @OA\Parameter(
     *         name="delng_sttus",
     *         in="query",
     *         description="거래상태(11:구매신청, 12:구매대기, 13:구매완료, 14:구매취소, 21:판매신청, 22:판매접수, 23:판매완료, 24:판매취소)",
     *         @OA\Schema(
     *             type="string", enum={11, 12, 13, 14, 21, 22, 23, 24}, example="11", default="11"
     *         )
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
     *             @OA\Property(property="data", ref="#/components/schemas/DealingsAdminMemberDetailsGet_BcMberDelngDtlsCollection"),
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

    public function index(AdminMemberDetail $request)
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

        $data = BcMberDelngDtls::with(
            'bcMber'
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

        if(!empty($request->delng_se))
        {
            if($request->delng_se == '4')
            {
                $delng_sttus = array('14', '24');
                $data->searchBy($delng_sttus, 'delng_sttus');
            }
            else
            {
                $data->searchBy($request->delng_se, 'delng_se');
                if(!empty($request->delng_sttus))
                {
                    $delng_sttus = array($request->delng_sttus);
                    $data->searchBy($delng_sttus, 'delng_sttus');
                }
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
     * @OA\Get(
     *     path="/dealings/admin-member-detail/history",
     *     summary="회원 거래 내역 상세 이력 - 슈퍼어드민",
     *     tags={"Dealings - SuperAdmin"},
     *     description="회원 거래 내역 상세 이력에 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *             @OA\Property(property="data", ref="#/components/schemas/DealingsAdminMemberDetailHistoryGet_BcMberDelngDtlsChghstCollection"),
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

    public function history(AdminMemberDetail $request)
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

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcMberDelngDtlsChghstCollection($data);

    }
}
