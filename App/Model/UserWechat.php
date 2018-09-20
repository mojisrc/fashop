<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午5:20
 *
 */

namespace App\Model;
use ezswoole\Model;

class UserWechat extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addUserWechat( $data = [] )
	{
		$result              = $this->allowField( true )->save( $data );
		return $result;
	}

	/**
	 * 添加多条
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addUserWechatAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editUserWechat( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delUserWechat( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getUserWechatCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取用户微信表单条数据
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getUserWechatInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得用户微信表列表
	 * @datetime 2018-02-05 17:20:37
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getUserWechatList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>