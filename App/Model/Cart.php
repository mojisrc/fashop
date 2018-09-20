<?php
/**
 * 购物车数据模型
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

class Cart extends Model
{
	protected $resultSetType = 'collection';
	protected $type = [
		'goods_spec'=>'json'
	];
	/**
	 * 添加
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addCart( $data = [] )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addCartAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editCart( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delCart( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getCartCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取购物车单条数据
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getCartInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得购物车列表
	 * @datetime 2018-01-30 20:26:18
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getCartList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 修改信息
     * @param  [type] $update    [description]
     * @param  [type] $condition [description]
     * @return [type]            [description]
     */
    public function updateCart($condition = array(),$update = array()) {
        return $this->save($update,$condition);
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getCartValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getCartColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }
}

?>