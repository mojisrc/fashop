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
use traits\model\SoftDelete;

class AccessToken extends Model
{
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-06-15 16:22:25
	 * @author   韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addAccessToken( $data = [] )
	{
		$data['create_time'] = time();
		$data['ip']          = \App\Utils\Ip::getClientIp();
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
	public function addAccessTokenAll( $data )
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
	public function editAccessToken( $condition = [], $data = [] )
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
	public function delAccessToken( $condition = [] )
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
	public function getAccessTokenCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取权限单条数据
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getAccessTokenInfo($condition = array(), $field = '*',$order = 'create_time desc') {
		$info = $this->where($condition)->field($field)->order($order)->find();
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
	public function getAccessTokenList( $condition = [], $field = '*', $order = '', $page = '1,10', $group = '' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->group( $group )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}
	/**
	 * 软删除
	 * @param    array  $condition
	 */
	public function softDelAccessToken($condition) {
        return $this->where($condition)->find()->delete();
	}

}

?>