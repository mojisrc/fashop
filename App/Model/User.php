<?php

namespace App\Model;

use ezswoole\Model;
use ezswoole\Log;

class User extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	public function addUser( array $data )
	{
		$this->startTrans();
		try{
			$now_time = time();
			$user_id  = $this->insertGetId( array_merge( $data, [
				//				'invitation_code' => $this->getInvitationCode(),
				'salt'        => $this->createSalt( 0 ),
				'create_time' => $now_time,
			] ) );
			$this->commit();
			return $user_id;
		} catch( \Exception $e ){
			$this->rollback();
			Log::write( $e->getMessage(), 'sql' );
			return false;
		}
	}

	public function editUser( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	public function delUser( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	public function getUserCount( $condition )
	{
		return $this->where( $condition )->count();
	}


	public function getUserList( $condition = [], $field = '*', $order = 'id desc', $page = "1,10" )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}

	public function getUserInfo( $condition = [], $field = '*', $extends = [] )
	{
		$result    = $this->field( $field )->where( $condition )->find();
		$user_info = $result ? $result->toArray() : [];
		unset( $user_info['pay_password'] );
		return $user_info;
	}

	/**
	 * 获得邀请码
	 * 这么写有BUG 不过短期内不会，如果用户超过8位数了 请改次方法
	 */
	public function getInvitationCode()
	{
		return sprintf( '%x', crc32( microtime() ) );
	}


	/**
	 * 创建访问令牌，用户的salt
	 * @param int $user_id 用户id
	 * @return string
	 */
	public function createSalt( $user_id = 0 )
	{
		return md5( $user_id + time() + rand( 10000, 99999 ) );
	}

	// 获取用户等级信息
	public function getUserLevel( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->alias( 'user' )->join( '__USER_LEVEL__ user_level', 'user.user_level_id = user_level.id', 'LEFT' )->field( $field )->find();
		return $info;
	}


	public function getUserValue( $condition, $field = '*' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiUser( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * todo
	 * 获得排除字段的信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getUserExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获得当前账号所有的用户ID
	 * @param  int user_id 当前用户id
	 */
	public function getUserAllIds( $user_id = 0 )
	{
		if( $user_id <= 0 ){
			return [];
		}

		$user_id_array      = [$user_id];
		$open_user_id_array = UserOpen::getUserOpenColumn( ['user_id' => $user_id], '', 'origin_user_id' );
		return $open_user_id_array ? array_unique( array_merge( $user_id_array, $open_user_id_array ) ) : $user_id_array;
	}

}
