<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;

class JwtAuthenticate extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            JWTAuth::parseToken()->authenticate();

        } catch (Exception $e) {

            $status_code = "";

            if( $e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException || $e instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException ) {

                if($request->route()->named('AuthRefreshPost'))
                {
                    return $next($request);
                }

                try {

                    $message = '엑세스 토큰이 만료 되었습니다.';
                    $status_code = '0104001';

                    return response()->json( [
                        'status'    => false,
                        'status_code' => $status_code,
                        'message'   => $message,
                    ], 401 );

                } catch (TokenExpiredException $e) {
                    $message    = '세션이 만료되었습니다.';
                    $status_code = '0104002';
                } catch (JWTException $e) {
                    $message    = '리프레시 토큰이 만료되었습니다. 재로그인 하세요.';
                    $status_code = '0104003';
                } catch (Exception $e) {
                    $message    = $e->getMessage();
                    $status_code = '0104004';
                }
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $message    = '토큰이 올바르지 않습니다.';
                $status_code = '0104005';
            } else {
                $message    = '로그인이 필요한 서비스 입니다.';
                $status_code = '0104006';
            }

            return response()->json( [
                'status'    => false,
                'status_code' => $status_code,
                'message'   => $message,
            ], 401 );
        }

        return $next($request);

    }
}
