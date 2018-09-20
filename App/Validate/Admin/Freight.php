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

class Freight extends Validate
{
	protected $rule
		= [
			'id'       => 'require',
			'name'     => 'require',
			'pay_type' => 'require|checkPayType',
			'areas'    => 'require|array|checkAreas',
		];
	protected $message
		= [
			'id.require'       => 'ID必填',
			'name.require'     => '模板名称必填',
			'pay_type.require' => '计算方式必填',
			'areas.require'    => '模板运费必填',
		];
	protected $scene
		= [
			'add'  => [
				'name',
				'pay_type',
				'areas',
			],
			'edit' => [
				'id',
				'name',
				'areas',
			],
			'del'  => [
				'id',
			],
		];

	/**
	 * 检测计算方式
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @author   韩文博
	 */
	protected function checkPayType( $value, $rule, $data )
	{
		if( !$this->in( $value, [1, 2] ) ){
			return '计算方式错误';
		};
		return true;
	}

	/**
	 * 检测模板运费
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @author   韩文博
	 */
	protected function checkAreas( $value, $rule, $data )
	{
		if( empty( $value ) || !is_array( $value ) ){
			return '模板运费录入错误';
		}
		$area_ids = [];
		foreach( $value as $area ){
			if( empty( $area['area_ids'] ) || !is_array( $area['area_ids'] ) ){
				return "地区必选";
			}
			$_area_id = 0;
			foreach( $area['area_ids'] as $area_id ){
				if( $_area_id > $area_id ){
					return "地区排序错误";
				}
				$_area_id = $area_id;
			}
			$area_ids = array_merge( $area_ids, $area['area_ids'] );
			if( !isset( $area['first_amount'] ) ){
				return '首件数量必填';
			}
			if( !isset( $area['first_fee'] ) ){
				return '首件金额必填';
			}
			if( !isset( $area['additional_amount'] ) ){
				return '续件数量必填';
			}
			if( !isset( $area['additional_fee'] ) ){
				return '续件金额必填';
			}

			if( (int)$area['first_amount'] < 1 ){
				return '首件数量不能小于1';
			}
			if( (float)($area['first_fee']) < 0 ){
				return '首件金额不能小于0';
			}
			if( (int)($area['additional_amount']) < 1 ){
				return '续件数量数不能小于1';
			}
			if( (float)($area['additional_fee']) < 0 ){
				return '续件增加金额不能小于0';
			}

		}
		if( $this->arrayUnique( $area_ids ) !== true ){
			return "地区有重复";
		}

		$_area_ids = \ezswoole\Db::name( 'Area' )->where( ['id' => ['in', $area_ids]] )->column( 'id' );
		if( empty( $_area_ids ) || count( $_area_ids ) !== count( $area_ids ) ){
			return "有地区不存在";
		}
		// todo 地区全包含非全包关系

		return true;
	}

}