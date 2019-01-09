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

class OrderTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;
    /**
     * 订单列表
     * @method GET
     * @param
     */
    public function testlist()
    {
        $response = self::$client->request( 'GET', "admin/order/list", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 订单详情
     * @param int id 订单id
     * @method GET
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'GET', "admin/order/info", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 拼团订单团信息
     * @param int id 订单id
     * @method GET
     * @param
     */
    public function testGroupInfo()
    {
        $response = self::$client->request( 'GET', "admin/order/groupInfo", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 设置发货
     * @param int id 订单id
     * @param string deliver_name 发货人名称
     * @param string deliver_phone 发货人电话
     * @param string deliver_address 发货人详细地址
     * @param int express_id 物流公司id，默认为0 代表不需要物流
     * @param string shipping_code 物流单号
     * @param string remark 备注信息
     * @method POST
     * @param
     */
    public function testSetSend()
    {
        $response = self::$client->request( 'POST', "admin/order/setSend", [
            'form_params' => [
                'id' => 1,
                'deliver_name' => '发货-测试人员',
                'deliver_phone' => '13800138000',
                'deliver_address' => 1,
                'express_id' => 0,
                'shipping_code' => '',
                'remark' => '',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }
    /**
     * 物流查询
     * @param int express_id 物流公司ID
     * @param string tracking_no 物流单号
     * @method GET
     * @param
     */
    public function testLogisticsQuery()
    {
        $response = self::$client->request( 'GET', "admin/order/logisticsQuery", [
            'query' => [
                'express_id' => 1,
                'tracking_no' => '123456789',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 修改订单价格
     * @param array revise_freight_fee 订单商品 数组 格式 [['id'=>1,'difference_price'=>8], ['id'=>1,'difference_price'=>-8].......] id 为 order_goods表id，difference_price为差价 可正可负
     * @param float revise_goods 修改过的实际支付的运费 必须大于等于0
     * @method GET
     * @param
     */
    public function testChangePrice()
    {
        $response = self::$client->request( 'POST', "admin/order/changePrice", [
            'form_params' => [
                'revise_goods' => [
                    [
                        'id' => 2,
                        'difference_price' => 8,
                    ],
                    [
                        'id' => 1,
                        'difference_price' => -8,
                    ],
                ],
                'revise_freight_fee' => 0,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }
}