<?php
/**
 * 数据统计
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


class Analysis extends Model
{
	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addArea( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param array $condition
	 * @param array $data
	 * @return bool|mixed
	 */
	public function editArea( $condition = [], $data = [] )
	{
		return $this->where( $condition )->edit( $data );
	}

	/**
	 * @param array $condition
	 * @return bool|null
	 */
	public function delArea( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @return array|bool
	 */
	public function getAreaInfo( $condition = [], $field = '*' )
	{
		return $this->where( $condition )->field( $field )->find();
	}

	/**
	 * @param array  $condition
	 * @param string $field
	 * @param string $order
	 * @param array  $page
	 * @return array|bool|false|null
	 */
	public function getList( $condition = [], $field = '*', $order = 'id desc', $page = [], $group = '' )
	{
        if(empty($page)){
            return $this->where( $condition )->order( $order )->field( $field )->select();
        }else{
            return $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
        }
	}

?>