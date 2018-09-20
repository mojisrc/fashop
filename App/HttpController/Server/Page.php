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
	 * @author 韩文博
	 */
	public function list()
	{
		try{
			$shop  = Db::name( 'Shop' )->where( ['id' => 1] )->field( 'host,salt' )->find();
			$model = model( 'Page' );
			$total = $model->where( [] )->count();
			$list  = $model->getPageList( [], '*', 'id desc', $this->getPageLimit() );

			$hashids = new Hashids( $shop['salt'] );
			if( !empty( $list ) ){
				foreach( $list as $key => $site ){
					$list[$key]['id'] = $hashids->encode( $site['id'] );
				}
			}
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
	 * @author 韩文博
	 */
	public function portal()
	{
        $info           = model("Page")->getPageInfo([
             'is_portal' => 1,
         ]);
        $pageGoodsLogic = new PageGoodsLogic();
        $info['body']   = $pageGoodsLogic->filterGoods($info['body']);
		$this->send( Code::success, [
			'info' => $info,
		] );
	}

	/**
	 * 页面详情
	 * @method GET
	 * @param string $id
	 * @author 韩文博
	 */
	public function info()
	{

		if( !isset( $this->get['id'] ) ){
			$this->send( Code::param_error );
		} else{
			try{
                $shop           = Db::name('Shop')->where(['id' => 1])->field('host,salt')->find();
                $hashids        = new Hashids($shop['salt']);
                $page_id        = (int)$hashids->decode($this->get['id']);
                $info           = model( "Page" )->getPageInfo( [
                     'id' => $page_id,
                 ] );
                $pageGoodsLogic = new PageGoodsLogic();
                $info['body']   = $pageGoodsLogic->filterGoods($info['body']);
				$this->send( Code::success, [
					'info' => $info,
				] );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	public function test(){
		$data = [

		];
		$this->send( Code::success, ['info'=>$data] );

	}
}