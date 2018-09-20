<?php
/**
 * 预存款
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\HttpController\Server;

use App\Utils\Code;

class Pdrecharge extends Server {

	/**
	 * 预存款充值面额列表
	 * @method     GET
	 * @datetime 2017-06-20T23:39:55+0800
	 * @author 韩文博
	 */
	public function pdrechargeDenominationList() {
		$list =  [
			['title' => "冲1000元", 'desc' => "送80优惠券", "price" => 1000],
			['title' => "冲2000元", 'desc' => "送200优惠券", "price" => 2000],
		];

		$this->send( Code::success, [
			'list' => $list,
		] );

	}
	/**
	 * 充值添加
	 * @method POST
	 * @param $amount 充值金额
	 * @author 韩文博
	 */
	public function pdrAdd() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			$post   = $this->post;
			$amount = abs(floatval($post['amount']));

			if ($amount <= 0) {
				$this->send( Code::param_error, [], lang('predeposit_recharge_add_pricemin_error') );

			}else{
				try{
					$user                = $this->getRequestUser();
					$pd_model            = model('PdRecharge');
					$pd_log_model        = model('PdLog');
					$pd_model->startTrans();
					$data                = array();
					$data['sn']          = $pay_sn          = $pd_model->makeSn($user['id']);
					$data['user_id']     = $user['id'];
					$data['username']    = $user['username'];
					$data['amount']      = $amount;
					$data['create_time'] = time();
					$pd_id               = $pd_model->addPdRecharge($data);
					if (!$pd_id) {
						$pd_model->rollback();
						$this->send( Code::param_error, [], '充值失败' );

					}else{
						//添加log
						$log_data               = array();
						$log_data['pd_id']      = $pd_id;
						$log_data['pd_sn']      = $data['sn'];
						$log_data['user_id']    = $user['id'];
						$log_data['username']   = $user['username'];
						$log_data['amount']     = $data['amount'];
						$log_data['admin_name'] = 'admin';
						$log_data['state']      = 0;
						$pd_log_model->changePd('recharge', $log_data);

						$pd_model->commit();

						$this->send( Code::success, ['info' => array('pay_sn' => $pay_sn)] );

					}

				} catch( \Exception $e ){
					$this->send( Code::server_error, [], $e->getMessage() );
				}
			}
		}

	}

	/**
	 * 充值列表
	 * @method GET
	 * @author 韩文博
	 */
	public function pdrList() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user                 = $this->getRequestUser();
				$get                  = $this->get;
				$condition            = array();
				$condition['user_id'] = $user['id'];

				if (isset($get['sn'])) {
					$condition['sn'] = $get['sn'];
				}

				$pd_model = model('PdRecharge');
				$count    = $pd_model->where($condition)->count();
				$list     = $pd_model->getPdRechargeList($condition, '*', 'id desc', $this->getPageLimit());

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => $list
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 查看充值详细
	 * @method GET
	 * @param $id 记录id
	 * @author 韩文博
	 */
	public function pdrDetail() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user = $this->getRequestUser();
				$get  = $this->get;
				$id   = intval($get['id']);
				if ($id <= 0) {
					$this->send( Code::param_error, []);

				}else {
					$pd_model                   = model('PdRecharge');
					$condition                  = array();
					$condition['user_id']       = $user['id'];
					$condition['id']            = $id;
					$condition['payment_state'] = 1; //支付状态 0未支付1支付

					$info                       = $pd_model->getPdRechargeInfo($condition);

					if( !$info ){
						$this->send( Code::param_error, [] );
					} else{
						$this->send( Code::success, ['info' => $info] );
					}
				}

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 删除充值记录
	 * @method POST
	 * @param $id 记录id
	 * @author 韩文博
	 */
	public function pdrDel() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user = $this->getRequestUser();
				$post = $this->post;
				$id   = intval($post['id']);
				if ($id <= 0) {
					$this->send( Code::param_error, []);

				}else {
					$pd_model             = model('PdRecharge');
					$condition            = array();
					$condition['user_id'] = $user['id'];
					$condition['id']      = $id;
					$result               = $pd_model->softDelPdRecharge($condition);

					if( !$result ){
						$this->send( Code::param_error, [] );
					} else{
						$this->send( Code::success, [] );
					}
				}

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 预存款变更日志
	 * @method GET
	 * @author 韩文博
	 */
	public function pdLogList() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user                 = $this->getRequestUser();
				$get                  = $this->get;
				$condition            = array();
				$pd_model             = model('PdLog');
				$condition            = array();
				$condition['user_id'] = $user['id'];
				$count                = $pd_model->where($condition)->count();
				$list                 = $pd_model->getPdLogList($condition, '*', 'id desc', $this->getPageLimit());

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => $list
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 申请提现
	 * @method POST
	 * @param $amount 额度
	 * @param $bank_name 银行名字
	 * @param $bank_no 账号
	 * @param $bank_user 开户名
	 * @author 韩文博
	 */
	public function pdCashAdd() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			if( $this->validate( $this->post, 'Server/Pdrecharge.pdCashAdd' ) !== true ){
				$this->send( Code::param_error, [], $this->getValidate()->getError() );

			}else{
				$pd_model                     = model('PdRecharge');
				$pd_log_model                 = model('PdLog');
				$pd_cash_model                = model('PdCash');
				$user                         = $this->getRequestUser();
				$user['available_predeposit'] = model( 'User' )->getUserValue( ['id' => $user['id']], 'available_predeposit' );

				$post                         = $this->post;
				$amount                       = abs(floatval($post['amount']));

				if (floatval($user['available_predeposit']) < $amount) {
					$this->send( Code::param_error, [], lang('predeposit_cash_shortprice_error') );

				}else{

					try{
						$pd_model->startTrans();
						$sn                    = $pd_model->makeSn($user['id']);
						$data                  = array();
						$data['sn']            = $sn;
						$data['user_id']       = $user['id'];
						$data['username']      = $user['username'];
						$data['amount']        = $amount;
						$data['bank_name']     = $post['bank_name'];
						$data['bank_no']       = $post['bank_no'];
						$data['bank_user']     = $post['bank_user'];
						$data['create_time']   = time();
						$data['payment_state'] = 0;
						$insert                = $pd_cash_model->addPdCash($data);
						if (!$insert) {
							throw new \Exception(lang('predeposit_cash_add_fail'));
						}

						//冻结可用预存款
						$log_data               = array();
						$log_data['pd_id']      = $insert;
						$log_data['pd_sn']      = $sn;
						$log_data['user_id']    = $user['id'];
						$log_data['username']   = $user['username'];
						$log_data['amount']     = $amount;
						$log_data['admin_name'] = 'admin';
						$log_data['state']      = 0;
						$pd_log_model->changePd('cash_apply', $log_data);

						$pd_model->commit();
						$this->send( Code::success, [] );

					} catch( \Exception $e ){

						$pd_model->rollback();

						$this->send( Code::server_error, [], $e->getMessage() );
					}
				}
			}
		}
	}

	/**
	 * 提现列表
	 * @method GET
	 * @param $sn 交易码
	 * @param $payment_state 交易状态[非必填]
	 * @author 韩文博
	 */
	public function pdcash() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user = $this->getRequestUser();
				$get  = $this->get;
				$id   = intval($get['id']);

				$pd_model 			  = model('PdCash');
				$condition            = array();
				$condition['user_id'] = $user['id'];

				if (isset($get['sn'])) {
					$condition['sn'] = $get['sn'];
				}

				if (isset($get['payment_state'])) {
					$condition['payment_state'] = intval($get['payment_state']);
				}

				$count = $pd_model->where($condition)->count();
				$list  = $pd_model->getPdCashList($condition, '*', 'id desc', $page);

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => $list
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 提现记录详细
	 * @method GET
	 * @param $id 记录id
	 * @author 韩文博
	 */
	public function pdCashInfo() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user = $this->getRequestUser();
				$get  = $this->get;
				$id   = intval($get['id']);
				if ($id <= 0) {
					$this->send( Code::param_error, []);

				}else {
					$pd_model             = model('PdCash');
					$condition            = array();
					$condition['user_id'] = $user['id'];
					$condition['id']      = $id;
					$info                 = $pd_model->getPdCashInfo($condition);

					if( !$info ){
						$this->send( Code::param_error, [] );
					} else{
						$this->send( Code::success, ['info' => $info] );
					}
				}

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}
}
