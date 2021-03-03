<?php
namespace Luke\Cc;
use Exception;
use Hanson\Foundation\AbstractAccessToken;

class AccessToken extends AbstractAccessToken
{
    private $app;
    protected $baseUrl;
    protected $appId;
    protected $secret;
    protected $tokenJsonKey = 'access_token';
    protected $expiresKey = 'expires_in';
    
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->baseUrl = $this->app->getConfig('base_url');
        $this->appId = $this->app->getConfig('app_id');
        $this->secret = $this->app->getConfig('secret');
    }
    
    public function checkTokenResponse($response)
    {
        if (!empty($response['code'])) {
            throw new Exception($response['message']);
        }
    }
    
}