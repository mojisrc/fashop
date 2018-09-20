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
 * 预存款
 * Class Pdrecharge
 * @package App\HttpController\Admin
 */
class Pdrecharge extends Admin {
	const EXPORT_SIZE = 1000;
	public function _initialize() {
		parent::_initialize();
		Lang::load(APP_PATH . 'admin/lang/zh-cn/pdrecharge.php');
	}
	/**
	 * 充值列表
	 * @datetime 2017-04-20T19:48:17+0800
	 * @author 韩文博
	 */
	public function index() {
		$get = $this->get;
		$condition      = array();
		$if_start_date  = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['query_start_date']);
		$if_end_date    = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($get['query_start_date']) : null;
		$end_unixtime   = $if_end_date ? strtotime($get['query_end_date']) : null;
		if ($start_unixtime || $end_unixtime) {
			$condition['create_time'] = array('BETWEEN', array($start_unixtime, $end_unixtime));
		}
		if (!empty($get['username'])) {
			$condition['username'] = $get['username'];
		}
		if ($get['payment_state'] != '') {
			$condition['payment_state'] = $get['payment_state'];
		}
		$pd_model      = model('PdRecharge');
		$count         = $pd_model->getPdRechargeCount($condition);
		$field         = '*';
		$order         = 'id desc';
		$list = $pd_model->getPdRechargeList($condition, $field, $order, $this->getPageLimit());
		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);
	}

	/**
	 * 充值编辑(更改成收到款)
	 * @datetime 2017-04-20T19:48:27+0800
	 * @author 韩文博
	 */
	public function edit() {
		$id = intval($get['id']);
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}
		//查询充值信息
		$pd_model                   = model('PdRecharge');
		$condition                  = array();
		$condition['id']            = $id;
		$condition['payment_state'] = 0;
		$info                       = $pd_model->getPdRechargeInfo($condition);
		if (empty($info)) {
			return $this->send( Code::param_error );
		}
		if (!$this->post) {
			//显示支付接口列表
			$payment_list = model('Payment')->getPaymentOpenList();
			//去掉预存款和货到付款
			foreach ($payment_list as $key => $value) {
				if ($value['payment_code'] == 'predeposit' || $value['payment_code'] == 'offline') {
					unset($payment_list[$key]);
				}
			}
			$result['payment_list'] = $payment_list;
			$result['info']         = $info;
			$this->assign('row', $result);
			return $this->send();
		}

		//取支付方式信息
		$payment_model             = model('Payment');
		$condition                 = array();
		$condition['payment_code'] = $_POST['payment_code'];
		$payment_info              = $payment_model->getPaymentOpenInfo($condition);
		if (!$payment_info || $payment_info['code'] == 'offline' || $payment_info['code'] == 'offline') {
			return $this->send( Code::param_error );

		}

		$condition                  = array();
		$condition['sn']            = $info['sn'];
		$condition['payment_state'] = 0;
		$update                     = array();
		$update['payment_state']    = 1;
		$update['payment_time']     = strtotime($_POST['payment_time']);
		$update['payment_code']     = $payment_info['code'];
		$update['payment_name']     = $payment_info['name'];
		$update['trace_sn']         = $_POST['trace_no'];
		$update['admin']            = $this->user['username'];
		$log_msg                    = lang('admin_predeposit_recharge_edit_state') . ',' . lang('admin_predeposit_sn') . ':' . $info['sn'];
		try {
			$pd_model->startTrans();
			//更改充值状态
			$state = $pd_model->editPdRecharge($update, $condition);

			if (!$state) {
				throw \Exception(lang('predeposit_payment_pay_fail'));
			}
			//变更会员预存款
			$data               = array();
			$data['user_id']    = $info['user_id'];
			$data['username']   = $info['username'];
			$data['amount']     = $info['amount'];
			$data['sn']         = $info['sn'];
			$data['admin_name'] = $this->user['username'];
			$pd_model->changePd('recharge', $data);
			$pd_model->commit();
			trace($log_msg, 'debug');
			return $this->send( Code::success );
		} catch (\Exception $e) {
			trace($log_msg, 'debug');
			$pd_model->rollback();
			return $this->send( Code::error, [], $e->getMessage() );
		}
	}

	/**
	 * 充值查看
	 * @datetime 2017-04-20T19:48:36+0800
	 * @author 韩文博
	 */
	public function detail() {
		$id = intval($get['id']);
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}
		//查询充值信息
		$pd_model        = model('PdRecharge');
		$condition       = array();
		$condition['id'] = $id;
		$row            = $pd_model->getPdRechargeInfo($condition);
		if (empty($row)) {
			return $this->send( Code::param_error );
		}
		$result                        = [];
		$result['info']  = $row;
		return $this->send( Code::success, $result );
	}

	/**
	 * 充值删除
	 * @datetime 2017-04-20T19:48:44+0800
	 * @author 韩文博
	 */
	public function del() {
		$get = $this->get;
		$id = intval($get['id']);
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}
		$pd_model                   = model('PdRecharge');
		$condition                  = array();
		$condition['id']            = $id;
		$condition['payment_state'] = 0;
		$result                     = $pd_model->delPdRecharge($condition);
		if ($result) {
			return $this->send( Code::success );
		} else {
			return $this->send( Code::error );
		}
	}

/********************************************************************************** 导出功能 暂时没用 *****************************************************/

	/**
	 * 导出预存款充值记录
	 *
	 */
	public function export_step1() {
		$condition      = array();
		$if_start_date  = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['query_start_date']);
		$if_end_date    = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['query_end_date']);
		$start_unixtime = $if_start_date ? strtotime($get['query_start_date']) : null;
		$end_unixtime   = $if_end_date ? strtotime($get['query_end_date']) : null;
		if ($start_unixtime || $end_unixtime) {
			$condition['create_time'] = array('time', array($start_unixtime, $end_unixtime));
		}
		if (!empty($get['mname'])) {
			$condition['username'] = $get['mname'];
		}
		if ($get['paystate_search'] != '') {
			$condition['payment_state'] = $get['paystate_search'];
		}
		$pd_model = model('PdRecharge');
		if (!is_numeric($get['curpage'])) {
			$count = $pd_model->getPdRechargeCount($condition);
			$array = array();
			if ($count > self::EXPORT_SIZE) {
				//显示下载链接
				$page = ceil($count / self::EXPORT_SIZE);
				for ($i = 1; $i <= $page; $i++) {
					$limit1    = ($i - 1) * self::EXPORT_SIZE + 1;
					$limit2    = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
					$array[$i] = $limit1 . ' ~ ' . $limit2;
				}
				$result['list'] = $array;
				$result['murl'] = url('index');
				$this->send('export.excel');
			} else {
				//如果数量小，直接下载
				$data             = $pd_model->getPdRechargeList($condition, '', '*', 'id desc', self::EXPORT_SIZE);
				$rechargepaystate = array(0 => '未支付', 1 => '已支付');
				foreach ($data as $k => $v) {
					$data[$k]['payment_state'] = $rechargepaystate[$v['payment_state']];
				}
				$this->createExcel($data);
			}
		} else {
			//下载
			$limit1           = ($get['curpage'] - 1) * self::EXPORT_SIZE;
			$limit2           = self::EXPORT_SIZE;
			$data             = $pd_model->getPdRechargeList($condition, '', '*', 'id desc', "{$limit1},{$limit2}");
			$rechargepaystate = array(0 => '未支付', 1 => '已支付');
			foreach ($data as $k => $v) {
				$data[$k]['payment_state'] = $rechargepaystate[$v['payment_state']];
			}
			$this->createExcel($data);
		}
	}

	/**
	 * 生成导出预存款充值excel
	 *
	 * @param array $data
	 */
	private function createExcel($data = array()) {
		Language::read('export');
		import('libraries.excel');
		$excel_obj  = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
		//header
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_no'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_user'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_ctime'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_ptime'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_pay'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_money'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_paystate'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_yc_userid'));
		foreach ((array) $data as $k => $v) {
			$tmp   = array();
			$tmp[] = array('data' => 'NC' . $v['sn']);
			$tmp[] = array('data' => $v['username']);
			$tmp[] = array('data' => date('Y-m-d H:i:s', $v['create_time']));
			if (intval($v['payment_time'])) {
				if (date('His', $v['payment_time']) == 0) {
					$tmp[] = array('data' => date('Y-m-d', $v['payment_time']));
				} else {
					$tmp[] = array('data' => date('Y-m-d H:i:s', $v['payment_time']));
				}
			} else {
				$tmp[] = array('data' => '');
			}
			$tmp[]        = array('data' => $v['payment_name']);
			$tmp[]        = array('format' => 'Number', 'data' => ncPriceFormat($v['amount']));
			$tmp[]        = array('data' => $v['payment_state']);
			$tmp[]        = array('data' => $v['user_id']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data, CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(lang('exp_yc_yckcz'), CHARSET));
		$excel_obj->generateXML($excel_obj->charset(lang('exp_yc_yckcz'), CHARSET) . $get['curpage'] . '-' . date('Y-m-d-H', time()));
	}

	/**
	 * 导出预存款提现记录
	 *
	 */
	public function export_cash_step1() {
		$condition      = array();
		$if_start_date  = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['stime']);
		$if_end_date    = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['etime']);
		$start_unixtime = $if_start_date ? strtotime($get['stime']) : null;
		$end_unixtime   = $if_end_date ? strtotime($get['etime']) : null;
		if ($start_unixtime || $end_unixtime) {
			$condition['create_time'] = array('time', array($start_unixtime, $end_unixtime));
		}
		if (!empty($get['mname'])) {
			$condition['username'] = $get['mname'];
		}
		if (!empty($get['bank_user'])) {
			$condition['bank_user'] = $get['bank_user'];
		}
		if ($get['paystate_search'] != '') {
			$condition['payment_state'] = $get['paystate_search'];
		}

		$pd_model = model('PdRecharge');

		if (!is_numeric($get['curpage'])) {
			$count = $pd_model->getPdCashCount($condition);
			$array = array();
			if ($count > self::EXPORT_SIZE) {
				//显示下载链接
				$page = ceil($count / self::EXPORT_SIZE);
				for ($i = 1; $i <= $page; $i++) {
					$limit1    = ($i - 1) * self::EXPORT_SIZE + 1;
					$limit2    = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
					$array[$i] = $limit1 . ' ~ ' . $limit2;
				}
				$result['list'] = $array;
				$result['murl'] = url('Pdcash/index');
				$this->send('export.excel');
			} else {
				//如果数量小，直接下载
				$data         = $pd_model->getPdCashList($condition, '', '*', 'id desc', self::EXPORT_SIZE);
				$cashpaystate = array(0 => '未支付', 1 => '已支付');
				foreach ($data as $k => $v) {
					$data[$k]['payment_state'] = $cashpaystate[$v['payment_state']];
				}
				$this->createCashExcel($data);
			}
		} else {
			//下载
			$limit1       = ($get['curpage'] - 1) * self::EXPORT_SIZE;
			$limit2       = self::EXPORT_SIZE;
			$data         = $pd_model->getPdCashList($condition, '', '*', 'id desc', "{$limit1},{$limit2}");
			$cashpaystate = array(0 => '未支付', 1 => '已支付');
			foreach ($data as $k => $v) {
				$data[$k]['payment_state'] = $cashpaystate[$v['payment_state']];
			}
			$this->createCashExcel($data);
		}
	}

	/**
	 * 生成导出预存款提现excel
	 *
	 * @param array $data
	 */
	private function createCashExcel($data = array()) {
		Language::read('export');
		import('libraries.excel');
		$excel_obj  = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
		//header
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_no'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_user'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_money'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_ctime'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_state'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_tx_userid'));
		foreach ((array) $data as $k => $v) {
			$tmp          = array();
			$tmp[]        = array('data' => 'NC' . $v['sn']);
			$tmp[]        = array('data' => $v['username']);
			$tmp[]        = array('format' => 'Number', 'data' => ncPriceFormat($v['amount']));
			$tmp[]        = array('data' => date('Y-m-d H:i:s', $v['create_time']));
			$tmp[]        = array('data' => $v['payment_state']);
			$tmp[]        = array('data' => $v['user_id']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data, CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(lang('exp_tx_title'), CHARSET));
		$excel_obj->generateXML($excel_obj->charset(lang('exp_tx_title'), CHARSET) . $get['curpage'] . '-' . date('Y-m-d-H', time()));
	}

	/**
	 * 预存款明细信息导出
	 */
	public function export_mx_step1() {
		$condition      = array();
		$if_start_date  = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['stime']);
		$if_end_date    = preg_match('/^20\d{2}-\d{2}-\d{2}$/', $get['etime']);
		$start_unixtime = $if_start_date ? strtotime($get['stime']) : null;
		$end_unixtime   = $if_end_date ? strtotime($get['etime']) : null;
		if ($start_unixtime || $end_unixtime) {
			$condition['create_time'] = array('time', array($start_unixtime, $end_unixtime));
		}
		if (!empty($get['mname'])) {
			$condition['username'] = $get['mname'];
		}
		if (!empty($get['aname'])) {
			$condition['admin_name'] = $get['aname'];
		}
		$pd_model = model('PdRecharge');
		if (!is_numeric($get['curpage'])) {
			$count = $pd_model->getPdLogCount($condition);
			$array = array();
			if ($count > self::EXPORT_SIZE) {
				//显示下载链接
				$page = ceil($count / self::EXPORT_SIZE);
				for ($i = 1; $i <= $page; $i++) {
					$limit1    = ($i - 1) * self::EXPORT_SIZE + 1;
					$limit2    = $i * self::EXPORT_SIZE > $count ? $count : $i * self::EXPORT_SIZE;
					$array[$i] = $limit1 . ' ~ ' . $limit2;
				}
				$result['list'] = $array;
				$result['murl'] = 'index.php?act=predeposit&op=pd_log_list';
				$this->send('export.excel');
			} else {
				//如果数量小，直接下载
				$data = $pd_model->getPdLogList($condition, '', '*', 'lg_id desc', self::EXPORT_SIZE);
				$this->createmxExcel($data);
			}
		} else {
			//下载
			$limit1 = ($get['curpage'] - 1) * self::EXPORT_SIZE;
			$limit2 = self::EXPORT_SIZE;
			$data   = $pd_model->getPdLogList($condition, '', '*', 'lg_id desc', "{$limit1},{$limit2}");
			$this->createmxExcel($data);
		}
	}

	/**
	 * 导出预存款明细excel
	 *
	 * @param array $data
	 */
	private function createmxExcel($data = array()) {
		Language::read('export');
		import('libraries.excel');
		$excel_obj  = new Excel();
		$excel_data = array();
		//设置样式
		$excel_obj->setStyle(array('id' => 's_title', 'Font' => array('FontName' => '宋体', 'Size' => '12', 'Bold' => '1')));
		//header
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_user'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_ctime'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_av_money'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_freeze_money'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_system'));
		$excel_data[0][] = array('styleid' => 's_title', 'data' => lang('exp_mx_mshu'));
		foreach ((array) $data as $k => $v) {
			$tmp   = array();
			$tmp[] = array('data' => $v['username']);
			$tmp[] = array('data' => date('Y-m-d H:i:s', $v['create_time']));
			if (floatval($v['available_amount']) == 0) {
				$tmp[] = array('data' => '');
			} else {
				$tmp[] = array('format' => 'Number', 'data' => ncPriceFormat($v['available_amount']));
			}
			if (floatval($v['freeze_amount']) == 0) {
				$tmp[] = array('data' => '');
			} else {
				$tmp[] = array('format' => 'Number', 'data' => ncPriceFormat($v['freeze_amount']));
			}
			$tmp[]        = array('data' => $v['admin_name']);
			$tmp[]        = array('data' => $v['remark']);
			$excel_data[] = $tmp;
		}
		$excel_data = $excel_obj->charset($excel_data, CHARSET);
		$excel_obj->addArray($excel_data);
		$excel_obj->addWorksheet($excel_obj->charset(lang('exp_mx_rz'), CHARSET));
		$excel_obj->generateXML($excel_obj->charset(lang('exp_mx_rz'), CHARSET) . $get['curpage'] . '-' . date('Y-m-d-H', time()));
	}
}