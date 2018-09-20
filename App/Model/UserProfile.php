<?php
/**
 * 用户辅助信息模型
 */

namespace App\Model;

use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class UserProfile extends Model
{
	use SoftDelete;
	protected $deleteTime = 'delete_time';
	protected $resultSetType = 'collection';

	protected $type
		= [// ''      =>  'json',
		];

	/**
	 * 列表
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获得数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获得数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data ? $data->toArray() : [];
	}

	/**
	 * 查询普通的数据和软删除的数据的数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @param  [type] $order            [排序]
	 * @param  [type] $page             [分页]
	 * @param  [type] $group            [分组]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = '1,20', $group = '' )
	{
		if( $page == '' ){
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

		}
		return $data ? $data->toArray() : [];
	}

	/**
	 * 只查询软删除的数据的数量
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $distinct         [去重]
	 * @return [type]                   [数据]
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
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获得排除字段的信息
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '' )
	{
		$data = $this->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获得信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获得排除字段的信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 查询普通的数据和软删除的数据信息
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 查询普通的数据和软删除的数据信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 查询普通的数据和软删除的排除字段数据信息
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}


	/**
	 * 查询普通的数据和软删除的排除字段数据信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getWithTrashedUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->withTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 只查询软删除的数据信息
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 只查询软删除的数据信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $field            [字段]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileMoreInfo( $condition = [], $condition_str = '', $field = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $field )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 只查询软删除的排除字段数据信息
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileExcludeInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}


	/**
	 * 只查询软删除的排除字段数据信息更多
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @param  [type] $exclude          [排除]
	 * @return [type]                   [数据]
	 */
	public function getOnlyTrashedUserProfileExcludeMoreInfo( $condition = [], $condition_str = '', $exclude = '*' )
	{
		$data = $this->alias( 'user_profile' )->join( '__USER__ user', 'user_profile.user_id = user.id', 'LEFT' )->onlyTrashed()->where( $condition )->where( $condition_str )->field( $exclude, true )->find();
		return $data ? $data->toArray() : [];
	}

	/**
	 * 获取的id
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileId( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileValue( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function getUserProfileColumn( $condition = [], $condition_str = '', $field = 'id' )
	{
		return $this->where( $condition )->where( $condition_str )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function setIncUserProfile( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function setDecUserProfile( $condition = [], $condition_str = '', $field, $num = 1 )
	{
		return $this->where( $condition )->where( $condition_str )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param  [type] $insert           [添加数据]
	 */
	public function insertUserProfile( $insert = [] )
	{
		return $this->save( $insert ) ? $this->id : false;
	}

	/**
	 * 添加多条数据
	 * @param  [type] $insert           [添加数据]
	 */
	public function insertAllUserProfile( $insert = [] )
	{
		return $this->saveAll( $insert );
	}

	/**
	 * 修改信息
	 * @param  [type] $update           [更新数据]
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 * @return [type]                   [数据]
	 */
	public function updateUserProfile( $condition = [], $update = [] )
	{
		return $this->save( $update, $condition );
	}

	/**
	 * 修改多条数据
	 * @param  [type] $update           [更新数据]
	 */
	public function updateAllUserProfile( $update = [] )
	{
		return $this->saveAll( $update );
	}

	/**
	 * 删除
	 * @param  [type] $condition        [条件]
	 * @param  [type] $condition_str    [条件]
	 */
	public function delUserProfile( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->delete();
	}

	/**
	 * 软删除
	 * @param    array $condition
	 */
	public function softDelUserProfile( $condition = [], $condition_str = '' )
	{
		return $this->where( $condition )->where( $condition_str )->find()->delete();
	}

}
