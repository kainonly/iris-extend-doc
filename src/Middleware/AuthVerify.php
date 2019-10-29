<?php

namespace Lumen\Support\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Lumen\Extra\Facade\Token;
use Lumen\Support\RedisModel\RefreshToken;

abstract class AuthVerify
{
    /**
     * @var string
     */
    protected $scene = 'default';

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            if (!Cookie::has($this->scene . '_token')) {
                return response()->json([
                    'error' => 1,
                    'msg' => 'please first authorize user login'
                ], 401);
            }

            $tokenString = Cookie::get($this->scene . '_token');
            $result = Token::verify($this->scene, $tokenString);
            if ($result->expired) {
                /**
                 * @var $token \Lcobucci\JWT\Token
                 */
                $token = $result->token;
                $jti = $token->getClaim('jti');
                $ack = $token->getClaim('ack');
                $verify = RefreshToken::create()->verify($jti, $ack);
                if (!$verify) {
                    return response()->json([
                        'error' => 1,
                        'msg' => 'refresh token verification expired'
                    ], 401);
                }
                $symbol = (array)$token->getClaim('symbol');
                $preTokenString = (string)Token::create(
                    $this->scene,
                    $jti,
                    $ack,
                    $symbol
                );
                if (empty($preTokenString)) {
                    return response()->json([
                        'error' => 1,
                        'msg' => 'create token failed'
                    ]);
                }
                Cookie::queue($this->scene . '_token', $preTokenString);
            }

            return $next($request);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'msg' => $e->getMessage()
            ], 400);
        }
    }
}
