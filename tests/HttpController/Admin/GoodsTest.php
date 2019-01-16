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
     * 商品列表
     * @param int sale_state 售卖状态 1出售中 2已售完 3已下架
     * @param string title 商品名称
     * @param array category_ids 分类id 数组格式
     * @param int order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早 9排序高到低 10排序低到高
     * @method GET
     * @param
     */
    public function testList()
    {
        $response = self::$client->request( 'GET', "admin/goods/list", [
            'query' => [
                'sale_state' => 1,
                'title' => '',
                'category_ids' => [1,2,3,4],
                'order_type' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 商品信息
     * @param int id 商品id
     * @method GET
     * @param
     */
    public function testInfo()
    {
        $response = self::$client->request( 'GET', "admin/goods/info", [
            'query' => [
                'id' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }


    /**
     * 添加商品
     * @param string title 商品标题
     * @param array images 商品图片，数组，默认第一个为封面图片
     * @param array category_ids 商品分类id集合，数组
     * @param int base_sale_num 基础销量，为空请输入0
     * @param int freight_id 运费模板id
     * @param int freight_fee 统一运费，默认为0
     * @param int sale_time 开售时间，立即开始传当前时间
     * @param text body 商品详情，json
     * @param int is_on_sale 是否需上架出售 0 否 1 是
     * @param int image_spec_id 使用图片的规格id
     * @param array skus.spec sku规格
     * @param int skus.spec.id sku规格id
     * @param string skus.spec.name sku规格值id
     * @param string skus.spec.value_id sku规格名
     * @param string skus.spec.value_name sku规格值名
     * @param string skus.spec.value_image sku规格图片
     * @param float skus.price sku价格
     * @param int skus.stock sku库存
     * @param string skus.code sku商家编号
     * @param string skus.img sku图片
     * @param float skus.weight sku重量(kg)
     *
     * @method POST
     * @param
     */
    public function testAdd()
    {
        $response = self::$client->request( 'POST', "admin/goods/add", [
            'form_params' => [
                'title' => 1,
                'images' => 1,
                'category_ids' => 1,
                'base_sale_num' => 1,
                'freight_id' => 1,
                'freight_fee' => 1,
                'sale_time' => 1,
                'body' => 1,
                'is_on_sale' => 1,
                'image_spec_id' => 1,
                'skus' => [
                    'spec' => [
                        'id' => 20509,
                        'name' => '尺码',
                        'value_id' => 28313,
                        'value_name' => 'XS',
                    ],
                    'price' => 23,
                    'stock' => 23,
                    'code' => "商品编号",
                    'weight' => 0,
                ],

            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 修改商品
     * @param int id 商品id
     * @param string title 商品标题
     * @param array images 商品图片，数组，默认第一个为封面图片
     * @param array category_ids 商品分类id集合，数组
     * @param int base_sale_num 基础销量，为空请输入0
     * @param int freight_id 运费模板id
     * @param int freight_fee 统一运费，默认为0
     * @param int sale_time 开售时间，立即开始传当前时间
     * @param text body 商品详情，json
     * @param int is_on_sale 是否需上架出售 0 否 1 是
     * @param int image_spec_id 使用图片的规格id
     * @param array skus.spec sku规格
     * @param int skus.spec.id sku规格id
     * @param string skus.spec.name sku规格值id
     * @param string skus.spec.value_id sku规格名
     * @param string skus.spec.value_name sku规格值名
     * @param string skus.spec.value_image sku规格图片
     * @param float skus.price sku价格
     * @param int skus.stock sku库存
     * @param string skus.code sku商家编号
     * @param string skus.img sku图片
     * @param float skus.weight sku重量(kg)
     * @method POST
     * @param
     */
    public function testEdit()
    {
        $response = self::$client->request( 'POST', "admin/goods/edit", [
            'form_params' => [
                'id' => 1,
                'title' => 1,
                'images' => 1,
                'category_ids' => 1,
                'base_sale_num' => 1,
                'freight_id' => 1,
                'freight_fee' => 1,
                'sale_time' => 1,
                'body' => 1,
                'is_on_sale' => 1,
                'image_spec_id' => 1,
                'skus' => [
                    'spec' => [
                        'id' => 20509,
                        'name' => '尺码',
                        'value_id' => 28313,
                        'value_name' => 'XS',
                    ],
                    'price' => 23,
                    'stock' => 23,
                    'code' => "商品编号",
                    'weight' => 0,
                ],
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 商品删除
     * @param array goods_ids 商品id集合 数组形式
     * @method POST
     * @param
     */
    public function testDel()
    {
        $response = self::$client->request( 'POST', "admin/goods/del", [
            'query' => [
                'goods_ids' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 商品下架
     * @param array goods_ids 商品id集合 数组形式
     * @method POST
     * @param
     */
    public function testOffSale()
    {
        $response = self::$client->request( 'POST', "admin/goods/offSale", [
            'query' => [
                'goods_ids' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }



    /**
     * 商品上架
     * @param array goods_ids 商品id集合 数组形式
     * @method POST
     * @param
     */
    public function testOnSale()
    {
        $response = self::$client->request( 'POST', "admin/goods/onSale", [
            'query' => [
                'goods_ids' => 1,
            ],
            'headers' => ['access-token' => self::$accessToken]
        ]);
        $return_data = json_decode($response->getBody(), true);
        $this->assertEquals( self::$code::success, $return_data['code'], $response->getBody());
    }







}