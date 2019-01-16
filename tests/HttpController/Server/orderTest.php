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

namespace FaShopTest\HttpController\Server;

use FaShopTest\BaseTestCase;

class orderTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;

    /**
     * 订单状态量
     * @param array create_time [开始时间,结束时间]
     * @param string feedback_state 维权状态：退款处理中 todo、退款结束 closed
     * @param array user_ids 用户id数组 个人觉得这个参数没用
     * @param int is_print 1打印 0未打印
     * @param string keywords_type 商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 快递单号courier_number
     * @param string keywords 关键词
     * @param int state_types 状态集合，不需要的可以不填，减少浪费
     * @method GET
     * @param
     */
    public function testStateNum()
    {
        $response = self::$client->request( 'GET', "server/order/stateNum", [
            'query' => [
                'create_time' => [
                    1546358400,
                    1546358400,
                ],
                'feedback_state' => '分类名称',
                'user_ids' => [
                    1,
                    2,
                    3,
                ],
                'is_print' => 1,
                'keywords_type' => 'goods_name',
                'keywords' => '关键词',
                'state_types' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 订单列表
     * @param array create_time [开始时间,结束时间]
     * @param string feedback_state 维权状态：退款处理中 todo、退款结束 closed
     * @param array state_type 未付款'state_new', 已付款'state_pay', 已发货'state_send', 已完成'state_success', 已取消'state_cancel' 退款'state_refund' 为评价'state_unevaluate'
     * @param int is_print 1打印 0未打印
     * @param string keywords_type 商品名称goods_name 、订单号order_no、收货人姓名 receiver_name、收货人电话 receiver_phone、 快递单号courier_number
     * @param string keywords 关键词
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "server/order/list", [
            'query' => [
                'create_time' => [
                    1546358400,
                    1546358400,
                ],
                'feedback_state' => '分类名称',
                'is_print' => 1,
                'keywords_type' => 'goods_name',
                'keywords' => '关键词',
                'state_types' => 'state_new',
            ],
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
        $response = self::$client->request( 'GET', "server/order/info", [
            'query' => [
                'id' => 1
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 取消未付款订单
     * @param int id 订单id
     * @param string state_remark 状态备注，如：取消原因（改买其他商品、改配送方式、其他原因等等）
     * @method POST
     * @param
     */
    public function testCancel()
    {
        $response = self::$client->request( 'POST', "server/order/cancel", [
            'query' => [
                'id' => 1,
                'state_remark' => '状态备注，如：取消原因（改买其他商品、改配送方式、其他原因等等）',
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 确认收货
     * @param int id 订单id
     * @method POST
     * @param
     */
    public function testConfirmReceipt()
    {
        $response = self::$client->request( 'POST', "server/order/confirmReceipt", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }






    /**
     * 订单商品详情
     * @param int id 订单id
     * @method GET
     * @param
     */
    public function testGoodsInfo()
    {
        $response = self::$client->request( 'GET', "server/order/goodsInfo", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 订单商品列表
     * @param int id 订单id
     * @method GET
     * @param
     */
    public function testGoodsList()
    {
        $response = self::$client->request( 'GET', "server/order/goodsList", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 查看物流
     * @param int id 订单id
     * @method GET
     * @param
     */
    public function testLogistics()
    {
        $response = self::$client->request( 'GET', "server/order/logistics", [
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
        $response = self::$client->request( 'GET', "server/order/groupInfo", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }








}