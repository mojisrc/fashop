<?php
/**
 * 商品规格管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 商品规格
 * Class Goodsspec
 * @package App\HttpController\Admin
 */
class Goodsspec extends Admin
{

	/**
	 * 商品规格列表
	 * @method GET
	 */
	public function list()
	{
		$_list      = \App\Model\GoodsSpec::init()->getGoodsSpecList( [], 'id,name', 'id asc', [1, 1000] );
		$value_list = \App\Model\GoodsSpecValue::init()->getGoodsSpecValueList( [], 'id,name,spec_id', 'spec_id asc', '1,100000' );
		foreach( $_list as $key => $item ){
			$list[$item['id']]           = $item;
			$list[$item['id']]['values'] = [];
		}
		foreach( $value_list as $key => $item ){
			$list[$item['spec_id']]['values'][] = $item;
		}
		return $this->send( Code::success, [
			'list' => $list ? array_values( $list ) : [],
		] );
	}

	/**
	 * 添加商品规格
	 * @method POST
	 * @param string $name 规格名称
	 */
	public function add()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpec.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$result = \App\Model\GoodsSpec::init()->addGoodsSpec( $this->post );
			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}

	}

	/**
	 * 修改商品规格
	 * @method POST
	 * @param int    $id   规格ID
	 * @param string $name 规格名称
	 */
	public function edit()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpec.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition['id'] = $this->post['id'];
			$result          = \App\Model\GoodsSpec::init()->editGoodsSpec( ['id' => $this->post['id']], $this->post );
			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 删除商品规格
	 * @method POST
	 * @param int $id 规格ID
	 */
	public function del()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpec.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$row             = \App\Model\GoodsSpec::init()->getGoodsSpecInfo( $condition, '*' );
			if( !$row ){
				$this->send( Code::param_error );
			}
			//系统级 默认0自定义 1系统
			// if($row['is_system'] == 1){
			//     return $this->send( Code::param_error, [], '系统数据，不可删除' );
			// }
			$result = \App\Model\GoodsSpec::where( $condition )->del();
			if( !$result ){
				$this->send( Code::error );
			} else{
				$this->send( Code::success );

			}
		}
	}
}

?>