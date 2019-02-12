<?php
/**
 *
 * 物流管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 物流公司
 * Class Express
 * @package App\HttpController\Admin
 */
class Express extends Admin
{
	/**
	 * 添加物流公司
	 * @method POST
	 * @param string $company_name    公司名称
	 * @param string $is_commonly_use 是否为常用
	 */
	public function add()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Express.add' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$express_id = \App\Model\Express::init()->addExpress( $post );
			if( $express_id ){
				if( $this->post['is_commonly_use'] === 1 ){
					\App\Model\Express::init()->editExpress( ['id' => ['neq', $express_id]], ['is_commonly_use' => 0] );
				}
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 编辑物流公司
	 * @method POST
	 * @param int id $express表ID
	 * @param string $company_name    公司名称
	 * @param string $is_commonly_use 是否为常用
	 */
	public function edit()
	{
		$error = $this->validator( $this->post, 'Admin/Express.edit' );
		if( $error !== true ){
			$this->send( Code::error, [], $error );
		} else{
			\App\Model\Express::init()->editExpress( ['id' => $this->post['id']], $this->post );
			if( $this->post['is_commonly_use'] === 1 ){
				\App\Model\Express::init()->editExpress( ['id' => ['neq', $this->post['id']]], ['is_commonly_use' => 0] );
			} else{
				$this->send( Code::success, [], '修改成功' );
			}
		}
	}

	/**
	 * 设置为常用物流状态
	 * @method POST
	 * @param int id $express表ID
	 */
	public function setCommonlyUse()
	{
		if( $this->validator( $this->post, 'Admin/Express.set' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidator()->getError() );
		} else{
			$find = \App\Model\Express::init()->getExpressInfo( ['id' => $this->post['id']], 'id' );
			if( !$find ){
				$this->send( Code::param_error );
			} else{
				$result = \App\Model\Express::init()->editExpress( ['id' => $this->post['id']], ['is_commonly_use' => 1] );
				if( $result ){
					\App\Model\Express::init()->editExpress( ['id' => ['neq', $this->post['id']]], ['is_commonly_use' => 0] );
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			}
		}
	}

	/**
	 * 物流公司列表
	 * @method GET
	 * @param string $keywords_type 关键词类型 company_name kuaidi100_code taobao_code（taobao_code这个先废弃 ）
	 * @param string $keywords      关键词
	 */
	public function list()
	{
		$condition = [];
		// 搜索条件：公司名称[company_name] 快递100Code[kuaidi100_code] 淘宝Code[taobao_code]
		if( isset( $this->get['keywords_type'] ) && isset( $this->get['keywords'] ) ){
			switch( $this->get['keywords_type'] ){
			case 'company_name':
				$condition['company_name'] = ['like', '%'.$this->get['company_name'].'%'];
			break;
			case 'kuaidi100_code':
				$condition['kuaidi100_code'] = ['like', '%'.$this->get['kuaidi100_code'].'%'];
			break;
			case 'taobao_code':
				$condition['taobao_code'] = ['like', '%'.$this->get['taobao_code'].'%'];
			break;
			}
		}
		$expressModel = new \App\Model\Express;
		$list         = $expressModel->getExpressList( $condition, '*', 'is_commonly_use desc,id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $expressModel->count(),
			'list'         => $list,
		] );
	}

	/**
	 * 物流信息
	 * @method GET
	 * @param int $id
	 */
	public function info()
	{
		$info = \App\Model\Express::getExpressInfo( ['id' => $this->get['id']] );
		$this->send( Code::success, ['info' => $info] );
	}

	/**
	 * 删除物流公司
	 * @method POST
	 * @param int id $express表ID
	 */
	public function del()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Express.del' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$condition       = [];
			$condition['id'] = $post['id'];

			$row = \App\Model\Express::getExpressInfo( $condition, '*' );
			if( !$row ){
				return $this->send( Code::param_error );
			}
			//系统级 默认0自定义 1系统
			if( $row['is_system'] == 1 ){
				return $this->send( Code::param_error, [], '系统数据，不可删除' );
			}
			$result = \App\Model\Express::delExpress( $condition );
			if( !$result ){
				return $this->send( Code::error );
			}
			return $this->send( Code::success );
		}
	}
}