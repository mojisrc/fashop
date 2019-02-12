<?php

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 会员级别
 */
class Userlevel extends Admin
{
	public function _initialize()
	{
		parent::_initialize();
	}

	/**
	 * 会员级别列表
	 * @author 孙泉
	 */
	public function index()
	{
		$get       = $this->get;
		$condition = [];
		$get['keywords'] ? $condition['title'] = ['like', '%'.$get['keywords'].'%'] : null;

		//分页
		$count = \App\Model\UserLevel::where( $condition )->count();
		$field = '*';
		$order = 'id asc';
		$list  = \App\Model\UserLevel::getUserLevelList( $condition, $field, $order, $this->getPageLimit() );
		return $this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 会员级别添加
	 * @author 孙泉
	 */
	public function add()
	{
		if( $this->post ){
			$post = $this->post;
			if( !trim( $post['title'] ) ){
				return $this->send( Code::param_error, [], '请输入名称' );
			}
			$data          = $post;
			$user_level_id = \App\Model\UserLevel::addUserLevel( $data );
			if( $user_level_id ){
				//记录行为
				// action_log('update_user_level', 'user_level', $user_level_id, $this->user['id']);
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 会员级别修改
	 * @author 孙泉
	 */
	public function edit()
	{
		if( $this->post ){
			$post = $this->post;
			if( !trim( $post['title'] ) ){
				return $this->send( Code::param_error, [], '请输入名称' );
			}

			if( !trim( $post['id'] ) ){
				return $this->send( Code::param_error );
			}

			$data          = $post;
			$user_level_id = \App\Model\UserLevel::editUserLevel( $data, $condition );
			if( $user_level_id ){
				//记录行为
				// action_log('update_user_level', 'user_level', $user_level_id, $this->user['id']);
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 详情
	 * @return
	 */
	public function info()
	{
		$get             = $this->get;
		$condition['id'] = $get['id'];
		if( !$condition ){
			return $this->send( Code::param_error );
		}
		$row            = \App\Model\UserLevel::getUserLevelInfo( $condition, $field = '*' );
		$result['info'] = $row;
		return $this->send( Code::success, $result );
	}

	/**
	 * 会员级别删除
	 * @author 孙泉
	 */
	public function del()
	{
		$post = $this->post;
		$ids  = $post['ids'];
		$res  = \App\Model\UserLevel::where( [
			'id' => is_array( $ids ) ? ['in', implode( ',', $ids )] : $ids,
		] )->delete();
		if( $res ){
			return $this->send( Code::success );
		} else{
			return $this->send( Code::error );
		}
	}
}

?>