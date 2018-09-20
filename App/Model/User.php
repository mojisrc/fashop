<?php

namespace App\Model;

use ezswoole\Model;
use ezswoole\Log;
use traits\model\SoftDelete;

class User extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	/**
	 * 添加用户
	 * @param array $data 用户信息
	 * @author 韩文博
	 * @throws \Exception
	 */
	public function addUser( array $data )
	{
		$this->startTrans();
		try{
			$now_time = time();
			$user_id  = $this->insertGetId( array_merge( $data, [
//				'invitation_code' => $this->getInvitationCode(),
				'salt'            => $this->createSalt( 0 ),
				'create_time'     => $now_time,
			] ) );
			$this->commit();
			return $user_id;
		} catch( \Exception $e ){
			$this->rollback();
			Log::write( $e->getMessage(), 'sql' );
			return false;
		}
	}

	/**
	 * 添加多条
	 * @datetime 2017-04-20 15:49:43
	 * @author   韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addUserAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-04-20 15:49:43
	 * @author   韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editUser( $condition = [], $data = [] )
	{
		return $this->update( $data, $condition, true );
	}

	/**
	 * 删除
	 * @datetime 2017-04-20 15:49:43
	 * @author   韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delUser( $condition = [] )
	{
		return $this->where( $condition )->delete();
	}

	/**
	 * 计算数量
	 * @datetime 2017-04-20 15:49:43
	 * @author   韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getUserCount( $condition )
	{
		return $this->where( $condition )->count();
	}


	/**
	 * 用户列表
	 * @param array  $condition
	 * @param string $field
	 * @param number $page
	 * @param string $order
	 */
	public function getUserList( $condition = [], $field = '*', $order = 'id desc', $page = "1,10" )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list ? $list->toArray() : false;
	}

	/**
	 * 获取单个用户信息
	 * @datetime 2017-04-20T15:23:09+0800
	 * @author   韩文博
	 * @param    array  $condition
	 * @param    string $field
	 * @param    array  $extends
	 * @return   array
	 */
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
	 * @author 韩文博
	 */
	public function createSalt( $user_id = 0 )
	{
		return md5( $user_id + time() + rand( 10000, 99999 ) );
	}

	// 获取用户等级信息
	public function getUserLevel( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->alias( 'user' )->join( '__USER_LEVEL__ user_level', 'user.user_level_id = user_level.id', 'LEFT' )->field( $field )->find();
		return $info ? $info->toArray() : false;
	}


	/**
	 * 获得任意一个用户的一个字段值
	 * @param array  $condition
	 * @param string $field
	 * @param number $page
	 * @param string $order
	 */
	public function getUserValue( $condition, $field = '*' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelUser( $condition )
	{
		$find = $this->where( $condition )->find();
		if( $find ){
			return $find->delete();
		} else{
			return false;
		}
	}

    /**
     * 修改多条数据
     * @param  [type] $update           [更新数据]
     */
    public function updateAllUser($update = []) {
        return $this->saveAll($update);
    }
    /**
     * 获得排除字段的信息
     * @param  [type] $condition        [条件]
     * @param  [type] $condition_str    [条件]
     * @param  [type] $exclude          [排除]
     * @return [type]                   [数据]
     */
    public function getUserExcludeInfo($condition = [], $condition_str = '', $exclude = '') {
        $data = $this->where($condition)->where($condition_str)->field($exclude,true)->find();
        return $data ? $data->toArray() : array();
    }

    /**
     * 获得当前账号所有的用户ID
     * @param  int user_id 当前用户id
     */
    public function getUserAllIds($user_id = 0) {
        if($user_id <=0){
            return [];
        }

        $user_id_array      = [$user_id];
        $user_open_model    = model('UserOpen');
        $open_user_id_array = $user_open_model->getUserOpenColumn(['user_id' => $user_id], '', 'origin_user_id');

        return $open_user_id_array ? array_unique(array_merge($user_id_array,$open_user_id_array)) : $user_id_array;
    }

}
