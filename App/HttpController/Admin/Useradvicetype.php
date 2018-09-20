<?php
namespace App\HttpController\Admin;
/**
 * 意见反馈类别
 */
class Useradvicetype extends Admin {
	public function _initialize() {
		parent::_initialize();
	}

	/**
	 * 意见反馈类别列表
	 * @author 孙泉
	 */
	public function index() {
		$user_advice_type_model = model('UserAdviceType');
		$table_prefix           = config('database.prefix');
		$condition              = array();
		$get                    = $this->get;

		//分页
		$count      = $user_advice_type_model->where($condition)->count();
		$field      = '*';
		$order      = 'id asc';
		$list       = $user_advice_type_model->getUserAdviceTypeList($condition, $field, $order, $order, $this->getPageLimit());
		return $this->send(Code::success,[
			'total_number' => $count,
			'list' => $list,
		]);
	}
	/**
	 * 意见反馈类别添加
	 * @author 孙泉
	 */
	public function add() {
		if ($this->post) {
			$post = $this->post;
			if (!trim($post['title'])) {
				exit($this->send('请输入名称'));
			}

			$user_advice_type_model = model('UserAdviceType');
			$data                   = $post;
			$user_advice_type_id    = $user_advice_type_model->addUserAdviceType($data);
			if ($user_advice_type_id) {
				return $this->send( Code::success );
			} else {
				return $this->send( Code::error );
			}
		} else {
			return $this->send( Code::error, [], 'Must be post' );
		}
	}
	/**
	 * 意见反馈类别修改
	 * @author 孙泉
	 */
	public function edit() {
		if ($this->post) {
			$post = $this->post;
			if (!trim($post['title'])) {
				return $this->send( Code::param_error, [], '请输入名称' );
			}

			if (!trim($post['id'])) {
				return $this->send( Code::param_error );
			}

			$user_advice_type_model = model('UserAdviceType');
			$data                   = $post;
			$user_advice_type_id    = $user_advice_type_model->editUserAdviceType($data, $condition);
			if ($user_advice_type_id) {
				return $this->send( Code::success );
			} else {
				return $this->send( Code::error );
			}
		}
	}
	/**
	 * 详情
	 * @return [type] [description]
	 */
	public function info(){
		$get = $this->get;
		$codnition       = array();
		$condition['id'] = $get;
		if (!$condition) {
			exit($this->send('参数错误'));
		}

		$user_advice_type_model = model('UserAdviceType');
		$row                    = $user_advice_type_model->getUserAdviceTypeInfo($condition, $field = '*');

		$result                        = [];
		$result['info']  = $row;
		return $this->send( Code::success, $result );
	}
	/**
	 * 意见反馈类别删除
	 * @author 孙泉
	 */
	public function del() {
		$post = $this->post;
		$ids = $post['ids'];
		$res = db('UserAdviceType')->where(
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