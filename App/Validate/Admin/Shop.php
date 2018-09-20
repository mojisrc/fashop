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

class Shop extends Validate
{
	protected $rule
		= [
			'name'                             => 'require',
			'logo'                             => 'require',
			'color_scheme'                     => 'require',
			'portal_template_id'               => 'require',
			'goods_category_style'             => 'require',
			'host'                             => 'checkHost',
			'order_auto_close_expires'         => 'require|integer',
			'order_auto_confirm_expires'       => 'require|integer',
			'order_auto_close_refound_expires' => 'require|integer',
		];
	protected $message
		= [
			'name.require'                 => "店铺名称必须",
			'logo.require'                 => "店铺logo必须",
			'color_scheme.require'         => "配色方案必须",
			'portal_template_id.require'   => "店铺首页模板id必须",
			'goods_category_style.require' => "店铺分类页风格必须",

		];
	protected $scene
		= [
			'setBaseInfo'           => [
				'name',
			],
			'setColorScheme'        => [
				'color_scheme',
			],
			'setPortalTemplate'     => [
				'portal_template_id',
			],
			'setGoodsCategoryStyle' => [
				'goods_category_style',
			],
			'setOrderExpires'=>[
				'order_auto_close_expires',
				'order_auto_confirm_expires',
				'order_auto_close_refound_expires'
			],

		];

	protected function checkHost( $value, $rule, $data )
	{
		// 可不设置
		if( !$value ){
			return true;
		} else{
			if( $this->is( $value, 'url' ) !== true ){
				return "链接地址不正确，正确格式如：http://www.fashop.cn";
			} else{
				return true;
			}
		}
	}
}