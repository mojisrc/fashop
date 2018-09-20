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
namespace App\HttpController\Admin;
/**
 * 优惠券
 * Class Voucher
 * @package App\HttpController\Admin
 */
class Voucher extends Admin {

	public function _initialize() {
		parent::_initialize();
	}
	/**
	 * 用户优惠券列表
	 * @method     GET
	 * @datetime 2017-06-04T20:37:38+0800
	 * @author 韩文博
	 */
	public function index() {
		$get   = $this->get;
		$model = model('Voucher');
		//查询列表
		$condition = array();

		if (isset($get['start_date'])) {
			$condition['end_date'] = array('egt', strtotime($get['start_date']));
		}
		if (isset($get['end_date'])) {
			$condition['start_date'] = array('elt', strtotime($get['end_date']));
		}
		$count      = $model->where($condition)->count();
		$list       = $model->getVoucherList($condition, '*', 'id desc', $this->getPageLimit());

		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);
	}
	/**
	 * 收回
	 * @datetime 2017-06-04T21:04:15+0800
	 * @author 韩文博
	 */
	public function takeBack() {
		$get        = $this->get;
		$coupon_id = $get['id'];
		if ($coupon_id > 0) {
			$result = model('Voucher')->editVoucher(['id' => $coupon_id], ['state' => 4]);
			return $this->send( Code::success );
		} else {
			return $this->send( Code::param_error );
		}
	}
	/**
	 * 默认操作列出优惠券
	 */
	public function templateList() {
		$get   = $this->get;
		$model = model('VoucherTemplate');
		//查询列表
		$condition = array();
		if (trim($get['title'])) {
			$condition['title'] = array('like', "%{$get['title']}%");
		}
		$state = intval($get['state']);
		if ($state) {
			$condition['state'] = $state;
		}
		if ($get['start_date']) {
			$condition['end_date'] = array('egt', strtotime($get['start_date']));
		}
		if ($get['end_date']) {
			$condition['start_date'] = array('elt', strtotime($get['end_date']));
		}
		$count      = $model->where($condition)->count();
		$list       = $model->getVoucherTemplateList($condition, '*', 'id desc', $this->getPageLimit());
		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);
	}
	/**
	 * 优惠券模版添加
	 * @datetime 2017-06-04T11:53:25+0800
	 * @author 韩文博
	 */
	public function templateAdd() {
		if ($this->post) {
			$post = $this->post;

			$result = $this->validate($post, 'Admin/VoucherTemplate.add');
			if (true !== $result) {
				return $this->send($result);
			}
			//金额验证
			$price = intval($post['price']) > 0 ? intval($post['price']) : 0;
			$limit = intval($post['limit']) > 0 ? intval($post['limit']) : 0;
			if ($price >= $limit) {
				return $this->send(lang('coupon_price_error'));
			}
			$model               = model('VoucherTemplate');
			$data                = $post;
			$data['price']       = $price;
			$data['limit']       = $limit;
			$data['start_date']  = time();
			$data['end_date']    = strtotime($post['end_date']);
			$data['creator_id']  = $this->user['id'];
			$data['state']       = 1;
			$data['total']       = intval($post['total']) > 0 ? intval($post['total']) : 0;
			$data['give_out']    = 0;
			$data['used']        = 0;
			$data['create_time'] = time();
			$data['each_limit']  = intval($post['each_limit']) > 0 ? intval($post['each_limit']) : 0;
			$resutl              = $model->addVoucherTemplate($data);
			if ($resutl) {
				return $this->send( Code::success );

			} else {
				return $this->send( Code::error );
			}
		} else {
			return $this->send( Code::error, [], 'Must be post' );
		}
	}
	/**
	 * 优惠券模版编辑
	 * @datetime 2017-06-04T11:53:36+0800
	 * @author 韩文博
	 */
	public function templateEdit() {
		if ($this->post) {
			$post  = $this->post;
			$model = model('VoucherTemplate');
			$post  = $this->post;

			$result = $this->validate($post, 'Admin/VoucherTemplate.add');
			if (true !== $result) {
				return $this->send($result);
			}
			//金额验证
			$price = intval($post['price']) > 0 ? intval($post['price']) : 0;
			$limit = intval($post['limit']) > 0 ? intval($post['limit']) : 0;
			if ($price >= $limit) {
				return $this->send(lang('coupon_price_error'));
			}
			$model              = model('VoucherTemplate');
			$data               = $post;
			$data['title']      = trim($post['title']);
			$data['desc']       = trim($post['desc']);
			$data['end_date']   = strtotime($post['end_date']);
			$data['price']      = $price;
			$data['limit']      = $limit;
			$data['state']      = $post['state'] == 1 ? 1 : 2;
			$data['total']      = intval($post['total']) > 0 ? intval($post['total']) : 0;
			$data['each_limit'] = intval($post['each_limit']) > 0 ? intval($post['each_limit']) : 0;

			$result = $model->editVoucherTemplate(array('id' => $post['id']), $data);
			if ($result) {
				return $this->send( Code::success );
			} else {
				return $this->send( Code::error );
			}
		} else {
			return $this->send( Code::error, [], 'Must be post' );
		}
	}
	/**
	 * 查看优惠券详细
	 */
	public function templateInfo() {
	    $coupon_template_model = model('VoucherTemplate');
		$get = $this->get;
		$id  = intval($get['id']);
		if ($id <= 0) {
			return $this->send( Code::param_error );
		}

		//查询模板信息
		$condition             = array();
		$condition['id']       = $get['id'];
		// $condition['state']    = 1;
		// $condition['give_out'] = array('elt', '0');
		// $condition['end_date'] = array('gt', time());
		$row                   = $coupon_template_model->getVoucherTemplateInfo($condition);


		$result                        = [];
		$result['info']  = $row;
		return $this->send( Code::success, $result );
	}

	/**
	 * 删除优惠券
	 * @datetime 2017-06-04T11:56:58+0800
	 * @author 韩文博
	 */
	public function templateDel() {
		$id = intval(input('post.ids'));
		if ($id <= 0) {
			return $this->send(lang('condition_error'), url('templateList'));
		}

		$model                  = model('VoucherTemplate');
		$condition              = array();
		$condition['id']        = $id;
		$condition['give_out']  = array('elt', '0'); //会员没领取过优惠券才可删除
		$condition['is_system'] = 0;
		$find                   = $model->getVoucherTemplateInfo($condition);
		if (empty($find)) {
			return $this->send( Code::param_error );
		}
		$result = $model->delVoucherTemplate(array('id' => $find['id']));
		if ($result) {
			return $this->send( Code::success );
		} else {
			return $this->send( Code::error );
		}
	}

	/**
	 * 发布优惠券
	 * @method     GET
	 * @datetime 2017-06-04T15:00:36+0800
	 * @author 韩文博
	 */
	public function publishVoucher() {
		if ($this->post) {
			$post                  = $this->post;
			$coupon_model         = model('Voucher');
			$vocher_template_model = model('VoucherTemplate');
			$user_model            = model('User');
			$post['user_ids']      = array_unique($post['user_ids']);
			$template              = $vocher_template_model->getVoucherTemplateInfo(['id' => $post['id']]);
			if ($post['user_ids'] && $template) {
				$add_data = [];
				foreach ($post['user_ids'] as $user_id) {
					$nickname   = $user_model->where(['id' => $user_id])->value('nickname');
					$add_data[] = [
						'code'        => $coupon_model->getCode($user_id),
						'template_id' => $template['id'],
						'title'       => $template['title'],
						'desc'        => $template['desc'],
						'start_date'  => $template['start_date'],
						'end_date'    => $template['end_date'],
						'price'       => $template['price'],
						'limit'       => $template['limit'],
						'state'       => 1,
						'create_time' => time(),
						'owner_id'    => $user_id,
						'owner_name'  => $nickname,
					];
				}
				// 判断是否超出
				$user_count = count($post['user_ids']);
				if ($user_count >= ($template['total'] - $template['give_out'])) {
					return $this->send( Code::error, [], '本次发送已超出了能发放的总人数' );
				}
				$coupon_model->startTrans();
				try {
					$state = $coupon_model->addVoucherAll($add_data);
					if (!$state) {
						$coupon_model->rollback();
						return $this->send( Code::error, [], '发送失败' );
					}
					// 修改优惠券模板信息
					$state = $vocher_template_model->where(['id' => $template['id']])->setInc('give_out', $user_count);
					if ($state) {
						$coupon_model->commit();
						// todo 发送消息
						return $this->send( Code::success, [], '成功发送出' . $user_count . '张优惠券' );
					} else {
						$coupon_model->rollback();
						return $this->send( Code::error, [], '修改优惠券状态失败' );
					}
				} catch (\Exception $e) {
					$coupon_model->rollback();
					return $this->send($e->getMessage());
				}
			} else {
				return $this->send( Code::error, [], '请选择要发送的用户' );

			}
		}
	}
	/**
	 * 把优惠券模版设为失效
	 */
	private function check_coupon_expire($coupon_id = '') {
		$condition = array();
		if (empty($coupon_id)) {
			$condition['end_date'] = array('lt', time());
		} else {
			$condition['id'] = $coupon_id;
		}
		$condition['state'] = $this->templatestate_arr['usable'][0];
		model('VoucherTemplate')->where($condition)->save(array('state' => $this->templatestate_arr['disabled'][0]));
	}
}
?>