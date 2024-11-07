<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\AdminManager;
use App\Http\Resources\User\BcMngrCollection;
use App\Http\Resources\User\BcMngrResource;
use App\Models\Common\BcCmmnCd;
use App\Models\History\BcCaStats;
use App\Models\User\BcMngr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminManagerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/member/admin-managers",
     *     summary="CA 회원 목록 - 슈퍼어드민",
     *     tags={"Member - SuperAdmin"},
     *     description="CA 회원 대한 정보를 리스트 형태로 받을 수 있습니다.",
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
     *         description="검색 타입(login_id:CA 회원 아이디, prtnr_nm:파트너사명, code:코드)",
     *         @OA\Schema(
     *             type="string", enum={"login_id", "prtnr_nm", "code"}, example="login_id", default="login_id"
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
     *           name="mngr_sttus",
     *           in="query",
     *           description="관리자상태(0:전체, 1:정상, 2:차단)",
     *           @OA\Schema(
     *               type="string", enum={"0", "1", "2"}, example="0", default="0"
     *           )
     *      ),
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
     *             @OA\Property(property="data", ref="#/components/schemas/MemberAdminManagersGet_BcMngrCollection"),
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

    public function index(AdminManager $request)
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

        $data = BcMngr::where('mngr_se', '2');

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

        if(!empty($request->mngr_sttus))
        {
            $data->searchBy($request->mngr_sttus, 'mngr_sttus');
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
     * @OA\Post(
     *     path="/member/admin-manager",
     *     summary="CA 아이디 생성 - 슈퍼어드민",
     *     tags={"Member - SuperAdmin"},
     *     description="CA 아이디 생성 합니다.",
     *
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="login_id", type="string", example="test", description="CA 회원 아이디"
     *             ),
     *             @OA\Property(
     *                 property="password", type="string", example="123456", description="비밀번호"
     *             ),
     *             @OA\Property(
     *                 property="prtnr_nm", type="string", example="파트너", description="파트너사명"
     *             ),
     *             @OA\Property(
     *                 property="mp_no", type="string", example="01023456789", description="담당자연락처"
     *             ),
     *             @OA\Property(
     *                 property="site_adres", type="string", example="http://test.com", description="사이트주소"
     *             ),
     *             @OA\Property(
     *                 property="bank", type="string", example="1", description="은행(BC005)"
     *             ),
     *             @OA\Property(
     *                 property="acnutno", type="string", description="계좌번호", example="12345646",
     *             ),
     *             @OA\Property(
     *                 property="dpstr", type="string", description="예금주", example="예금주",
     *             ),
     *             @OA\Property(
     *                 property="csby_fee", type="integer", example="100", description="건당수수료"
     *             ),
     *             @OA\Property(
     *                 property="purchs_fee", type="float", example="1.5", description="구매수수료"
     *             ),
     *             @OA\Property(
     *                 property="sle_fee", type="float", example="1.5", description="판매수수료"
     *             ),
     *         )
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
    public function store(AdminManager $request)
    {
        $user = auth()->user();

        if($user->mngr_se != '1')
        {
            return response()->json([
                'status'    => false,
                'message'   => '슈퍼어드민 계정이 아닙니다.',
            ], 400);
        }

        $regex = "/^[a-z0-9]+$/";

        if (!preg_match($regex, $request['login_id'])) {
            return response()->json([
                'status'    => false,
                'message'   => 'CA 회원 아이디는 영문, 숫자 입력 가능 합니다.',
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

        if (!preg_match($regex, $request['mp_no'])) {
            return response()->json([
                'status'    => false,
                'message'   => '담당자 연락처는 숫자만 입력 가능 합니다.',
            ], 400);
        }

        $regex = "/^[0-9\-]+$/";
        if (!preg_match($regex, $request['acnutno'])) {
            return response()->json([
                'status'    => false,
                'message'   => '계좌번호는 숫자와 -만 입력 가능 합니다.',
            ], 400);
        }

        if(!is_int($request['csby_fee']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '건당수수료는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(is_float($request['purchs_fee']))
        {
            if($request['purchs_fee'] > 100)
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '구매수수료은 100보다 작은 숫자를 입력 하셔야 합니다.',
                ], 400);
            }

            $check = explode('.', $request['purchs_fee']);

            if(count($check) > 1)
            {
                if(strlen($check[1]) > 1)
                {
                    return response()->json([
                        'status'    => false,
                        'message'   => '구매수수료은 소수점 첫째자리 까지만 입력 하셔야 합니다.',
                    ], 400);
                }
            }
        }

        if(is_float($request['sle_fee']))
        {
            if($request['sle_fee'] > 100)
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '판매수수료은 100보다 작은 숫자를 입력 하셔야 합니다.',
                ], 400);
            }

            $check = explode('.', $request['sle_fee']);

            if(count($check) > 1)
            {
                if(strlen($check[1]) > 1)
                {
                    return response()->json([
                        'status'    => false,
                        'message'   => '판매수수료은 소수점 첫째자리 까지만 입력 하셔야 합니다.',
                    ], 400);
                }
            }
        }

        $code = '';
        for($i=0; $i <= 100; $i++)
        {
            $random = randStrCapital(9);

            $bc_mngr_count = BcMngr::where('code', $random)->count();

            if($bc_mngr_count == 0)
            {
                $code = $random;
                break;
            }

            $i++;
        }

        DB::beginTransaction();

        try {

            $bc_mngr = new BcMngr();
            $bc_mngr->mngr_se = '2';
            $bc_mngr->mngr_sttus = '1';
            $bc_mngr->login_id = $request['login_id'];
            $bc_mngr->password = bcrypt($request['password']);
            $bc_mngr->code = $code;
            $bc_mngr->mp_no = $request['mp_no'];
            $bc_mngr->prtnr_nm = $request['prtnr_nm'];
            $bc_mngr->site_adres = $request['site_adres'];
            $bc_mngr->bank = $request['bank'];
            $bc_mngr->dpstr = $request['dpstr'];
            $bc_mngr->acnutno = $request['acnutno'];
            $bc_mngr->csby_fee = $request['csby_fee'];
            $bc_mngr->purchs_fee = $request['purchs_fee'];
            $bc_mngr->sle_fee = $request['sle_fee'];
            $bc_mngr->hold_coin = 0;
            $bc_mngr->tot_purchs_am = 0;
            $bc_mngr->tot_sle_am = 0;
            $bc_mngr->sbscrb_dt = date('Y-m-d H:i:s');
            $bc_mngr->sbscrb_ip = $request->ip();
            $bc_mngr->save();

            $bc_mngr->bcGrdComputStdr()->create([
                'comput_stdr_se'    => '1',
                'rgstr_id'          => $user->mngr_id,
                'reg_ip'            => $request->ip()
            ]);

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
     * @OA\Get(
     *      path="/member/admin-manager/{id}",
     *      summary="CA 회원 조회 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 조회 합니다.",
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
     *
     *      @OA\Response(
     *          response=200,
     *          description="성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="data", ref="#/components/schemas/MemberAdminManagerGet_BcMngrResource",
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

        $data = BcMngr::find($id);

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
     *      path="/member/admin-manager/dealings/{id}",
     *      summary="CA 회원 거래 정보 조회 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 거래 정보 조회 합니다.",
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

        $data = BcMngr::find($id);

        if(empty($data))
        {
            return response()->json([
                'status'    => false,
                'message'   => '잘못된 관리자 ID 입니다.',
            ], 400);
        }

        $data = BcCaStats::where('mngr_id', $id)
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
     *      path="/member/admin-manager/account-update/{id}",
     *      summary="CA 회원 계정 정보 업데이트 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 계정 정보 업데이트 합니다.",
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
    public function accountUpdate(AdminManager $request, $id)
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

        $regex = "/^[0-9]+$/";

        if (!preg_match($regex, $request['mp_no'])) {
            return response()->json([
                'status'    => false,
                'message'   => '담당자 연락처는 숫자만 입력 가능 합니다.',
            ], 400);
        }

        DB::beginTransaction();

        try {

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
     *      path="/member/admin-manager/account-number-update/{id}",
     *      summary="CA 회원 계좌 정보 업데이트 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 계좌 정보 업데이트 합니다.",
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
    public function accountNumberUpdate(AdminManager $request, $id)
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

    /**
     *
     * @OA\Put(
     *      path="/member/admin-manager/fee-update/{id}",
     *      summary="CA 회원 수수료 정보 업데이트 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 수수료 정보 업데이트 합니다.",
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
     *                  property="csby_fee", type="integer", example="100", description="건당수수료"
     *              ),
     *              @OA\Property(
     *                  property="purchs_fee", type="float", example="1.5", description="구매수수료"
     *              ),
     *              @OA\Property(
     *                  property="sle_fee", type="float", example="1.5", description="판매수수료"
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
    public function feeUpdate(AdminManager $request, $id)
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

        if(!is_int($request['csby_fee']))
        {
            return response()->json([
                'status'    => false,
                'message'   => '건당수수료는 정수만 입력 가능 합니다.',
            ], 400);
        }

        if(is_float($request['purchs_fee']))
        {
            if($request['purchs_fee'] > 100)
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '구매수수료은 100보다 작은 숫자를 입력 하셔야 합니다.',
                ], 400);
            }

            $check = explode('.', $request['purchs_fee']);

            if(count($check) > 1)
            {
                if(strlen($check[1]) > 1)
                {
                    return response()->json([
                        'status'    => false,
                        'message'   => '구매수수료은 소수점 첫째자리 까지만 입력 하셔야 합니다.',
                    ], 400);
                }
            }
        }

        if(is_float($request['sle_fee']))
        {
            if($request['sle_fee'] > 100)
            {
                return response()->json([
                    'status'    => false,
                    'message'   => '판매수수료은 100보다 작은 숫자를 입력 하셔야 합니다.',
                ], 400);
            }

            $check = explode('.', $request['sle_fee']);

            if(count($check) > 1)
            {
                if(strlen($check[1]) > 1)
                {
                    return response()->json([
                        'status'    => false,
                        'message'   => '판매수수료은 소수점 첫째자리 까지만 입력 하셔야 합니다.',
                    ], 400);
                }
            }
        }

        DB::beginTransaction();

        try {

            $bc_mngr->csby_fee = $request['csby_fee'];
            $bc_mngr->purchs_fee = $request['purchs_fee'];
            $bc_mngr->sle_fee = $request['sle_fee'];
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
     *      path="/member/admin-manager/status-update/{id}",
     *      summary="CA 회원 상태 정보 업데이트 - 슈퍼어드민",
     *      tags={"Member - SuperAdmin"},
     *      description="CA 회원 상태 정보 업데이트 합니다.",
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
     *                  property="mngr_sttus", type="string", description="관리자상태(BC001)", example="1",
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
    public function statusUpdate(AdminManager $request, $id)
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

        DB::beginTransaction();

        try {

            $bc_mngr->mngr_sttus = $request['mngr_sttus'];
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
