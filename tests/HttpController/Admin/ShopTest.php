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

class ShopTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;


    /**
     * 基础信息设置
     * @param string name 	店铺名称
     * @param string logo 	店铺标志图片
     * @param array contact_number 	店铺联系电话
     * @param string description 	店铺描述
     * @param string host 	店铺访问地址
     * @method POST
     * @param
     */
    public function testSetBaseInfo()
    {
        $response = self::$client->request( 'POST', "admin/shop/setBaseInfo", [
            'form_params' => [
                'name' => 'goods_name',
                'logo' => '关键词',
                'contact_number' => '18526459531',
                'description' => 'negative',
                'host' => '',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 配色方案设置
     * @param int color_scheme 	默认为0
     * @method POST
     * @param
     */
    public function testSetColorScheme()
    {
        $response = self::$client->request( 'POST', "admin/shop/setColorScheme", [
            'form_params' => [
                'color_scheme' => 1,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 资料
     * @method GET
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'GET', "admin/shop/info", []);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 分类页风格设置
     * @param int goods_category_style 	店铺分类页风格，临时写法，V1版本后会拓展到模板里 0 1 2
     * @method POST
     * @param
     */
    public function testSetGoodsCategoryStyle()
    {
        $response = self::$client->request( 'POST', "admin/shop/setGoodsCategoryStyle", [
            'form_params' => [
                'goods_category_style' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 设置订单相关过期时间
     * @param int order_auto_close_expires 	待付款订单N秒后自动关闭订单，默认604800秒
     * * @param int order_auto_confirm_expires 	已发货订单后自动确认收货，默认604800秒
     * * @param int order_auto_close_refound_expires 	已收货订单后关闭退款／退货功能，0代表确认收货后无
     * @method POST
     * @param
     */
    public function testSetOrderExpires()
    {
        $response = self::$client->request( 'POST', "admin/shop/setOrderExpires", [
            'form_params' => [
                'order_auto_close_expires' => 1,
                'order_auto_confirm_expires' => 1,
                'order_auto_close_refound_expires' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }














}