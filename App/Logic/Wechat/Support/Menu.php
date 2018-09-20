<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午10:00
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class Menu extends BaseAbstract
{
	/**
	 * 读取（查询）已设置菜单
	 * @author 韩文博
	 */
	public function list()
	{
		return $this->app->menu->list();
	}

	/**
	 * 获取当前菜单
	 * @author 韩文博
	 */
	public function current()
	{
		return $this->app->menu->current();
	}

	/**
	 * 创建自定义菜单
	 * @method POST
	 * @param array $buttons
	 * @author 韩文博
	 */
	public function create( array $buttons )
	{
		return $this->app->menu->create( $buttons );
	}

	/**
	 * 删除菜单
	 * @param int $id
	 * 有两种删除方式，一种是全部删除，另外一种是根据菜单 ID 来删除(删除个性化菜单时用，ID 从查询接口获取)
	 * @author 韩文博
	 */
	public function delete( int $menu_id = null )
	{
		return $this->app->menu->delete( $menu_id );
	}
}