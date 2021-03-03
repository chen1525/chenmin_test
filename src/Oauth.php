<?php
namespace Luke\Cc;

/**
 * 开放认证模块
 */
class Oauth extends Api
{
    /**
     * 获取用户token(密码模式)
     * @param string $username
     * @param string $password
     * @return array
     */
    public function getTokenByPassword($username, $password)
    {
        $options = [
            'form_params'  => [
                'grantType'     => 'pwd',
                'phone'         => $username,
                'password'      => $password
            ]
        ];
        return $this->request('POST', '/auth/token', $options);
    }
    
    /**
     * 获取用户token(手机验证码模式)
     * @param string $mobile
     * @param string $code
     * @return array
     */
    public function getTokenBySms($mobile, $code)
    {
        $options = [
            'form_params'  => [
                'grantType'     => 'sms',
                'phone'         => $mobile,
                'code'          => $code
            ]
        ];
        return $this->request('POST', '/auth/token', $options);
    }
    
    /**
     * 获取用户token(手机号模式)
     * @param string $mobile
     * @param string $code
     * @return array
     */
    public function getTokenByMobile($mobile)
    {
        $options = [
            'form_params'  => [
                'grantType'     => 'phone',
                'phone'         => $mobile
            ]
        ];
        return $this->request('POST', '/auth/token', $options);
    }
    
    /**
     * 刷新用户token
     * @param string $mobile
     * @param string $refreshToken
     * @return array
     */
    public function refreshToken($mobile, $refreshToken)
    {
        $options = [
            'form_params'  => [
                'grantType'     => 'refresh_token',
                'phone'         => $mobile,
                'token'         => $refreshToken
            ]
        ];
        return $this->request('POST', '/auth/token', $options);
    }
    
    /**
     * 销毁用户token
     * @param string $accessToken
     * @return array
     */
    public function destroyToken($accessToken)
    {
        $options = [
            'headers'   => [
                'Authorization' => $accessToken
            ]
        ];
        return $this->request('POST', '/user/logout', $options);
    }
    
}