<?php
/**
 * 规格的值的数据管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;

class GoodsSpecValue extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addGoodsSpecValue( $data )
	{
		$result = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addGoodsSpecValueAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function updateGoodsSpecValue( $update, $condition )
	{
		return $this->where( $condition )->update( $update );
	}

	/**
	 * 删除
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delGoodsSpecValue( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getGoodsSpecValueCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取商品类型单条数据
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getGoodsSpecValueInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得商品类型列表
	 * @datetime 2017-04-24 16:38:34
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getGoodsSpecValueList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelGoodsSpecValue( $condition )
	{
		$find = $this->where( $condition )->find();		if($find){			return $find->delete();		}else{			return false;		}
	}
}

?>