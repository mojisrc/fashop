<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/9
 * Time: 下午9:25
 *
 */

namespace App\Model;

use ezswoole\Model;

class VerifyCode extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addVerifyCode( $data = [] )
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
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addVerifyCodeAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editVerifyCode( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delVerifyCode( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getVerifyCodeCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取消息单条数据
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getVerifyCodeInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得消息列表
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array | false
	 */
	public function getVerifyCodeList( $condition = [], $field = '*', $order = '', $page = '1,10', $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

}

?>