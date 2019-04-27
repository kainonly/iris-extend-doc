<?php

namespace laravel\bit\facade;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Facade;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use laravel\bit\redis\RefreshToken;

/**
 * Class CorsCookieAuth
 * @package laravel\bit\facade
 */
class CorsCookieAuth extends Facade
{
    /**
     * Set Token
     * @param string $userId User ID
     * @param string $roleId Role ID
     * @param array $symbol Symbol Tag
     * @return array
     */
    public static function setToken($userId, $roleId, $symbol = [])
    {
        try {
            $config = Config::get('auth.cors_cookie_auth');
            $jti = Ext::uuid();
            $ack = Ext::random();
            $token = (new Builder())
                ->setId($jti)
                ->setIssuer($config['issuer'])
                ->setAudience($config['audience'])
                ->set('ack', $ack)
                ->set('user', $userId)
                ->set('role', $roleId)
                ->set('symbol', $symbol)
                ->setExpiration(time() + $config['ttl'])
                ->sign($config['sha256'], $config['secret'])
                ->getToken();

            $result = RefreshToken::factory($jti, $ack);
            if (!$result) return [
                'error' => 1,
                'msg' => 'error:factory_refresh_token_failed'
            ];

            Cookie::queue($config['token_name'], (string)$token, 21600, null, null, true, true);
            return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => 'error:' . $e->getMessage()
            ];
        }
    }

    /**
     * Token Verify
     * @return array
     */
    public static function tokenVerify()
    {
        try {
            $config = Config::get('auth.cors_cookie_auth');
            if (!Cookie::get($config['token_name'])) return [
                'error' => 1,
                'msg' => 'error:not_exists_token'
            ];

            $token = (new Parser())->parse(Cookie::get($config['token_name']));
            if (!$token->verify($config['sha256'], $config['secret'])) return [
                'error' => 1,
                'msg' => 'error:verify'
            ];

            if ($token->getClaim('iss') != $config['issuer'] ||
                $token->getClaim('aud') != $config['audience']) return [
                'error' => 1,
                'msg' => 'error:incorrect'
            ];

            if ($token->isExpired()) {
                $result = (new RefreshToken())->verify(
                    $token->getClaim('jti'),
                    $token->getClaim('ack')
                );

                if (!$result) return [
                    'error' => 1,
                    'msg' => 'error:expired'
                ];

                $newToken = (new Builder())
                    ->setId($token->getClaim('jti'))
                    ->setIssuer($config['issuer'])
                    ->setAudience($config['audience'])
                    ->set('ack', $token->getClaim('ack'))
                    ->set('user', $token->getClaim('user'))
                    ->set('role', $token->getClaim('role'))
                    ->set('symbol', $token->getClaim('symbol'))
                    ->setExpiration(time() + $config['ttl'])
                    ->sign($config['sha256'], $config['secret'])
                    ->getToken();

                $token = $newToken;
                Cookie::queue($config['token_name'], (string)$token, 21600, null, null, true, true);
            }

            return [
                'error' => 0,
                'msg' => 'ok'
            ];
        } catch (\Exception $e) {
            return [
                'error' => 1,
                'msg' => 'error:' . $e->getMessage()
            ];
        }
    }

    /**
     * clear token
     */
    public function tokenClear()
    {
        $config = Config::get('auth.cors_cookie_auth');
        Cookie::queue(Cookie::forget($config['token_name']));
    }
}