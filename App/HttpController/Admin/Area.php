<?php
/**
 * 地区管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 地区管理
 * Class Area
 * @package App\HttpController\Admin
 */
class Area extends Admin
{
	/**
	 * 地区列表
	 * @method GET
	 * @param int pid 父级id
	 * @param int level 层级 规则：设置显示下级行政区级数（行政区级别包括：省/直辖市、市、区/县3个级别）可选值：0、1、2  0：返回省/直辖市；1：返回省/直辖市、市；2：返回省/直辖市、市、区/县
	 * @param int $tree 默认 0
	 */
	public function list()
	{
		$get       = $this->get;
		$condition = [];
		if( isset( $get['pid'] ) ){
			$condition['pid'] = $get['pid'];
		} elseif( isset( $get['level'] ) ){
			switch( (int)$get['level'] ){
			case 0:
				$condition['level'] = 1;
			break;
			case 1:
				$condition['level'] = ['in', '1,2'];
			break;
			case 2:
				$condition['level'] = ['in', '1,2,3'];
			break;
			default:
				$condition['level'] = 1;
			}
		} else{
			$condition['level'] = 1;
		}
		$list = model( 'Area' )->getAreaList($condition, 'id,name,pid,longitude,latitude', 'id asc', '1,1000000' );
		$this->send( Code::success, [
			'list' => isset($get['tree'])  ? \App\Utils\Tree::listToTree( $list ) : $list,
		] );
	}
}

?>