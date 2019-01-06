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

class GoodsevaluateTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;


    /**
     * 评价列表
     * @param string keywords_type 	关键词类型：商品名称 goods_name 、用户昵称 user_nicknname 、用户手机号 user_phone
     * @param string keywords 	关键词
     * @param array create_time 	时间区间[开始时间戳,结束时间戳]
     * @param string type 	默认为全部评价，好评positive 、中评 moderate、差评negative
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "admin/goodsevaluate/list", [
            'query' => [
                'keywords_type' => 'goods_name',
                'keywords' => '关键词',
                'create_time' => [
                    1546358400,
                    1546358400,
                ],
                'type' => 'negative',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 评价回复
     * @param int id 	评价id
     * @param int reply_content 	回复内容
     * @method POST
     * @param
     */
    public function testReply()
    {
        $response = self::$client->request( 'POST', "admin/Goodsspecvalue/reply", [
            'form_params' => [
                'id' => 2,
                'reply_content' => '回复内容',
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 评价显示状态
     * @param int id 评价id
     * @method POST
     * @param
     */
    public function testDisplay()
    {
        $response = self::$client->request( 'POST', "admin/Goodsspecvalue/display", [
            'query' => [
                'id' => 2,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }














}