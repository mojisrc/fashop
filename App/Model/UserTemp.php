<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午5:17
 *
 */

namespace App\Model;


/**
 * 用户临时表数据模型
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

class UserTemp extends Model
{
	protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param  array $data
	 */
	public function addUserTemp( $data = [] )
	{
		return $this->allowField(true)->save($data);
	}

	/**
	 * 添加多条
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addUserTempAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editUserTemp( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delUserTemp( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getUserTempCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取用户临时表单条数据
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getUserTempInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}

	/**
	 * 获得用户临时表列表
	 * @datetime 2018-02-05 17:17:20
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getUserTempList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
}

?>