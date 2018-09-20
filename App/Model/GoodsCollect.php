<?php
/**
 * 共用收藏数据模型
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

class GoodsCollect extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';
	/**
	 * 添加
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addGoodsCollect( $data = [] )
	{
		$data['create_time'] = time();
		$result              = $this->allowField( true )->save( $data );
		if( $result ){
			return $this->getLastInsID();
		}
		return $result;
	}

	/**
	 * 修改
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editGoodsCollect( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delGoodsCollect($condition = [], $condition_str = '')
	{
        return $this->where($condition)->where($condition_str)->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getGoodsCollectCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取收藏单条数据
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array
	 */
	public function getGoodsCollectInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得收藏列表
	 * @datetime 2017-04-19 09:47:46
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $group
	 * @param    string $order
	 * @param    string $page
	 * @return   array
	 */
	public function getGoodsCollectList( $condition = [], $field = '*', $group = '', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelGoodsCollect( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}


    /**
     * 获取的id
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCollectId($condition = array(), $condition_str = '') {
        return $this->where($condition)->where($condition_str)->value('id');
    }

    /**
     * 获取某个字段
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCollectValue($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->value($field);
    }

    /**
     * 获取某个字段列
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @return [type]                   [数据]
     */
    public function getGoodsCollectColumn($condition = array(), $condition_str = '', $field = 'id') {
        return $this->where($condition)->where($condition_str)->column($field);
    }


}

?>