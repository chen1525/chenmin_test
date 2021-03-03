<?php

namespace Luke\Cc;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['oauth'] = function ($pimple) {
            $oauth = new Oauth($pimple);
            return $oauth;
        };
        $pimple['oauth.access_token'] = function ($pimple) {
            $accessToken = new AccessToken($pimple);
            return $accessToken;
        };
        $pimple['user'] = function ($pimple) {
            $oauth = new User($pimple);
            return $oauth;
        };
        $pimple['sms'] = function ($pimple) {
            $oauth = new Sms($pimple);
            return $oauth;
        };

        $pimple['yon'] = function ($pimple) {
            $yon = new Yon($pimple);
            return $yon;
        };

        $pimple['yon.accessToken'] = function ($pimple) {
            $config = $pimple->getConfig();
            $accessToken = new YonAccessToken(
                $pimple,
                $config['yon']['appKey'],
                $config['yon']['appSecret'],
                $config['yon']['token_api']
            );

            return $accessToken;
        };

    }
}