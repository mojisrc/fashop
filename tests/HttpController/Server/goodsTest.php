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
use FaShopTest\framework\Config;
use GuzzleHttp\Client;
class goodsTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;


    /**
     * 商品列表
     * @param string title 商品名称
     * @param array category_ids 分类id 数组格式
     * @param int order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早
     * @param string price 价格区间
     * @param int page 页数，默认为 1
     * @param int rows 条数，默认为 8
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "server/goods/list", [
            'query' => [
                'title' => '商品名称',
                'category_ids' => [1,2,3,4],
                'order_type' => 1,
                'price' => '100-1000',
                'page' => 1,
                'page' => 10,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);


        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品详情
     * @param int id 商品id
     * @method GET
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'GET', "server/goods/info", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);



        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品评价列表
     * @param int id 	商品id
     * @param string type 默认为全部评价，好评positive 、中评 moderate、差评negative
     * @param int has_image 1 带图
     * @method GET
     * @param
     */
    public function testEvaluateList()
    {
        $response = self::$client->request( 'GET', "server/goods/evaluateList", [
            'query' => [
                'goods_ids' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 浏览过的商品记录
     * @method GET
     * @param
     */
    public function testVisitedRecord()
    {
        $response = self::$client->request( 'GET', "server/goods/visitedRecord", [
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }





}