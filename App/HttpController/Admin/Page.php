<?php
/**
 *
 * 模板管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use Hashids\Hashids;
use ezswoole\Db;
use ezswoole\Validate;
use App\Logic\Page\BodyFormat as PageBodyFormat;
use App\Logic\Page\PageGoods as PageGoodsLogic;

/**
 * 页面
 * Class Page
 * @package App\HttpController\Admin
 */
class Page extends Admin
{

	/**
	 * 模板列表
	 * @method GET
	 * @param string $type      模板类型：主页portal ，v1用不到
	 * @param string $module    mobile，小程序wechat_mini，App为app
	 * @param string $is_system 系统级 默认0自定义 1系统
	 */
	public function list()
	{
		try{
			$condition = [];
			if( isset( $this->get['is_system'] ) ){
				$condition['is_system'] = $this->get['is_system'];
			}
			if( isset( $this->get['module'] ) ){
				$condition['module'] = $this->get['module'];
			}
			if( isset( $this->get['type'] ) ){
				$condition['type'] = $this->get['type'];
			}
			$model = model( 'Page' );
			$count = $model->where( $condition )->count();
			$list  = $model->getPageList( $condition, '*', 'id desc', $this->getPageLimit() );

			if( isset( $this->get['mobile'] ) ){
				$shop     = Db::name( 'Shop' )->where( ['id' => 1] )->field( 'host,salt' )->find();
				$validate = new Validate();
				if( $validate->is( $shop['host'], 'url' ) === true ){
					$host = rtrim( $shop['host'], '/' );
				} else{
					$host = $this->request->domain();
				}
				$hashids = new Hashids( $shop['salt'] );
				foreach( $list as $key => $item ){
					$list[$key]['page_url'] = $host."/mobile/page/".$hashids->encode( $item['id'] );
				}
			}

			$this->send( Code::success, [
				'total_number' => $count,
				'list'         => $list,
			] );
		} catch( \Exception $e ){
			$this->send( Code::server_error, [], $e->getMessage() );
		}
	}

	/**
	 * 模板添加
	 * @method POST
	 * @param string $name             页面名称
	 * @param string $description      页面描述，用户通过微信分享给朋友时，会自动显示页面描述
	 * @param string $background_color 页面背景颜色 , 如 #fff
	 * @param int    $clone_from_id    克隆来自
	 * @param string $body             模板内容，数据格式有要求，具体见《模板数据结构》
	 */
	public function add()
	{
		if( $this->validate( $this->post, 'Admin/Page.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$page_model = model( 'Page' );
				$data       = [];
				if( isset( $this->post['description'] ) ){
					$data['description'] = $this->post['description'];
				}
				if( isset( $this->post['clone_from_id'] ) ){
					$data['clone_from_id'] = $this->post['clone_from_id'];
				}
				$PageBodyFormat = new PageBodyFormat();
				$page_model->addPage( [
					'name'             => $this->post['name'],
					'description'      => $this->post['description'],
					'background_color' => $this->post['background_color'],
					'body'             => $PageBodyFormat->formatBody( $this->post['body'] ),
					'is_system'        => 0,
					'module'           => $this->post['module'] ? $this->post['module'] : 'wechat_mini',
				] );
				$this->send( Code::success );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}

		}
	}

	/**
	 * 模板编辑
	 * @method POST
	 * @param int    id
	 * @param string name 页面名称
	 * @param string description 页面描述，用户通过微信分享给朋友时，会自动显示页面描述
	 * @param string background_color 页面背景颜色 , 如 #fff
	 * @param string body 模板内容，数据格式有要求，具体见《模板数据结构》
	 */
	public function edit()
	{
		if( $this->validate( $this->post, 'Admin/Page.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$page_model = model( 'Page' );
				$data       = [];
				if( isset( $this->post['description'] ) ){
					$data['description'] = $this->post['description'];
				}
				$PageBodyFormat = new PageBodyFormat();
				$page_model->editPage( ['id' => $this->post['id']], [
					'name'             => $this->post['name'],
					'description'      => $this->post['description'],
					'background_color' => $this->post['background_color'],
					'body'             => $PageBodyFormat->formatBody( $this->post['body'] ),
					'is_system'        => 0,
					'module'           => $this->post['module'] ? $this->post['module'] : 'wechat_mini',
				] );
				$this->send( Code::success );
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	public function info()
	{
        $page_model     = model('Page');
        $info           = $page_model->getPageInfo(['id' => $this->get['id']]);
        $pageGoodsLogic = new PageGoodsLogic();
        $info['body']   = $pageGoodsLogic->filterGoods($info['body']);
		$this->send( Code::success, ['info' => $info] );
	}

	/**
	 * 设为首页
	 * @method POST
	 * @param int $id
	 * @author 韩文博
	 */
	public function setPortal()
	{
		if( $this->validate( $this->post, 'Admin/Page.setPortal' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{

			$page_model = model( 'Page' );
			$info       = $page_model->getPageInfo( ['id' => $this->post['id']], 'module' );
			$page_model->editPage( ['module' => $info['module']], ['is_portal' => 0] );
			$page_model->editPage( ['id' => $this->post['id']], ['is_portal' => 1] );
			$this->send( Code::success );
		}
	}
}