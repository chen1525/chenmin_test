<?php
namespace Luke\Cc;
use Hanson\Foundation\AbstractAPI;

class Api extends AbstractAPI
{
    // 接口参数
    protected $app;
    protected $baseUrl;
    protected $appId;
    protected $secret;
    
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->baseUrl = $this->app->getConfig('base_url');
        $this->appId = $this->app->getConfig('app_id');
        $this->secret = $this->app->getConfig('secret');
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
        $options['headers']['appid'] = $this->appId;
        $options['headers']['appkey'] = $this->secret;
        $result = [
            'code'      => -1,
            'msg'       => '连接失败',
            'time'      => time(),
            'data'      => []
        ];
        $response = null;
        try{
            $response = $this->getHttp()->request($method, $this->baseUrl.$url, $options);
        } catch (\GuzzleHttp\Exception\RequestException $e){
            if ($e->hasResponse()) {
                $response = $e->getResponse();
            }
        }
        if ($response) {
            $statusCode = $response->getStatusCode();
            $result = \json_decode($response->getBody(), true);
        }

        return $result;
    }
    
    
}