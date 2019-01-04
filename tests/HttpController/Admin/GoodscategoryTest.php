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

class GoodscategoryTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;

    /**
     * 添加商品分类
     * @param int pid 父级id，如果不填为一级
     * @param string name 分类名称
     * @param string icon 商品分类图标，图片地址
     * @param int sort 排序数字，越小越靠前，默认为0
     * @method POST
     * @param
     */
    public function testAdd()
    {
        $response = self::$client->request( 'POST', "admin/goodscategory/add", [
            'form_params' => [
                'pid' => 0,
                'name' => '分类名称',
                'icon' => 'https://www.fashop.com/images/1.png',
                'sort' => 999,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 修改商品分类
     * @param int id 商品分类id
     * @param int pid 父级id，如果不填为一级
     * @param string name 分类名称
     * @param string icon 商品分类图标，图片地址
     * @param int sort 排序数字，越小越靠前，默认为0
     * @method POST
     * @param
     */
    public function testEdit()
    {
        $response = self::$client->request( 'POST', "admin/goodscategory/edit", [
            'form_params' => [
                'id' => 1,
                'pid' => 0,
                'name' => '分类名称',
                'icon' => 'https://www.fashop.com/images/1.png',
                'sort' => 999,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品分类列表
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "admin/goodscategory/list", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 删除商品分类
     * @param int id 商品分类id
     * @method POST
     * @param
     */
    public function testDel()
    {
        $response = self::$client->request( 'POST', "admin/goodscategory/del", [
            'query' => [
                'id' => 1,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品分类详情
     * @param int id 商品分类id
     * @method POST
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'POST', "admin/goodscategory/info", [
            'query' => [
                'id' => 1,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品分类详情
     * @param int id 排序id
     * @param int index 排序数
     * @method POST
     * @param
     */
    public function testSort()
    {
        $response = self::$client->request( 'POST', "admin/goodscategory/sort", [
            'query' => [
                'sorts' => [
                    'id' => 1,
                    'index' => 999,
                ],
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }








}