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

class SettingTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;


    /**
     * 基础信息设置
     * @param string key 	类型，wechat微信，唯一不可修改
     * @param string name 	用途名字
     * @param array config 	配置详情
     * @param string status 	是否开启，1 开启 0 关闭
     * @param string remark 	备注
     * @method POST
     * @param
     */
    public function testEdit()
    {
        $response = self::$client->request( 'POST', "admin/setting/edit", [
            'form_params' => [
                'key' => 'wechat',
                'name' => '用途名字',
                'config' => '配置详情',
                'status' => 1,
                'remark' => '备注',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 配置添加
     * @param string key 	类型，wechat微信，唯一不可修改
     * @param string name 	用途名字
     * @param array config 	配置详情
     * @param string status 	是否开启，1 开启 0 关闭
     * @param string remark 	备注
     * @method POST
     * @param
     */
    public function testAdd()
    {
        $response = self::$client->request( 'POST', "admin/setting/add", [
            'form_params' => [
                'key' => 'wechat',
                'name' => '用途名字',
                'config' => '配置详情',
                'status' => 1,
                'remark' => '备注',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }












}