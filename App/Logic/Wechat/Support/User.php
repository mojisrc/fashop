<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午9:55
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class User extends BaseAbstract
{
	/**
	 * 获取单个用户
	 * @param string $openid
	 * @author 韩文博
	 */
	public function get( string $openid ) : array
	{
		return $this->app->user->get( $openid );
	}

	/**
	 * 获取多个
	 * @param array $openids
	 * @return mixed
	 * @author 韩文博
	 */
	public function select( array $openids ) : array
	{
		return $this->app->user->select( $openids );
	}

	/**
	 * 获取用户列表
	 * @param string $next_openid [可选]
	 * @author 韩文博
	 */
	public function list( string $next_openid = null ) : array
	{
		return $this->app->user->list( $next_openid );
	}

	/**
	 * 修改用户备注
	 * @param string $openid
	 * @param string $remark
	 * @author 韩文博
	 */
	public function remark( string $openid, string $remark )
	{
		return $this->app->user->remark( $openid, $remark );
	}


	/**
	 * 拉黑用户
	 * @param array $openids
	 * @author 韩文博
	 */
	public function block( array $openids )
	{
		return $this->app->user->block( $openids );
	}

	/**
	 * 取消拉黑用户
	 * @param array $openids
	 * @author 韩文博
	 */
	public function unblock( array $openids )
	{
		return $this->app->user->unblock( $openids );
	}

	/**
	 * 黑名单列表
	 * @param string $begin_openid [可选]
	 * @author 韩文博
	 */
	public function blacklist(string $begin_openid = null) : array
	{
		return $this->app->user->blacklist($begin_openid );
	}
}