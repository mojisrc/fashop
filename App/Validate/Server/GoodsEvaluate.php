<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/28
 * Time: 下午5:25
 *
 */

namespace App\Validate\Server;
use ezswoole\Validate;
class GoodsEvaluate extends Validate
{
	/**
	 * 对订单商品进行评价
	 * @method POST
	 * @param int order_id 订单id
	 * @param int order_goods_id 订单商品表的id
	 * @param int score 分数
	 * @param array images 评价图片 数组
	 * @param int is_anonymous 是否匿名 1是0否
	 * @param string content 评价内容
	 * @author 韩文博
	 */
	protected $rule
		= [
            'order_goods_id'     => 'require|integer|gt:0',
            'score'              => 'require|integer|between:1,5',
            'additional_content' => 'require',

        ];

	protected $message
		= [];
	protected $scene
		= [
			'add'  => [
				'order_goods_id',
				'score',
			],
            'append'  => [
                'order_goods_id',
                'additional_content',
            ],
		];
}