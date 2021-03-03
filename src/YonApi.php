<?php

namespace Luke\Cc;

use Hanson\Foundation\AbstractAPI;

class YonApi extends AbstractAPI
{
    // 接口参数
    protected $app;
    protected $baseUrl;
    protected $appId;
    protected $secret;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->baseUrl = $this->app->getConfig('yon')['baseUrl'];
    }

    /**
     * 接口请求
     * @param string $method
     * @param string $url
     * @param array $options
     * @return array
     */
    public function request($method, $url, $options = [])
    {
        $result = [
            'code' => -1,
            'message' => '连接失败',
            'time' => time(),
            'data' => []
        ];
        $options['query']['access_token'] = $this->app['yon.accessToken']->getToken();
        $response = null;
        try {
            $response = $this->getHttp()->request($method, $this->baseUrl . $url, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $result['message'] = $e->getMessage();
        }
        if ($response) {
            $statusCode = $response->getStatusCode();
            $result = \json_decode($response->getBody(), true);
        }

        return $result;
    }

}