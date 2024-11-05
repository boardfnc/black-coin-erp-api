<?php

namespace App\Http\Controllers\Auth;

use App\Models\User\BcMngr;
use App\Models\User\BcMngrCrtfc;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\Auth\UserResource;

class JWTAuthController extends Controller
{
    /**
     * @OA\Post(
     *      path="/auth/login",
     *      summary="사용자 로그인",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="login_id", type="string", description="로그인 ID",
     *              ),
     *              @OA\Property(
     *                  property="password", type="string", description="비밀번호 : 최소 6글자, 최대 15글자",
     *              ),
     *              required={"login_id", "password"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="로그인 성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=true,
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0000000", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="token",
     *                      type="object",
     *                      @OA\Property(
     *                          property="access_token",
     *                          type="string",
     *                          example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvd3d3LmltYXdzLmNvbVwvIiwic3ViIjoiXHVjODFjXHViYWE5IiwiYXVkIjoiXHViMzAwXHVjMGMxXHVjNzkwIiwiaWF0IjoxNjIzOTExNzExLCJleHAiOjE2MjM5MTUzMTEsIm5iZiI6MTYyMzkxMTcxMSwibWJfaWQiOiIxIn0.Ph3VffX9RBaYQXhsBvTBExMi1VRRA2SIr-98effCUBc"
     *                      ),
     *                      @OA\Property(
     *                          property="refresh_token",
     *                          type="string",
     *                          example="1babcb8017f8e4882fa7f22229c2508bb8b6bdd1fab7e6f3bbde4a7a4e5051aaa92f907bc96b774c09c134a998e870a07028e2568b16e451b83cc32600cdf39e"
     *                      ),
     *                      @OA\Property(
     *                          property="token_type", type="string", example="bearer",
     *                      ),
     *                      @OA\Property(
     *                          property="expires_in", type="integer", example=3600,
     *                      ),
     *                  ),
     *                  @OA\Property(
     *                      property="me",
     *                      type="object",
     *                      description="사용자 정보",
     *                      @OA\Property(
     *                          property="mber_id", type="integer", example="1",
     *                      ),
     *                      @OA\Property(
     *                          property="mber_se", type="string", example="1",
     *                      ),
     *                      @OA\Property(
     *                          property="mber_sttus", type="string", example="1",
     *                      ),
     *                      @OA\Property(
     *                          property="login_id", type="string", example="test",
     *                      ),
     *                      @OA\Property(
     *                          property="_fab_empl", type="object", description="사원정보",
     *                      ),
     *                      @OA\Property(
     *                          property="_fab_cmpny", type="object", description="회사정보",
     *                      ),
     *                      @OA\Property(
     *                          property="_fab_dept", type="object", description="부서정보",
     *                      ),
     *                      @OA\Property(
     *                          property="_fab_rspofc", type="object", description="직위정보",
     *                      ),
     *                  ),
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
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="{아이디}은(는) 필수 항목입니다."
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="credentials 불일치로 인한 인증 실패 및 관리자 또는 사용자 상태에 의한 로그인 제한",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=false,
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="로그인 정보가 올바르지 않습니다."
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="시스템 오류로 인한 토큰 생성 실패",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status", type="boolean", example=false
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message", type="string", example="토큰을 생성할 수 없습니다."
     *              ),
     *          )
     *      ),
     * )
     *
     */
    public function authenticate(Request $request)
    {
        $validator_value = $request->only('login_id', 'password');
        $credentials = $request->only('login_id', 'password');

        $validator = [
            'login_id'              => 'required|string',
            'password'              => 'required|string|min:6|max:15',
        ];
        $messages = [
            'login_id.required'     => '0101001:아이디를 입력해 주세요.',
            'password.min'          => '0101002:비밀번호는 6자리 이상 입력하세요',
            'password.max'          => '0101003:비밀번호는 15자리 이하 입력하세요',
        ];

        $validator = Validator::make( $validator_value, $validator, $messages);

        try {
            if ( $validator->fails() ) {
                $massage_array = explode(':', $validator->errors()->first());
                return response()->json( [
                    'status'    => false,
                    'status_code'    => $massage_array[0],
                    'message'   => $massage_array[1],
                ], 400 );
            }

            if ( !$token = auth()->attempt( $credentials ) ) {
                return response()->json( [
                    'status'    => false,
                    'status_code'    => '0101004',
                    'message'   => '로그인 정보가 올바르지 않습니다.',
                ], 401 );
            }

            $currentMember = auth()->user();

            $agent = new Agent();

            $bcMngr = BcMngr::find($currentMember->mngr_id);
            $bcMngr->last_conect_dt = Carbon::now();
            $bcMngr->last_conect_ip = $request->ip();
            $bcMngr->last_conect_os = $agent->platform();
            $bcMngr->last_conect_brwsr = $agent->browser();
            $bcMngr->save();

            if ( '2' == $currentMember->mngr_sttus ) {
                return response()->json( [
                    'status'    => false,
                    'status_code'    => '0101005',
                    'message'   => '정지 계정입니다.',
                ], 401 );
            }

            $random = Str::random(256).time();
            $refresh_token = hash('sha512', $random);

            $check = $currentMember->bcMngrCrtfc->first();

            if(!empty($check))
            {
                $bcMngrCrtfc                = $currentMember->bcMngrCrtfc->find($check->mngr_crtfc_id);
                $bcMngrCrtfc->tkn           = $refresh_token;
                $bcMngrCrtfc->conect_ip     = $request->ip();
                $bcMngrCrtfc->upd_usr_id    = $currentMember->mngr_id;
                $bcMngrCrtfc->upd_ip        = $request->ip();
                $result                     = $bcMngrCrtfc->save();

                if(!$result)
                {
                    return response()->json( [
                        'status'    => false,
                        'status_code'    => '0101008',
                        'message'   => '토큰을 생성할 수 없습니다.',
                    ], 401 );
                }
            }
            else
            {
                $result = $currentMember->bcMngrCrtfc()->create([
                    'tkn'           => $refresh_token,
                    'conect_ip'     => $request->ip(),
                    'rgstr_id'      => $currentMember->mngr_id,
                    'reg_ip'        => $request->ip()
                ]);

                if(!$result)
                {
                    return response()->json( [
                        'status'    => false,
                        'status_code'    => '0101009',
                        'message'   => '토큰을 생성할 수 없습니다.',
                    ], 401 );
                }
            }

            return response()->json([
                'status'    => true,
                'status_code'    => '0000000',
                'data'      => [
                    'token' => [
                        'access_token'      => $token,
                        'refresh_token'     => $refresh_token,
                        'token_type'        => 'bearer',
                        'expires_in'        => auth()->factory()->getTTL() * 60,
                    ],
                    'me'    => new UserResource( $currentMember ),
                ],
            ]);
        } catch (Exception $e) {
            if ( $e instanceof JWTException ) {
                return response()->json( [
                    'status'    => false,
                    'status_code'    => '0101010',
                    'message'   => '토큰을 생성할 수 없습니다.',
                ], 500 );
            }

            return response()->json( [
                'status'    => false,
                'status_code'    => '0101011',
                'message'   => $e->getMessage(),
            ], $e->getCode() );
        }
    }

    /**
     *
     * @OA\Delete(
     *      path="/auth/logout",
     *      summary="사용자 로그아웃",
     *      tags={"Auth"},
     *      @OA\Response(
     *          response=200,
     *          description="로그아웃 성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=true,
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0000000", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="성공적으로 로그아웃 되었습니다.",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="시스템 오류로 인한 로그아웃 실패",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="로그아웃에 실패하였습니다."
     *              ),
     *          )
     *      ),
     *      security={
     *         {"apiAuth": {}}
     *      }
     * )
     *
     */
    public function logout(Request $request)
    {

        try {

            auth()->logout();

            return response()->json([
                'status'    => true,
                'status_code'    => '0000000',
                'message'   => '성공적으로 로그아웃 되었습니다.'
            ], 200 );
        } catch (Exception $e) {
            if ( $e instanceof JWTException ) {
                return response()->json([
                    'status'   => false,
                    'status_code'    => '01020101',
                    'message'   => '로그아웃에 실패하였습니다.'
                ], 500 );
            }

            return response()->json( [
                'status'    => false,
                'status_code'    => '01020102',
                'message'   => $e->getMessage(),
            ], $e->getCode() );
        }
    }

    /**
     *
     * @OA\Post(
     *      path="/auth/refresh",
     *      summary="토큰 새로고침",
     *      tags={"Auth"},
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="refresh_token", type="string", description="리플레시 토큰",
     *              ),
     *              required={"refresh_token"}
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="토큰 새로고침 성공",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=true,
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0000000", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="object",
     *                  @OA\Property(
     *                      property="token",
     *                      type="object",
     *                      @OA\Property(
     *                          property="access_token",
     *                          type="string",
     *                          example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvd3d3LmltYXdzLmNvbVwvIiwic3ViIjoiXHVjODFjXHViYWE5IiwiYXVkIjoiXHViMzAwXHVjMGMxXHVjNzkwIiwiaWF0IjoxNjIzOTExNzExLCJleHAiOjE2MjM5MTUzMTEsIm5iZiI6MTYyMzkxMTcxMSwibWJfaWQiOiIxIn0.Ph3VffX9RBaYQXhsBvTBExMi1VRRA2SIr-98effCUBc"
     *                      ),
     *                      @OA\Property(
     *                          property="token_type", type="string", example="bearer",
     *                      ),
     *                      @OA\Property(
     *                          property="expires_in", type="integer", example=3600,
     *                      ),
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="로그인 되어 있지 않거나 정보가 일치하지 않아 토큰 새로고침 실패",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=false,
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="로그인 되어 있지 않습니다.",
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="시스템 오류로 인한 토큰 새로고침 실패",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="status",
     *                  type="boolean",
     *                  example=false
     *              ),
     *              @OA\Property(
     *                  property="status_code", type="string", example="0101001", description="상태코드(API 상태 코드표 참조)",
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="토큰 새로고침에 실패하였습니다."
     *              ),
     *          )
     *      ),
     *      security={
     *         {"apiAuth": {}}
     *      }
     * )
     *
     */
    public function refresh(Request $request)
    {
        try {

            $bcMngrCrtfc = BcMngrCrtfc::where('tkn', $request['refresh_token'])->first();

            if(empty($bcMngrCrtfc))
            {
                return response()->json([
                    'status'   => false,
                    'status_code' => '0103001',
                    'message'   => '정보가 일치하지 않아 토큰 새로고침 실패하였습니다.'
                ], 400 );
            }

            // TODO :: 2024-02-14 동적IP로 인증 안되는 경우때문에 주석처리
//            if($fabCrtfc->conect_ip != $request->ip())
//            {
//                return response()->json([
//                    'status'   => false,
//                    'status_code' => '0103002',
//                    'message'   => '정보가 일치하지 않아 토큰 새로고침 실패하였습니다.'
//                ], 400 );
//            }

            $bcMngrCrtfcUpdate                 = BcMngrCrtfc::find($bcMngrCrtfc->mngr_crtfc_id);
            $bcMngrCrtfcUpdate->conect_ip      = $request->ip();
            $bcMngrCrtfcUpdate->upd_usr_id     = $bcMngrCrtfc->mngr_id;
            $bcMngrCrtfcUpdate->upd_ip         = $request->ip();
            $result                            = $bcMngrCrtfcUpdate->save();

            if(!$result)
            {
                return response()->json([
                    'status'   => false,
                    'status_code' => '0103003',
                    'message'   => '토큰을 생성할 수 없습니다.'
                ], 401 );
            }

            $new_token = auth()->refresh();

            return response()->json([
                'status'    => true,
                'status_code' => '0000000',
                'data'      => [
                    'token' => [
                        'access_token'  => $new_token,
                        'token_type'    => 'bearer',
                        'expires_in'    => auth()->factory()->getTTL() * 60,
                    ]
                ],
            ], 200);

        } catch (Exception $e) {
            if ( $e instanceof JWTException ) {
                return response()->json([
                    'status'   => false,
                    'status_code' => '0103004',
                    'message'   => '토큰 새로고침에 실패하였습니다.'
                ], 500 );
            }

            return response()->json( [
                'status'    => false,
                'status_code' => '0103005',
                'message'   => $e->getMessage(),
            ], $e->getCode() );
        }
    }
}
