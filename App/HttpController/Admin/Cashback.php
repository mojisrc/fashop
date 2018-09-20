<?php
namespace App\HttpController\Admin;
/**
 * 返现管理
 * Class Cashback
 * @package App\HttpController\Admin
 */
class Cashback extends Admin {
	public function _initialize() {
		parent::_initialize();
	}

	/**
	 * 返现列表
	 * @author 孙泉
	 */
	public function index() {
		$cashback_model = model('Cashback');
		$table_prefix   = config('database.prefix');
		$condition      = array();
		$get            = $this->get;

		//分页
		$count      = $cashback_model->where($condition)->count();
		$field      = '*';
		$order      = 'id asc';
		$list       = $cashback_model->getCashbackList($condition, $field, $order, $this->getPageLimit());

		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);

	}
	/**
	 * 返现添加
	 * @author 孙泉
	 */
	public function add() {
		if ($this->post) {
			$post = $this->post;
			if (!trim($post['target_amount'])) {
				return $this->send( Code::error, [], '请输入目标金额' );
			}

			if (!trim($post['back_amount'])) {
				return $this->send( Code::error, [], '请输入返现金额' );
			}

			$cashback_model      = model('Cashback');
			$data                = $post;
			$data['create_time'] = time();
			$cashback_id         = $cashback_model->addCashback($data);
			if ($cashback_id) {
				return $this->send( Code::success );
			} else {
				return $this->send( Code::error );
			}
		} else {
			return $this->send( Code::error, [], 'Must be post' );
		}
	}
	/**
	 * 返现修改
	 * @author 孙泉
	 */
	public function edit() {
		if ($this->post) {
			$post = $this->post;
			if (!trim($post['target_amount'])) {
				return $this->send( Code::error, [], '请输入目标金额' );
			}

			if (!trim($post['back_amount'])) {
				return $this->send( Code::error, [], '请输入返现金额' );
			}

			if (!trim($post['id'])) {
				return $this->send( Code::param_error );
			}

			$cashback_model      = model('Cashback');
			$data                = $post;
			$data['create_time'] = time();
			$cashback_id         = $cashback_model->editCashback($data, $condition);
			if ($cashback_id) {
				return $this->send( Code::success );
			} else {
				return $this->send( Code::error );
			}
		} else {
			return $this->send( Code::error, [], 'Must be post' );
		}
	}

	/**
	 * 详情
	 * @return [type] [description]
	 */
	public function info(){
		$get = $this->get;
		$codnition       = array();
		$condition['id'] = $get['id'];
		if (!$condition) {
			return $this->send( Code::param_error );
		}

		$cashback_model = model('Cashback');
		$row            = $cashback_model->getCashbackInfo($condition, $field = '*');

		$result                        = [];
		$result['info']  = $row;
		return $this->send( Code::success, $result );
	}
	/**
	 * 返现删除
	 * @author 孙泉
	 */
	public function del() {
		$post = $this->post;
		$ids = $post['ids'];
		$res = db('Cashback')->where(
			array(
				'id' => is_array($ids) ? array('in', implode(',', $ids)) : $ids,
			)
		)->delete();
		if ($res) {
			return $this->send( Code::success );
		} else {
			return $this->send( Code::error );
		}

	}
}
?>