<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/3
 * Time: 上午10:42
 *
 */

namespace App\Validate\Admin\Wechat;


use ezswoole\Validate;

class LocalMaterial extends Validate
{
	protected $rule
		= [
			'id'    => 'require',
			'media' => 'require|array|checkData',

		];
	protected $message
		= [
			'media.checkData' => "数据格式不对",

		];
	protected $scene
		= [
			'add'  => [
				'media',
			],
			'edit' => [
				'id',
				'media',
			],
			'del'  => ['id'],
			'info'=>['id']
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkData( $value, $rule, $data )
	{
		foreach( $value as $key => $item ){
			// 第一组必填封面图
			if( $key === 0 ){
				if( isset( $item['cover_pic'] ) && $this->is( $item['cover_pic'], 'url' ) !== true ){
					return "封面图有误";
				}
			}
			if( !isset( $item['title'] ) ){
				return "标题必填";
			}
			if( !isset( $item['link']['action'] ) ){
				return "链接行为必填";
			}
		}
		return true;
	}
}