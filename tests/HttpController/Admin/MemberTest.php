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

class ClientgoodsTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;

    /**
     * 成员列表
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "admin/member/list", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }

    /**
     * 成员添加
     * @param string username 	账号
     * @param string password 	密码
     * @param string nickname 	昵称
     * @method POST
     * @param
     */
    public function testAdd()
    {
        $response = self::$client->request( 'POST', "admin/member/add", [
            'form_params' => [
                'username' => 'dengkai',
                'password' => '123456',
                'nickname' => 'dengkai',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 成员详情
     * @param int id 	成员id
     * @method GET
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'GET', "admin/member/info", [
            'query' => [
                'id' => 1,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 成员修改
     * @param int id 	成员id
     * @param string avatar 	头像，url
     * @param string nickname 	昵称
     * @param string password 	密码，当存在时判断
     * @method POST
     * @param
     */
    public function testEdit()
    {
        $response = self::$client->request( 'POST', "admin/member/edit", [
            'form_params' => [
                'id' => 11,
                'avatar' => 'https://www.xxx.com/1.png',
                'nickname' => 'dengkai',
                'password' => '123456',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 成员删除
     * @param int id 	成员id
     * @method POST
     * @param
     */
    public function testDel()
    {
        $response = self::$client->request( 'POST', "admin/member/del", [
            'form_params' => [
                'id' => 11,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 成员修改自己的密码
     * @param int oldpassword 	老密码，6-32位
     * @param int password 	成员id
     * @method POST
     * @param
     */
    public function testSelfPassword()
    {
        $response = self::$client->request( 'POST', "admin/member/selfPassword", [
            'form_params' => [
                'oldpassword' => '123456',
                'password' => '654321',

            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 修改当前用户的信息
     * @param string avatar 	老密码，6-32位
     * @param string nickname 	成员id
     * @method POST
     * @param
     */
    public function testSelfEdit()
    {
        $response = self::$client->request( 'POST', "admin/member/selfEdit", [
            'form_params' => [
                'avatar' => 'https://www.xxx.com/1.png',
                'nickname' => 'dengkai',

            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 登陆
     * @param string username 	用户名
     * @param string password 	密码
     * @param string verify_code 	验证码
     * @method POST
     * @param
     */
    public function testLogin()
    {
        $response = self::$client->request( 'POST', "admin/member/login", [
            'form_params' => [
                'username' => 'dengkai',
                'password' => '123456',
                'verify_code' => '1234',

            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 验证码获得
     * @method GET
     * @param
     */
    public function testVerifyCode()
    {
        $response = self::$client->request( 'GET', "admin/member/verifyCode", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 刷新Token
     * @method POST
     * @param
     */
    public function testToken()
    {
        $response = self::$client->request( 'POST', "admin/member/token", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }




    /**
     * 当前用户信息
     * @method GET
     * @param
     */
    public function testSelf()
    {
        $response = self::$client->request( 'GET', "admin/member/self", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 退出
     * @method POST
     * @param
     */
    public function testLogout()
    {
        $response = self::$client->request( 'POST', "admin/member/logout", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 登陆信息
     * @method GET
     * @param
     */
    public function testLoginInfo()
    {
        $response = self::$client->request( 'GET', "admin/member/loginInfo", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }








}