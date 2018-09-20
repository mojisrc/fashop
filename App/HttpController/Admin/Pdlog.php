<?php
/**
 * 预存款明细管理(Log)
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
 * 提现日志
 * Class Pdlog
 * @package App\HttpController\Admin
 */
class Pdlog extends Admin {
	const EXPORT_SIZE = 1000;
	public function _initialize() {
		parent::_initialize();
		Lang::load(APP_PATH . 'admin/lang/zh-cn/pdrecharge.php');
	}
	/**
	 * 预存款日志
	 * @datetime 2017-04-20T19:48:51+0800
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
		if (!empty($get['aname'])) {
			$condition['admin_name'] = $get['aname'];
		}
		$pd_model       = model('PdLog');
		$count          = $pd_model->where($condition)->count();
		$field          = '*';
		$order          = 'id desc';
		$list           = $pd_model->getPdLogList($condition, $field, $order, $this->getPageLimit());

		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);

	}

}