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

namespace App\HttpController\Server;

use App\Utils\Code;
use ezswoole\Db;

/**
 * 地区管理
 * Class Area
 * @package App\HttpController\Server
 */
class Area extends Server
{
	/**
	 * 地区列表
	 * @method GET
	 * @param int pid 父级id
	 * @param int level 层级 规则：设置显示下级行政区级数（行政区级别包括：省/直辖市、市、区/县3个级别）可选值：0、1、2  0：返回省/直辖市；1：返回省/直辖市、市；2：返回省/直辖市、市、区/县
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

		$list = model( 'Area' )->getAreaList( $condition, 'id,name,pid,longitude,latitude,level', 'id asc', '1,1000000' );
		$this->send( Code::success, [
			'list' => isset( $get['level'] ) ? \App\Utils\Tree::listToTree( $list ) : $list,
		] );
	}

	/**
	 * 区域信息
	 * 区县级，包含省和市
	 * @method GET
	 * @param string $name     如：海珠区
	 * @param string $up_level ,默认2，向上两层 @todo
	 * @todo   拓展其他方式的获取 如id
	 *                         为：不只为微信端做服务
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Server/Area.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$db   = Db::name( 'Area' );
				$area = $db->where( ['name' => $this->get['name']] )->field( 'id,pid,name' )->find();
				if( $area ){
					$city     = $db->where( ['id' => $area['pid']] )->field( 'id,pid,name' )->find();
					$province = $db->where( ['id' => $city['pid']] )->field( 'id,pid,name' )->find();
					$this->send( Code::success, ['info' => [$province, $city, $area]] );
				} else{
					$this->send( Code::param_error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}
}

?>