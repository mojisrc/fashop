<?php
/**
 * 订单商品数据模型
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
use EasySwoole\Core\Component\Di;

class OrderGoods extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [
			'goods_spec' => 'json',
		];

	/**
	 * 添加
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addOrderGoods( $data = [] )
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
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addOrderGoodsAll( $data )
	{
		return $this->saveAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @param bool
	 */
	public function editOrderGoods( $condition = [], $data = [] )
	{
		return !!$this->update( $data, $condition, true )->saveResult;
	}

	/**
	 * 删除
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delOrderGoods( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getOrderGoodsCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取订单商品单条数据
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getOrderGoodsInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得订单商品列表
	 * @datetime 2017-05-28 22:52:04
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getOrderGoodsList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 获得某字段的和
	 *
	 * @param array  $condition
	 * @param string $field
	 * @return boolean
	 */
	public function getOrderGoodsSum( $condition, $field )
	{
		return $this->where( $condition )->sum( $field );
	}

	/**
	 * 列表 todo废除
	 *
	 * @param array   $condition 条件
	 * @param string  $field     字段
	 * @param string  $group     分组
	 * @param string  $order     排序
	 * @param int     $limit     限制
	 * @param int     $page      分页
	 * @param boolean $lock      是否锁定
	 * @return array 二维数组
	 */
	public function getOrderGoodsMoreList( $condition, $field = '*', $group = '', $order = '', $page = '1,20' )
	{
		return $this->join( '__GOODS__ goods ON order_goods.goods_id = goods.id', 'inner' )->field( $field )->where( $condition )->group( $group )->order( $order )->paginate( $page )->select();

	}

	/**
	 * 获得数量 todo 废除
	 *
	 * @param array  $condition
	 * @param string $field
	 * @return int
	 */
	public function getOrderGoodsMoreCount( $condition )
	{
		return $this->join( '__GOODS__ goods ON order_goods.goods_id = goods.id', 'inner' )->where( $condition )->count( "DISTINCT order_goods.goods_id" );

	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelOrderGoods( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}

    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getOrderGoodsId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getOrderGoodsValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }
}

?>