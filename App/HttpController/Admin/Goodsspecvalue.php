<?php
/**
 * 商品规格值管理
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
 * 商品规格值
 * Class Goodsspecvalue
 * @package App\HttpController\Admin
 */
class Goodsspecvalue extends Admin
{

	/**
	 * 商品规格值列表
	 * @method GET
	 * @param int $spec_id 规格id
	 */
	public function list()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpecValue.values' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition            = [];
			$condition['spec_id'] = $this->get['spec_id'];
			$list                 = \App\Model\GoodsSpecValue::init()->getGoodsSpecValueList( $condition, 'id,name', 'id desc', [1,10000] );
			$this->send( Code::success, [
				'list' => $list,
			] );
		}
	}

	/**
	 * 添加商品规格值
	 * @method POST
	 * @param int    $spec_id 规格id
	 * @param string $name    规格值名字
	 */
	public function add()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpecValue.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$result = \App\Model\GoodsSpecValue::init()->addGoodsSpecValue( $this->post );
			if( $result ){
				$this->send( Code::success );
			} else{
				$this->send( Code::error );
			}
		}
	}

	/**
	 * 删除商品规格值
	 * @method POST
	 * @param  int id 规格值id
	 */
	public function del()
	{
		if( $this->validator( $this->post, 'Admin/GoodsSpecValue.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$condition       = [];
			$condition['id'] = $this->post['id'];
			$row                    = \App\Model\GoodsSpecValue::init()->getGoodsSpecValueInfo( $condition, '*' );
			if( !$row ){
				$this->send( Code::param_error );
			} else{
				//系统级 默认0自定义 1系统
				// if($row['is_system'] == 1){
				//     return $this->send( Code::param_error, [], '系统数据，不可删除' );
				// }

				$result = \App\Model\GoodsSpecValue::init()->delGoodsSpecValue( $condition );
				if( !$result ){
					$this->send( Code::error );
				} else{
					$this->send( Code::success );

				}
			}
		}
	}

}

?>