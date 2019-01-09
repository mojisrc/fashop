<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/7
 * Time: 下午2:35
 *
 */

namespace FaShopTest\HttpController\Admin;

use FaShopTest\BaseTestCase;

class ClientuserTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;

    /**
     * 登陆
     * @param string login_type 登陆方式 password密码登陆 wechat_openid微信登陆
     * @param string username 手机号，登陆方式为password 必填
     * @param string password 密码，登陆方式为password 必填
     * @param string wechat_openid 微信openid ，登陆方式为wechat_openid 必填
     * @param array wechat_mini_param 数组，必须包含code，encryptedData，iv
     * @method POST
     * @param
     */
    public function testLogin()
    {
        $response = self::$client->request( 'POST', "admin/user/login", [
            'form_params' => [
                'login_type' => 'password',
                'username' => 'admin',
                'password' => '123456',
            ],
            'headers' => ['access-token' => self::$accessToken]
//            'form_params' => [
//                'login_type' => 'wechat_openid',
//                'wechat_openid' => '123456789',
//            ]

        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 注册
     * @param string register_type 登陆方式 password密码登陆 wechat_openid微信登陆
     * @param array username 手机号，登陆方式为password 必填
     * @param int password 密码，登陆方式为password 必填
     * @param string channel_type 微信openid ，登陆方式为wechat_openid 必填
     * @param int verify_code 数组，必须包含code，encryptedData，iv
     * @param int wechat_openid 数组，必须包含code，encryptedData，iv
     * @param int wechat 数组，必须包含code，encryptedData，iv
     * @param int wechat_mini_param 数组，必须包含code，encryptedData，iv
     * @method POST
     * @param
     */
    public function testRegister()
    {
        $response = self::$client->request( 'POST', "admin/user/register", [
            'form_params' => [
                'login_type' => 'password',
                'username' => 'admin',
                'password' => '123456',
                'verify_code' => '1234',
                'channel_type' => 'email',
            ],
            'headers' => ['access-token' => self::$accessToken]

//            'form_params' => [
//                'login_type' => 'wechat_openid',
//                'wechat_openid' => '123456789',
//            ]


        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 退出
     * @method GET
     * @param
     */
    public function testLoginout()
    {
        $response = self::$client->request( 'GET', "admin/user/logout", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 修改密码
     * @param string oldpassword 老密码
     * @param string password 新密码
     * @method POST
     * @param
     */
    public function testEditPassword()
    {
        $response = self::$client->request( 'POST', "admin/user/editPassword", [
            'form_params' => [
                'oldpassword' => '654321',
                'password' => '123456',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 找回密码
     * @param string phone 老密码
     * @param string password 新密码
     * @param string verify_code 老密码
     * @method POST
     * @param
     */
    public function testEditPasswordByFind()
    {
        $response = self::$client->request( 'POST', "admin/user/editPasswordByFind", [
            'form_params' => [
                'phone' => '18526459531',
                'password' => '123456',
                'verify_code' => '1234',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 发送验证码
     * @param string behavior 行为标识，register 注册 findPassword 找回密码 editPassword 修改密码 bindPhone 绑定手
     * @param string channel_type 固定 传sms
     * @param string phone 手机号
     * @method POST
     * @param
     */
    public function testVerifycodeAdd()
    {
        $response = self::$client->request( 'POST', "admin/Verifycode/add", [
            'form_params' => [
                'behavior' => 'register',
                'channel_type' => 'sms',
                'phone' => '18526459531',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 用户信息
     * @method GET
     * @param
     */
    public function testSelf()
    {
        $response = self::$client->request( 'GET', "admin/user/self", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 修改资料
     * @param int province_id 省份id
     * @param int city_id 城市id
     * @param int area_id 区域id
     * @param string nickname 昵称
     * @param int sex 性别 1男 0 女
     * @param string avatar 头像地址
     * @param int birthday 生日时间戳
     * @method POST
     * @param
     */
    public function testEditProfile()
    {
        $response = self::$client->request( 'POST', "admin/user/editProfile", [
            'form_params' => [
                'province_id' => 1,
                'city_id' => 1,
                'area_id' => 1,
                'nickname' => 'xiaodeng',
                'sex' => 1,
                'avatar' => 'https://www.xxx.com/images/1.png',
                'birthday' => '1234567890',

            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 刷新token
     * @method POST
     * @param
     */
    public function testToken()
    {
        $response = self::$client->request( 'POST', "admin/user/token", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 绑定手机号
     * @param string phone 手机号
     * @param string password 密码
     * @param string verify_code 验证码
     * @method POST
     * @param
     */
    public function testBindPhone()
    {
        $response = self::$client->request( 'POST', "admin/user/bindPhone", [
            'form_params' => [
                'phone' => '18526459531',
                'password' => '123456',
                'verify_code' => '1234',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 绑定微信
     * @param string phone 手机号
     * @param string password 密码
     * @param string verify_code 验证码
     * @method POST
     * @param
     */
    public function testBindWechat()
    {
        $response = self::$client->request( 'POST', "admin/user/BindWechat", [
            'form_params' => [
                'wechat_openid' => '123456789',
                'wechat' => [
                    'openid' => 'openid',
                    'nickname' => 'nickname',
                    'sex' => 1,
                    'province' => 'PROVINCE',
                    'city' => 'city',
                    'country' => 'country',
                    'headimgurl' => 'http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46',
                ],
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 手机解绑微信
     * @method POST
     * @param
     */
    public function testUnbindWechat()
    {
        $response = self::$client->request( 'POST', "admin/user/unbindWechat", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 微信解绑手机
     * @method POST
     * @param
     */
    public function testUnbindPhone()
    {
        $response = self::$client->request( 'POST', "admin/user/unbindPhone", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }







}