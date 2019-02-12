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
			$pageModel = new \App\Model\Page;
			$total     = $pageModel->count();
			$list      = $pageModel->getPageList( [], '*', 'id desc', $this->getPageLimit() );
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
		$pageModel      = new \App\Model\Page;
		$info           = $pageModel->getPageInfo( ['is_portal' => 1] );
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