<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Http\Requests\Statistics\AdminDate;
use App\Http\Resources\History\BcCaStatsCollection;
use App\Models\History\BcCaStats;

class DateController extends Controller
{
    /**
     * @OA\Get(
     *     path="/statistics/dates",
     *     summary="날짜 별 통계 목록",
     *     tags={"Statistics"},
     *     description="날짜 별 통계에 대한 정보를 리스트 형태로 받을 수 있습니다.",
     *
     *     @OA\Parameter(
     *         name="stats_de_start",
     *         in="query",
     *         description="통계일자(시작일:2021-01-01)",
     *         @OA\Schema(
     *             type="string",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="stats_de_end",
     *         in="query",
     *         description="통계일자(종료일:2021-01-01)",
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
     *         description="정렬 컬럼명(stats_de:통계일자)",
     *         @OA\Schema(
     *             type="array", @OA\Items(type="string", default="stats_de desc")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="성공",
     *         @OA\JsonContent(
     *             @OA\Property(property="data", ref="#/components/schemas/StatisticsDatesGet_BcCaStatsCollection"),
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

    public function index(AdminDate $request)
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

        $orderby = array();
        if(empty($request->orderby))
        {
            $orderby[] =  'stats_de desc';
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

        $data = BcCaStats::where('mngr_id', $mngr_id);

        if(!empty($request->stats_de_start))
        {
            $data->searchBy($request->stats_de_start, 'stats_de_start');
        }

        if(!empty($request->stats_de_end))
        {
            $data->searchBy($request->stats_de_end, 'stats_de_end');
        }

        foreach ($orderby as $order)
        {
            $data->orderByRaw($order);
        }

        $data = $data->paginate($request->per_page);

        return new BcCaStatsCollection($data);

    }
}
