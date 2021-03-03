<?php

namespace Luke\Cc;

use Exception;
use Hanson\Foundation\AbstractAccessToken;

class YonAccessToken extends AbstractAccessToken
{
    /**
     * key of token in json.
     *
     * @var string
     */
    protected $tokenJsonKey = 'access_token';

    /**
     * key of expires in json.
     *
     * @var string
     */
    protected $expiresJsonKey = 'expire';

    /**
     * @var string
     */
    protected $appKey;

    /**
     * @var string
     */
    protected $appSecret;

    /**
     * @var string
     */
    protected $token_api;

    /**
     * cache prefix.
     *
     * @var string
     */
    protected $prefix = 'yon.cache.';

    public function __construct($app, $appKey, $appSecret, $token_api)
    {
        $this->app = $app;
        $this->appKey = $appKey;
        $this->appSecret = $appSecret;
        $this->token_api = $token_api;
    }

    public function getToken($forceRefresh = false)
    {
        $cached = $this->getCache()->fetch($this->getCacheKey()) ?: $this->token;

        if ($forceRefresh || empty($cached)) {

            $result = $this->getTokenFromServer();

            $this->checkTokenResponse($result);

            $this->setToken(
                $token = $result['data'][$this->tokenJsonKey],
                $this->expiresJsonKey ? $result['data'][$this->expiresJsonKey] : null
            );

            return $token;
        }

        return $cached;
    }

    /**
     * Get token from remote server.
     *
     * @return mixed
     */
    public function getTokenFromServer()
    {
        $time = time();
        $signature = base64_encode(hash_hmac('sha256', 'appKey' . $this->appKey . 'timestamp' . $time, $this->appSecret, true));
        try {
            $response = $this->getHttp()->get($this->token_api, [
                'appKey' => $this->appKey,
                'timestamp' => $time,
                'signature' => $signature,
            ]);
        }  catch (\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            }
        }

        $data = json_decode(strval($response->getBody()), true);
        return $data;
    }

    /**
     * Throw exception if token is invalid.
     *
     * @param $result
     * @throws \Exception
     */
    public function checkTokenResponse($result)
    {
        if (isset($result['code']) && $result['code'] != '00000') {
            throw new \Exception($result['message']);
        }
    }

}