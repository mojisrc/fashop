<?php
/**
 * 优惠券
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

class Voucher extends Server {

	public function __construct() {


	}
	/**
	 * 某店优惠券模板
	 * @method GET
	 * @author 韩文博
	 */
	public function getVoucherTemplateList() {
		$get  = $this->get;
		$list = array();
		$d    = model('VoucherTemplate');
		$list = $d->alias('template')
			->where(array('template.end_date' => array('gt', time()), 'template.state' => 1))
			->field('template.*,(SELECT count(*) FROM ' . config('database.prefix') . 'coupon WHERE template_id = template.id) as receive_times,
            (SELECT count(*) FROM ' . config('database.prefix') . 'coupon WHERE template_id = template.id AND owner_id ' . ($this->user['id'] ? '= ' : '<> ') . $this->user['id'] . ') as receive_state
            ')
			->select();
		return $this->faJson(array('list' => $list), 0);
	}
	/**
	 * 某人的优惠券
	 * @method GET
	 * @author 韩文博
	 */
	public function getUserVoucherList() {
		$this->checkLogin();

		$get  = $this->get;
		$list = array();
		$d    = model('Voucher');
		$list = $d->alias('coupon')
			->where(array('owner_id' => $this->user['id']))
			->field('coupon.*')
			->select();
		return $this->faJson(array('list' => $list), 0);
	}
	/**
	 * 领取优惠券
	 * @method GET
	 * @param $template_id 优惠券模板id
	 * @author 韩文博
	 */
	public function receiveVoucher() {
		$this->checkLogin();
		// 不可领取自己的
		$get         = $this->get;
		$template_id = $get['template_id'];
		$model       = model('Voucher');
		// 判断是否有该模板，是否已经超过了领取次数
		$template = $model->getUserTemplateVoucher($template_id, $this->user['id']);
		if (empty($template)) {
			return $this->faJson(['errmsg' => '没有该优惠券'], -1);
		}

		if ($template['receive_times'] >= $template['each_limit']) {
			return $this->faJson(['errmsg' => '该优惠券只可以领' . $template['each_limit'] . '张，您已经领过了'], -1);
		}

		if ($template['total'] == $template['give_out']) {
			return $this->faJson(['errmsg' => '已被领完'], -1);
		}

		// 添加到优惠券表 get_code
		$data = array(
			'code'        => $model->getCode(),
			'template_id' => $template['id'],
			'title'       => $template['title'],
			'desc'        => $template['desc'],
			'start_date'  => $template['start_date'],
			'end_date'    => $template['end_date'],
			'price'       => $template['price'],
			'limit'       => $template['limit'],
			'state'       => 1,
			'owner_id'    => $this->user['id'],
			'owner_name'  => $this->user['nickname'],
		);
		$result = $model->addVoucher($data);
		if ($result) {
			return $this->faJson(array(), 0);
		} else {
			return $this->faJson(['errmsg' => '领取失败'], -1);
		}
	}
	/**
	 * 个人中心优惠券
	 * @method GET
	 * @param  [int] $state，不传为全部 优惠券状态(1-未用,2-已用,3-过期)[非必填]
	 * @author 韩文博
	 */
	public function userVoucherList() {
		$this->checkLogin();
		$get                   = $this->get;
		$model                 = model('Voucher');
		$condition             = array();
		$condition['owner_id'] = $this->user['id'];

		// 设置过期优惠券
		$model->checkExpired();
		if (isset($get['state'])) {
			switch ($get['state']) {
			case 1:
				$condition['state'] = 1;
				break;
			case 2:
				$condition['state'] = 2;
				break;
			case 3:
				$condition['state'] = 3;
				break;
			default:
				break;
			}
		}

		$count      = $model->where($condition)->count();
		$page_class = new Page($count, $get['rows'] ? $get['rows'] : config('db_setting.api_default_rows'));
		$list       = $model->getVoucherList($condition, '*', 'state asc ,id desc', $page_class->currentPage . ',' . $page_class->listRows);
		return $this->faJson(['page_data' => $page_class->httpShow(), 'list' => $list], 0);
	}
}
