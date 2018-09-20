<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\VerifyCode;

class Discount extends Validate
{
	protected $rule
		= [
			'id'      	 => 'require',
			'title'      => 'require',
			'start_time' => 'require|checkTime',
			'end_time'   => 'require|checkTime',
			'goods_ids'  => 'require|checkGoodsIds',
			'discount_id'=> 'require',
			'goods_id'   => 'require',
			'goods_sku_ids'  => 'require|checkGoodsSkuIds',
			'goods_sku' 	 => 'require|checkGoodsSku',

		];

	protected $message
		= [
			'id.require' 			=> "活动id必须",
			'title.require'     	=> "名称必须",
			'start_time.require'	=> "开始时间必须",
			'end_time.require'     	=> "结束时间必须",
			'goods_ids.require'     => "商品id数组必须",
			'discount_id.require'   => "活动id必须",
			'goods_id.require'   	=> "商品id必须",
			'goods_sku_ids.require' => "商品Sku id数组必须",
			'goods_sku.require'     => "商品Sku数组必须",

		];

	protected $scene
		= [

			'info' => [
				'id',
			],


			'add' => [
				'title',
				'start_time',
				'end_time',
			],

			'edit' => [
				'id',
				'title',
				'start_time',
				'end_time',
			],

			'del' => [
				'id',
			],

			'selectableGoods' => [
				'id',
			],

			'selectedGoods' => [
				'id',
			],

			'choiceGoods' => [
				'id',
				'goods_id',
			],

			'goodsSkuList' => [
				'discount_id',
				'goods_id',
			],

			'editGoodsSku' => [
				'discount_id',
				'goods_id',
				'goods_sku',
			],

		];


	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkGoodsIds( $value, $rule, $data )
	{
		if( isset( $value ) && is_array( $value ) ){
			$result = true;
		} else{
			$result = '参数错误';

		}
		return $result;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkGoodsSkuIds( $value, $rule, $data )
	{
		if( isset( $value ) && is_array( $value ) ){
			$result = true;
		} else{
			$result = '参数错误';

		}
		return $result;
	}

	/**
	 * @access protected
	 * 包涵 discounts XXX折,minus 立减XXX元,price 打折后XXX元
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkGoodsSku( $value, $rule, $data )
	{
		if( isset( $value ) && is_array( $value ) ){

			foreach ($value as $key => $v) {
				if(!isset($v['discounts']) || isset($v['minus']) || isset($v['price'])){
					return '参数错误';
				}

				if(floatval($v['discounts'])<=0 || floatval($v['minus'])<=0 || floatval($v['price'])<=0){
					return '参数错误';
				}
			}

			$result = true;

		} else{
			$result = '参数错误';

		}
		return $result;
	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkTime( $value, $rule, $data )
	{
		$result = true;

	    if (!$value) { //strtotime转换不对，日期格式显然不对。
	        $result = '参数错误';
	    }

	    //小于当前时间则不对
	    if(intval($value) <intval(time())){
	        $result = '参数错误';
	    }
		return $result;
	}



}