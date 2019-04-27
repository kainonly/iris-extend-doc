<?php

namespace laravel\bit\common;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Facade;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use laravel\bit\redisModel\RefreshToken;
use Lcobucci\JWT\Token;

/**
 * Class CorsCookieAuth
 * @package laravel\bit\facade
 */
final class CorsCookieAuth extends Facade
{
    /**
     * Set Token
     * @param string $label Lable
     * @param string $userId User ID
     * @param string $roleId Role ID
     * @param array $symbol Symbol Tag
     * @return boolean
     */
    public static function setToken($label, $userId, $roleId, $symbol = [])
    {
        $config = Config::get('auth.cors_cookie_auth');
        $jti = Ext::uuid();
        $ack = Ext::random();
        $token = (new Builder())
            ->setId($jti)
            ->setIssuer($config['label'][$label]['issuer'])
            ->setAudience($config['label'][$label]['audience'])
            ->set('ack', $ack)
            ->set('user', $userId)
            ->set('role', $roleId)
            ->set('symbol', $symbol)
            ->setExpiration(time() + $config['ttl'])
            ->sign($config['sha256'], $config['secret'])
            ->getToken();
        $result = RefreshToken::factory($jti, $ack);
        if (!$result) {
            return false;
        } else {
            Cookie::queue($label, (string)$token);
            return true;
        }
    }

    /**
     * Token Verify
     * @param string $label
     * @return boolean|Token
     */
    public static function tokenVerify($label)
    {
        $config = Config::get('auth.cors_cookie_auth');
        if (!Cookie::get($label)) return false;

        $token = (new Parser())->parse(Cookie::get($label));
        if (!$token->verify($config['sha256'], $config['secret'])) return false;

        if ($token->getClaim('iss') != $config['label'][$label]['issuer'] ||
            $token->getClaim('aud') != $config['label'][$label]['audience']) return false;

        if ($token->isExpired()) {
            $result = (new RefreshToken())->verify(
                $token->getClaim('jti'),
                $token->getClaim('ack')
            );
            if (!$result) return false;
            $newToken = (new Builder())
                ->setId($token->getClaim('jti'))
                ->setIssuer($config['label'][$label]['issuer'])
                ->setAudience($config['label'][$label]['audience'])
                ->set('ack', $token->getClaim('ack'))
                ->set('user', $token->getClaim('user'))
                ->set('role', $token->getClaim('role'))
                ->set('symbol', $token->getClaim('symbol'))
                ->setExpiration(time() + $config['ttl'])
                ->sign($config['sha256'], $config['secret'])
                ->getToken();

            $token = $newToken;
            Cookie::queue($label, (string)$token);
        }

        return $token;
    }

    /**
     * Clear Token
     * @param string $label
     */
    public static function tokenClear($label)
    {
        Cookie::queue(Cookie::forget($label));
    }
}