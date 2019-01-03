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

class GoodsTest extends BaseTestCase
{
    private static $addMemberData;
    private static $addUserId;
    private static $newPassword = '1234567';
    private static $loginAccessToken;
    private static $loginAccessTokenExpireIn;
    /**
     * 后台用户
     * @param int sale_state 物流公司ID
     * @param string title 物流公司ID
     * @param array category_ids 物流公司ID
     * @param int order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早 9排序高到低 10排序低到高
     * @method GET
     * @param
     */
    public function testlist()
    {
        $response = self::$client->request( 'GET', "admin/goods/list", [
            'query' => [
                'sale_state' => 1,
                'title' => '',
                'category_ids' => [1,2,3,4],
                'order_type' => 1,
            ]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, 1, $response->getBody());
    }







}