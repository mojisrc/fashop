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

class GoodsspecvalueTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;


    /**
     * 商品规格值列表
     * @param int id 	规格id
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "admin/Goodsspecvalue/list", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 添加商品规格值
     * @param int spec_id 	规格id
     * @param int name 	规格值名称
     * @method POST
     * @param
     */
    public function testAdd()
    {
        $response = self::$client->request( 'POST', "admin/Goodsspecvalue/add", [
            'form_params' => [
                'spec_id' => 2,
                'name' => '规格值名称',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 删除商品规格值
     * @param int id 规格值id
     * @method POST
     * @param
     */
    public function testDel()
    {
        $response = self::$client->request( 'POST', "admin/Goodsspecvalue/del", [
            'query' => [
                'id' => 2,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


}