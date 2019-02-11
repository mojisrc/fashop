<?php
/**
 * 用户辅助信息模型
 */

namespace App\Model;

use ezswoole\Model;


class UserProfile extends Model
{
	protected $softDelete = true;


	protected $type
		= [// ''      =>  'json',
		];

	/**
	 * 列表
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getUserProfileCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 列表更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getUserProfileMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 查询普通的数据和软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getWithTrashedUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getWithTrashedUserProfileCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->withTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 查询普通的数据和软删除的数据更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getWithTrashedUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getWithTrashedUserProfileMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 只查询软删除的数据
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOnlyTrashedUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data;
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOnlyTrashedUserProfileCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->onlyTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

		}
	}

	/**
	 * 只查询软删除的数据更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getOnlyTrashedUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data;
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getOnlyTrashedUserProfileMoreCount( $condition = [], $condition_str = '', $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->count();

		} else{
			return $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
		}
	}

	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得排除字段的信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获得信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 获得排除字段的信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getWithTrashedUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getWithTrashedUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 查询普通的数据和软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getWithTrashedUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}


	/**
	 * 查询普通的数据和软删除的排除字段数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getWithTrashedUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 只查询软删除的数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOnlyTrashedUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 只查询软删除的数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $field
	 * @return
	 */
	public function getOnlyTrashedUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data;
	}

	/**
	 * 只查询软删除的排除字段数据信息
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOnlyTrashedUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}


	/**
	 * 只查询软删除的排除字段数据信息更多
	 * @param   $condition
	 * @param   $condition_str
	 * @param   $exclude [排除]
	 * @return
	 */
	public function getOnlyTrashedUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data;
	}

	/**
	 * 获取的id
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserProfileId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserProfileValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function getUserProfileColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setIncUserProfile( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function setDecUserProfile( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertUserProfile( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllUserProfile( $insert = [] )
	{
		return $this->saveAll( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update
	 * @param   $condition
	 * @param   $condition_str
	 * @return
	 */
	public function updateUserProfile( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function updateAllUserProfile( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 * @param   $condition_str
	 */
	public function delUserProfile( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->delete();
	}

}
