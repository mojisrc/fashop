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

class Goods extends Validate
{
	protected $rule
		= [
			'id'           => 'require|integer',
			'title'        => 'require',
			'category_ids' => 'require|array',
			'freight_id'   => 'require|integer',
			'images'       => 'require|array',
			'body'         => 'require|array|checkBody',
			'skus'         => 'require|array|checkSkus',
			'ids'          => 'require|array',

		];
	protected $message
		= [
			'id.require'           => "id必须",
			'title.require'        => "商品名称必须",
			'category_ids.require' => "商品分类必须",
			'skus.require'         => "商品型号信息必填",
			'freight_id.require'   => "运费必须",
			'images.require'       => "spec_sign商品图必须",
			'body.require'         => "商品详情必须",
		];
	protected $scene
		= [
			'add'        => [
				'title',
				'category_ids',
				'skus',
				'images',
				'body',
			],
			'edit'       => [
				'id',
				'title',
				'category_ids',
				'skus',
				'images',
				'body',
			],
			'info'       => [
				'id',
			],
			'editDetail' => [
				'id',
			],
			'offSale'    => [
				'ids',
			],
			'onSale'     => [
				'ids',
			],
			'del'        => [
				'ids',
			],
		];

	//	public function sceneAdd()
	//	{
	//		return $this->only( [
	//			'name',
	//			'age',
	//		] )->append( 'name', 'min:5' )->remove( 'age', 'between' )->append( 'age', 'require|max:100' );
	//	}
	protected function checkSkus( $value, $rule, $data )
	{
		foreach( $value as $sku ){
			if( !isset( $sku['spec'] ) ){
				return '规格必填';
			} else{
				foreach( $sku['spec'] as $spec ){
					if( !isset( $spec['id'] ) ){
						return '规格id错误';
					}
					// 传来NULL依然会被认为未设置name
					if( !array_key_exists( 'name', $spec ) ){
						return '规格name错误';
					}
					if( !isset( $spec['value_id'] ) ){
						return '规格value_id错误';
					}
					if( !array_key_exists( 'value_name', $spec ) ){
						return '规格value_name错误';
					}

				}
			}
			if( !isset( $sku['price'] ) ){
				return '规格price必填';
			}
			if( !isset( $sku['stock'] ) ){
				return '规格stock必填';
			}
		}
		return true;
	}

	protected function checkBody( $bodies, $rule, $data )
	{
		foreach( $bodies as $body ){
			if( !isset( $body['type'] ) ){
				return 'body type必填';
			}
			if( !isset( $body['value'] ) ){
				return 'body value必填';
			}
			if( $body['type'] === 'text' && !isset( $body['value']['content'] ) ){
				return '文本格式错误';
			}
			if( $body['type'] === 'image' && !isset( $body['value']['url'] ) ){
				return '图片格式错误';
			}
			if( $body['type'] === 'goods' && (!isset( $body['value']['id'] ) || isset( $body['value']['img'] ) || !isset( $body['value']['img']['url'] ) || !isset( $body['value']['title'] ) || !isset( $body['value']['price'] ) || !isset( $body['value']['desc'] )) ){
				return '商品格式错误';
			}
		}
		return true;
	}
}