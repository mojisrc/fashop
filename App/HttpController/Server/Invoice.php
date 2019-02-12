<?php
/**
 * 用户发票信息管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

class Invoice extends Server
{


	/**
	 * 买家设置默认发票
	 * @method GET
	 * @param int $id 发票id
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function setDefault()
	{
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user          = $this->getRequestUser();
				$get           = $this->get;
				$invoice_model = model( 'Invoice' );
				// 更改其他为非默认
				$invoice_model->editInvoice( ['user_id' => $this->user['id']], ['is_default' => 0] );

				// 设置默认
				$invoice_model->editInvoice( ['user_id' => $this->user['id'], 'id' => $get['id']], ['is_default' => 1] );

				$this->send( Code::success, [] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 获得默认发票
	 * @method GET
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function getDefault()
	{
		$this->checkLogin();
		$invoice_model = model( 'Invoice' );
		$info          = $invoice_model->getDefaultInvoiceInfo( ['user_id' => $this->user['id']] );
		return $this->faJson( ['data' => $info ? $info : null], 0 );
	}

	/**
	 * 获取发票详情
	 * @method GET
	 * @param int $id 发票id
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function detail()
	{
		$this->checkLogin();
		$invoice_model = model( 'Invoice' );
		$get           = $this->get;
		$info          = $invoice_model->getInvoiceInfo( ['id' => $get['id']] );
		return $this->faJson( ['data' => $info ? $info : null], 0 );
	}

	/**
	 * 买家发票列表
	 * @method GET
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function lists()
	{
		$this->checkLogin();
		$get           = $this->get;
		$invoice_model = model( 'Invoice' );
		$page_class    = new Page( $count, ($get['rows'] > 0 && config( 'db_setting.api_max_rows' ) >= $get['rows']) ? $get['rows'] : config( 'db_setting.api_default_rows' ) );
		$page          = $page_class->currentPage.','.$page_class->listRows;
		$list          = $invoice_model->getInvoiceList( ['user_id' => $this->user['id']], '*', 'id desc', $page );
		return $this->faJson( ['list' => $list ? $list : []], 0 );
	}

	/**
	 * 添加新的发票
	 * @method POST
	 * @param int    $type                           1普通发票 2增值税发票 [必填]
	 * @param int    $title_select_type              抬头类型  1是个人，2公司
	 * @param string $title                          抬头 [title_select_type = 1 非必填，title_select_type = 2 必填] 当title_select_type = 1时默认是个人，title_select_type = 2时是公司
	 * @param string $company_name                   单位名称 [title_select_type = 2 必填]
	 * @param string $company_code                   纳税人识别号 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_address       注册地址 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_phone         注册电话 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_brank_name    开户银行 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_brank_account 银行帐户 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $receive_name                   收票人姓名 [非必填]
	 * @param string $receive_phone                  收票人手机号 [非必填]
	 * @param string $receive_province               收票人省份 [非必填]
	 * @param string $receive_address                送票地址 [非必填]
	 * @param string $consumption_type               发票消费分类 [非必填] 该类型列表由 Invoice/invoiceConsumptionTypeList 接口获得
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function add()
	{
		$this->checkLogin();
		$invoice_model   = model( 'Invoice' );
		$post            = $this->post;
		$post['user_id'] = $this->user['id'];
		if( $post['title_select_type'] == 1 ){
			$post['title'] = '个人';
			if( true !== $validate_result = $this->validate( $post, 'Invoice.title_select_type_1_add' ) ){
				return $this->faJson( ['errmsg' => $validate_result], - 1 );
			}
		} else{
			if( true !== $validate_result = $this->validate( $post, 'Invoice.title_select_type_2_add' ) ){
				return $this->faJson( ['errmsg' => $validate_result], - 1 );
			}
		}

		$insert_id = $invoice_model->addInvoice( $post );
		if( $insert_id ){
			$data['id']    = $insert_id;
			$data['state'] = true;
			return $this->faJson( ['data' => $data], 0 );
		} else{
			return $this->faJson( ['errmsg' => '添加失败'], - 1 );
		}
	}

	/**
	 * 修改发票信息
	 * @method POST
	 * @param id     $id                             发票id [必填]
	 * @param int    $type                           1普通发票 2增值税发票 [必填]
	 * @param int    $title_select_type              抬头类型  1是个人，2公司
	 * @param string $title                          抬头 [title_select_type = 1 非必填，title_select_type = 2 必填] 当title_select_type = 1时默认是个人，title_select_type = 2时是公司
	 * @param string $company_name                   单位名称 [title_select_type = 2 必填]
	 * @param string $company_code                   纳税人识别号 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_address       注册地址 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_phone         注册电话 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_brank_name    开户银行 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $company_register_brank_account 银行帐户 [当为增值税发票时，必填]  todo验证没开发
	 * @param string $receive_name                   收票人姓名 [非必填]
	 * @param string $receive_phone                  收票人手机号 [非必填]
	 * @param string $receive_province               收票人省份 [非必填]
	 * @param string $receive_address                送票地址 [非必填]
	 * @param string $consumption_type               普通发票内容 [非必填] 该类型列表由 Invoice/invoiceConsumptionTypeList 接口获得
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function edit()
	{
		$this->checkLogin();
		$invoice_model = model( 'Invoice' );
		$post          = $this->post;

		if( $post['title_select_type'] == 1 ){
			$post['title'] = '个人';
			if( true !== $validate_result = $this->validate( $post, 'Invoice.title_select_type_1_edit' ) ){
				return $this->faJson( ['errmsg' => $validate_result], - 1 );
			}
		} else{
			$post['title'] = '公司';
			if( true !== $validate_result = $this->validate( $post, 'Invoice.title_select_type_2_edit' ) ){
				return $this->faJson( ['errmsg' => $validate_result], - 1 );
			}
		}

		$data        = $post;
		$save_result = $invoice_model->editInvoice( ['id' => $post['id'], 'user_id' => $this->user['id']], $data );
		if( $save_result ){
			$data['state'] = true;
			return $this->faJson( ['data' => $data], 0 );
		} else{
			return $this->faJson( ['errmsg' => $save_result['error']], - 1 );
		}
	}

	/**
	 * 买家删除发票
	 * @method POST
	 * @param  int $id 发票id
	 * @datetime 2017-05-19T10:48:06+0800
	 */
	public function del()
	{
		$post          = $this->post;
		$invoice_model = model( 'Invoice' );
		if( !empty( $post['id'] ) && intval( $post['id'] ) > 0 ){
			$invoice_model->delInvoice( ['id' => intval( $post['id'] ), 'user_id' => $this->user['id']] );
			return $this->faJson( [], 0 );
		}
	}

	/**
	 * 发票消费类型列表
	 * @method     GET
	 * @datetime 2017-05-18T23:14:34+0800
	 */
	public function invoiceConsumptionTypeList()
	{
		$invoice_content_list = config( 'db_setting.invoice_consumption_type_list' );
		return $this->faJson( ['list' => $invoice_content_list] );
	}
}
