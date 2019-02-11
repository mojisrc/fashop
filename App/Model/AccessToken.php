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

class AccessToken extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * @param  array $data
	 * @return int pk
	 */
	public function addAccessToken( array $data )
	{
		$data['ip'] = \App\Utils\Ip::getClientIp();
		return $this->add( $data );
	}

	/**
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editAccessToken( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delAccessToken( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getAccessTokenInfo( $condition = [], $field = '*', $order = 'create_time desc' )
	{
		$info = $this->where( $condition )->field( $field )->order( $order )->find();
		return $info;
	}

}

?>