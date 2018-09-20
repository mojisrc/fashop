<?php
/**
 * 预存款管理
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
use ezswoole\Lang;

/**
 * 提现
 * Class Pdcash
 * @package App\HttpController\Admin
 */
class Pdcash extends Admin {
	const EXPORT_SIZE = 1000;
	public function _initialize() {
		parent::_initialize();
		Lang::load(APP_PATH . 'admin/lang/zh-cn/pdrecharge.php');
	}

	/**
	 * 提现列表
	 * @datetime 2017-04-20T19:49:00+0800
	 * @author 韩文博
	 */
	public function index() {
		$get = $this->get;
		$condition      = array();
		$if_start_date  = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['stime']);
		$if_end_date    = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['etime']);
		$start_unixtime = $if_start_date ? strtotime($get['stime']) : null;
		$end_unixtime   = $if_end_date ? strtotime($get['etime']) : null;
		if ($start_unixtime || $end_unixtime) {
			$condition['create_time'] = array('between', array($start_unixtime, $end_unixtime));
		}
		if (!empty($get['username'])) {
			$condition['username'] = $get['username'];
		}
		if (!empty($get['bank_user'])) {
			$condition['bank_user'] = $get['bank_user'];
		}
		if ($get['paystate_search'] != '') {
			$condition['payment_state'] = $get['paystate_search'];
		}

		$pd_model       = model('PdCash');
		$count          = $pd_model->where($condition)->count();
		$field          = '*';
		$order          = 'payment_state asc,id asc';
		$list      = $pd_model->getPdCashList($condition, $field, $order, $this->getPageLimit());

		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);
	}

	/**
	 * 删除提现记录
	 * @datetime 2017-04-20T19:49:07+0800
	 * @author 韩文博
	 */
	public function del() {
		$id = intval($get["id"]);
		if ($id <= 0) {
			return $this->send(lang('admin_predeposit_parameter_error'), url('Pdcash/index'));
		}
		$pd_model                   = model('PdCash');
		$condition                  = array();
		$condition['id']            = $id;
		$condition['payment_state'] = 0;
		$info                       = $pd_model->getPdCashInfo($condition);
		if (!$info) {
			return $this->send( Code::param_error );
		}
		try {
			$result = $pd_model->delPdCash($condition);
			if (!$result) {
				throw new \Exception(lang('admin_predeposit_cash_del_fail'));
			}
			//退还冻结的预存款
			$model_user = model('User');
			$user_info  = $model_user->infouser(array('id' => $info['user_id']));
			//扣除冻结的预存款
			$data               = array();
			$data['user_id']    = $user_info['user_id'];
			$data['username']   = $user_info['username'];
			$data['amount']     = $info['amount'];
			$data['order_sn']   = $info['sn'];
			$data['admin_name'] = $this->user['username'];
			$pd_model->changePd('cash_del', $data);
			$pd_model->commit();
			return $this->send( Code::success );

		} catch (\Exception $e) {
			$pd_model->commit();
			return $this->send( Code::error, [], $e->getMessage() );
		}
	}

	/**
	 * 更改提现为支付状态
	 * @datetime 2017-04-20T19:49:18+0800
	 * @author 韩文博
	 */
	public function pay() {
		$id = intval($get['id']);
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}
		$pd_model                   = model('PdCash');
		$condition                  = array();
		$condition['id']            = $id;
		$condition['payment_state'] = 0;
		$info                       = $pd_model->getPdCashInfo($condition);
		if (!is_array($info) || count($info) < 0) {
			return $this->send( Code::param_error );
		}

		//查询用户信息
		$model_user = model('User');
		$user_info  = $model_user->infouser(array('id' => $info['user_id']));

		$update                  = array();
		$update['payment_state'] = 1;
		$update['payment_admin'] = $this->user['username'];
		$update['payment_time']  = time();
		$log_msg                 = lang('admin_predeposit_cash_edit_state') . ',' . lang('admin_predeposit_cs_sn') . ':' . $info['sn'];

		try {
			$pd_model->startTrans();
			$result = $pd_model->editPdCash($update, $condition);
			if (!$result) {
				throw new \Exception(lang('admin_predeposit_cash_edit_fail'));
			}
			//扣除冻结的预存款
			$data               = array();
			$data['user_id']    = $user_info['id'];
			$data['username']   = $user_info['username'];
			$data['amount']     = $info['amount'];
			$data['order_sn']   = $info['sn'];
			$data['admin_name'] = $this->user['username'];
			$pd_model->changePd('cash_pay', $data);
			$pd_model->commit();
			trace($log_msg, 'debug');
			return $this->send( Code::success );
		} catch (\Exception $e) {
			$pd_model->rollback();
			trace($log_msg, 'debug');
			return $this->send( Code::error, [], $e->getMessage() );
		}
	}

	/**
	 * 查看提现信息
	 * @datetime 2017-04-20T19:49:28+0800
	 * @author 韩文博
	 */
	public function detail() {
		$id = intval(input('get.id'));
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}
		$pd_model        = model('PdCash');
		$condition       = array();
		$condition['id'] = $id;
		$row            = $pd_model->getPdCashInfo($condition);
		if (!is_array($row) || count($row) < 0) {
			return $this->send( Code::param_error );
		}
		$result                        = [];
		$result['info']  = $row;
		return $this->send( Code::success, $result );
	}

	/**
	 * 更改支付状态 提现
	 * @return [type] [description]
	 */
	public function pdcashpay() {

	}
}