<?php
/**
 * 快递公司数据模型
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

class Express extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addExpress( $data = [] )
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
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addExpressAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editExpress( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delExpress( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getExpressCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取快递公司单条数据
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getExpressInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得快递公司列表
	 * @datetime 2017-10-25 12:11:10
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getExpressList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelExpress( $condition )
	{
		return $this->where( $condition )->find()->delete();
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getExpressValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param  [type] $condition [description]
	 * @return [type]            [description]
	 */
	public function getExpressColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

}

?>