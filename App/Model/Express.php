<?php
/**
 * 快递公司数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Model;




class Express extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * @param $data
	 * @return bool|int
	 */
	public function addExpress( $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editExpress( $condition = [], $data = [] )
	{
		$data['update_time'] = time();
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delExpress( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param $condition
	 * @return array|bool|int|null
	 */
	public function getExpressCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getExpressInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getExpressList( $condition = [], $field = '*', $order = 'id desc', $page = [1, 10] )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	/**
	 * @param $condition
	 * @param $field
	 * @return array|bool|null
	 */
	public function getExpressValue( $condition, $field )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * @param $condition
	 * @param $field
	 * @return array|bool
	 */
	public function getExpressColumn( $condition, $field )
	{
		return $this->where( $condition )->column( $field );
	}

}

?>