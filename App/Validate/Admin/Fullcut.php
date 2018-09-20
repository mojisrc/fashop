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

class Fullcut extends Validate
{
	protected $rule
		= [
			'id'      	 => 'require',
			'title'      => 'require',
			'start_time' => 'require|checkTime',
			'end_time'   => 'require|checkTime',
			'hierarchy'  => 'require|checkHierarchy',
			'level'      => 'require|checkLevel',
			'goods_ids'  => 'require|checkGoodsIds',
			'fullcut_id' => 'require',
			'goods_id'   => 'require',
			'goods_sku_ids'  => 'require|checkGoodsSkuIds',
			'goods_sku'      => 'require|checkGoodsSku',

		];

	protected $message
		= [
			'id.require' 			=> "活动id必须",
			'title.require'     	=> "名称必须",
			'start_time.require'	=> "开始时间必须",
			'end_time.require'     	=> "结束时间必须",
			'hierarchy.require'     => "层级必须",
			'level.require'         => "级别必须",
			'goods_ids.require'     => "商品id数组必须",
			'fullcut_id.require'    => "活动id必须",
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
				'hierarchy',
				'level',
			],

			'edit' => [
				'id',
				'title',
				'start_time',
				'end_time',
				'hierarchy',
				'level',
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
				'fullcut_id',
				'goods_id',
			],

			'editGoodsSku' => [
				'fullcut_id',
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
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkGoodsSku( $value, $rule, $data )
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
	 * 至多5个,每个(包涵fll_price满XXX元,minus减XXX元,discountsXXX折,type满减类型 默认0减XXX元  1打XXX折)
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkHierarchy( $value, $rule, $data )
	{
		if( isset( $value ) && is_array( $value ) ){

			if(count($value)>5){
				return '参数错误';

			}

			foreach ($value as $key => $v) {
				if(!isset($v['fll_price']) || isset($v['minus']) || isset($v['discounts']) || isset($v['type'])){
					return '参数错误';
				}

				if(floatval($v['fll_price'])<=0){
					return '参数错误';
				}

				if(in_array($v['type'], array(0,1))){
					switch ($v['type']) {
						case 0:
							if(floatval($v['minus'])<=0 || floatval($v['discounts'])>=0){
								return '参数错误';
							}
							break;
						case 1:
							if(floatval($v['discounts'])<=0 || floatval($v['minus'])>=0){
								return '参数错误';
							}
							break;
					}
				}else{
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
	 * 级别 默认0全店 1商品级
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkLevel( $value, $rule, $data )
	{
		if(in_array($value, array(0,1))){
			$result = true;
		}else{
			return '参数错误';
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