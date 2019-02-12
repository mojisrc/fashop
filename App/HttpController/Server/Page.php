<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/2
 * Time: 下午10:30
 *
 */

namespace App\HttpController\Server;

use App\Utils\Code;
use Hashids\Hashids;
use ezswoole\Db;
use App\Logic\Page\PageGoods as PageGoodsLogic;

class Page extends Server
{
	/**
	 * 页面列表
	 * @method GET
	 */
	public function list()
	{
		try{
			$total = \App\Model\Page::where( [] )->count();
			$list  = \App\Model\Page::getPageList( [], '*', 'id desc', $this->getPageLimit() );
			$this->send( Code::success, [
				'list'         => $list,
				'total_number' => $total,
			] );
		} catch( \Exception $e ){
			$this->send( Code::server_error, [], $e->getMessage() );
		}
	}

	/**
	 * 首页
	 * @method GET
	 */
	public function portal()
	{
		$info           = \App\Model\Page::getPageInfo( [
			'is_portal' => 1,
		] );
		$pageGoodsLogic = new PageGoodsLogic();
		$info['body']   = $pageGoodsLogic->filterGoods( $info['body'] );

		$this->send( Code::success, [
			'info' => $info,
		] );
	}

	/**
	 * 页面详情
	 * @method GET
	 * @param string $id
	 */
	public function info()
	{

		if( !isset( $this->get['id'] ) ){
			$this->send( Code::param_error );
		} else{
			try{
				$info           = \App\Model\Page::getPageInfo( [
					'id' => $this->get['id'],
				] );
				$pageGoodsLogic = new PageGoodsLogic();
				$info['body']   = $pageGoodsLogic->filterGoods( $info['body'] );
				$this->send( Code::success, [
					'info' => $info,
				] );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

}