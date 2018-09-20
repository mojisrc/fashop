<?php

namespace App\Validate;

use ezswoole\Validate;


/**
 * 商品管理验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Goods extends Validate
{
	//验证
	protected $rule
		= [
			'id'                  => 'require',
			'title'               => 'require',
			'images'              => 'require|checkImages',
			'category_ids'        => 'require|checkIds',
			'base_sale_num'       => 'require',
			'freight_id' => 'require',
			'send_area_id'        => 'require',
			'body'                => 'require',
			'is_on_sale'          => 'require|between:0,1',
			'sku'                 => 'require|checkSku',
			'ids'                 => 'require|checkIds',
			'states'              => 'require|checkStates',
			'goods_sku_id'        => 'require',
		];
	//提示
	protected $message
		= [
			'id.require'                  => '商品id必填',
			'title.require'               => '商品标题必填',
			'images.require'              => '商品图片必填',
			'category_ids.require'        => '商品分类id集合必填',
			'base_sale_num.require'       => '基础销量必填',
			'freight_id.require' => '运费模板id必填',
			'send_area_id.require'        => '可配送区域策略id必填',
			'body.require'                => '商品详情必填',
			'is_on_sale.require'          => '是否需上架出售必填',
			'is_on_sale.between'          => '是否需上架出售必须是0-1',
			'sku.require'                 => 'sku商品集合必填',
			'ids.require'                 => '商品id集合必填',
			'states.require'              => '状态集合必填',
			'goods_sku_id.require'        => '商品SKU ID必填',
		];
	//场景
	protected $scene
		= [
			'add'  => [
				'title',
				'images',
				'category_ids',
				'base_sale_num',
				'freight_id',
				'send_area_id',
				'body',
				'is_on_sale',
				'sku',
			],
			'edit' => [
				'id',
				'title',
				'images',
				'category_ids',
				'base_sale_num',
				'freight_id',
				'send_area_id',
				'body',
				'is_on_sale',
				'sku',
			],
			'info' => [
				'id',
			],
			'del'  => [
				'ids',
			],
			'set'  => [
				'states',
			],
			'sku'  => [
				'goods_sku_id',
			],
		];

	/**
	 * 检测商品封面图片
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @datetime 2017/12/26 0026 上午 10:59
	 * @author   沈旭
	 */
	protected function checkImages( $value, $rule, $data )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return '商品封面图片错误';
		}
		return true;
	}

	/**
	 * 检测id集合
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @datetime 2017/12/26 0026 上午 11:10
	 * @author   沈旭
	 */
	protected function checkIds( $value, $rule, $data )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return 'id集合错误';
		}
		return true;
	}

	/**
	 * 检测sku商品集合
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @datetime 2017/12/26 0026 上午 11:14
	 * @author   沈旭
	 */
	protected function checkSku( $value, $rule, $data )
	{
		if( empty( $value ) || !is_array( $value ) ){
			return 'sku商品集合错误';
		}
		return true;
	}

	/**
	 * 检测状态集合
	 * @param $value
	 * @param $rule
	 * @param $data
	 * @datetime 2017/12/26 0026 上午 11:15
	 * @author   沈旭
	 */
	protected function checkStates( $value, $rule, $data )
	{
		if( empty( $value ) || !is_array( $value ) || count( $value ) < 1 ){
			return '状态集合错误';
		}
		foreach( $value as $info ){
			if( !isset( $info['id'] ) ){
				return '错误：商品id必填';
			}
			if( !isset( $info['is_on_sale'] ) ){
				return '错误：商品是否上架出售必填';
			}
			if( !Validate::in( $info['is_on_sale'], [0, 1] ) ){
				return '错误：商品是否上架出售必须是0-1';
			}
		}
		return true;
	}

}