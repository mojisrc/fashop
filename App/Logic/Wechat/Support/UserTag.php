<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:16
 *
 */

namespace App\Logic\app;

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class UserTag extends BaseAbstract
{
	/**
	 * 获取所有标签
	 * @method GET
	 * @author 韩文博
	 */
	public function list()
	{
		return $this->app->user_tag->list();
	}

	/**
	 * 创建标签
	 * @param string $name
	 * @return mixed
	 * @author 韩文博
	 */
	public function create( string $name )
	{
		return $this->app->user_tag->create( $name );
	}

	/**
	 * 修改标签信息
	 * @param int    $id
	 * @param string $name
	 * @author 韩文博
	 */
	public function update( int $id, string $name )
	{
		return $this->app->user_tag->update( $id, $name );
	}

	/**
	 * 删除标签
	 * @param int $id
	 * @return mixed
	 * @author 韩文博
	 */
	public function delete( int $id )
	{
		return $this->app->user_tag->delete( $id );
	}

	/**
	 * 获取指定 openid 用户所属的标签
	 * @param string $openid
	 * @author 韩文博
	 */
	public function userTags( string $openid )
	{
		return $this->app->user_tag->userTags( $openid );
	}

	/**
	 * 获取标签下用户列表
	 * @param int    $id
	 * @param string $next_openid 第一个拉取的OPENID，不填默认从头开始拉取
	 * @return mixed
	 * @author 韩文博
	 */
	public function usersOfTag( int $id, string $next_openid = '' )
	{
		return $this->app->user_tag->usersOfTag( $id, $next_openid );
	}

	/**
	 * 批量为用户添加标签
	 * @param array $openids
	 * @param int   $id
	 * @author 韩文博
	 */
	public function tagUsers( array $openids, int $id )
	{
		return $this->app->user_tag->tagUsers( $openids, $id );
	}

	/**
	 * 批量为用户移除标签
	 * @method POST
	 * @param array $openids
	 * @param int   $id
	 * @author 韩文博
	 */
	public function untagUsers( array $openids, int $id )
	{
		return $this->app->user_tag->untagUsers( $openids, $id );
	}

}