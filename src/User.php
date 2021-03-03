<?php
namespace Luke\Cc;

/**
 * 用户模块
 */
class User extends Api
{
    /**
     * 注册用户
     * @param string $mobile
     * @param string $code
     * @param string $rmobile
     * @param string $password
     * @param string $platform
     * @return array
     */
    public function regist($mobile, $code, $rmobile = '', $password = '', $platform = '')
    {
        $options = [
            'form_params'  => [
                'sourcePlatform'=> $platform,
                'phone'         => $mobile,
                'code'          => $code,
                'pphone'        => $rmobile,
                'password'      => $password
            ]
        ];
        return $this->request('POST', '/user/register', $options);
    }
    
    /**
     * 获取用户信息
     * @param string $accessToken
     * @param string $mobile
     * @return array
     */
    public function getInfo($accessToken, $mobile = '')
    {
        $options = empty($mobile) ? ['headers' => ['Authorization' => $accessToken]] : ['form_params' => ['phone' => $mobile]];
        return $this->request('POST', '/user/getinfo', $options);
    }
    
    /**
     * 忘记密码(验证手机验证码)
     * @param string $mobile
     * @param string $code
     * @param string $password
     * @return array
     */
    public function forgetPassword($mobile, $code, $password)
    {
        $options = [
            'form_params'  => [
                'phone'         => $mobile,
                'code'          => $code,
                'password'      => $password
            ]
        ];
        return $this->request('POST', '/user/resetByCode', $options);
    }
    
    /**
     * 提交身份证图片
     * @param string $accessToken
     * @param string $front
     * @param string $back
     * @return array
     */
    public function uploadID($accessToken, $front, $back)
    {
        $options = [
            'headers'       => ['Authorization' => $accessToken],
            'form_params'   => [
                'base641'       => $front,
                'base642'       => $back
            ]
        ];
        return $this->request('POST', '/user/ident2', $options);
    }
    
    /**
     * 提交表单请求
     * @param array $data
     * @param string $accessToken
     * @return array
     */
    public function requestByForm($url, $data, $accessToken = null)
    {
        $options = [
            'headers'       => $accessToken ? ['Authorization' => $accessToken] : [],
            'form_params'   => $data
        ];
        return $this->request('POST', $url, $options);
    }
    
    /**
     * 提交查询请求
     * @param array $data
     * @param string $accessToken
     * @return array
     */
    public function requestByQuery($url, $data, $accessToken = null)
    {
        $options = [
            'headers'       => $accessToken ? ['Authorization' => $accessToken] : [],
            'query'         => $data
        ];
        return $this->request('GET', $url, $options);
    }
    
}