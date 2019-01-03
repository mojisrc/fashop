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









}