<?php
/**
 * 会员通知
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\HttpController\Admin;
/**
 * 消息
 * Class Message
 * @package App\HttpController\Admin
 */
class Message extends Admin {
	public function _initialize() {
		parent::_initialize();
	}
	public function index() {
		$get        = $this->get;
		$state_type = $get['state_type'];
		$type       = array('info_detail' => 2, 'order_send' => 3, 'coupon_send' => 4, 'order_refund' => 5);
		if (isset($type[$state_type])) {
			$condition['type_id']  = $type[$state_type];
			$condition['is_group'] = $get['is_group'] ? $get['is_group'] : 0;
		} else {
			$condition['is_group'] = 1;
		}
		$model = model('Message');
		// 下单时间-起始时间 下单时间-结束时间
		if ($get['start'] && $get['start'] != '' && $get['end'] && $get['end'] != '') {
			$get['start']             = strtotime($get['start']);
			$get['end']               = strtotime($get['end']);
			$condition['create_time'] = array(array('egt', $get['start']), array('elt', $get['end']));

		} elseif ($get['start'] && $get['start'] != '') {
			$get['start']             = strtotime($get['start']);
			$condition['create_time'] = array('egt', $get['start']);

		} elseif ($get['end'] && $get['end'] != '') {
			$get['end']               = strtotime($get['end']);
			$condition['create_time'] = array('elt', $get['end']);

		}
		if ($get['keywords'] != '') {
			$condition['title'] = array('like', '%' . $get['keywords'] . '%');
		}
		//完结判断
		if ($get['send_state'] != '') {
			if ($get['send_state'] == 0) {
				$condition['send_state'] = array('eq', 0);
			} elseif ($get['send_state'] == 1) {
				$condition['send_state'] = array('eq', 1);
			}
		}

		$count      = $model->where($condition)->count();
		$page_class = new Page($count, 10);
		$page       = $this->getPageLimit()
;
		$list       = $model->getMessageList($condition, '*', 'id desc', $page);
		$this->assign('type_id', $type[$state_type]);
		$this->assign('page', $page_class->show());
		$this->assign('list', $list);
		return $this->send();
	}
	/**
	 * 通知添加
	 * @datetime 2017-06-04T18:53:14+0800
	 * 如果是指定用户发送 user_ids 必填
	 * @author 韩文博
	 */
	public function add() {
		if ($this->post) {
			$post            = $this->post;
			$validate_result = $this->validate($post, 'Admin/Message.add');
			if ($validate_result !== true) {
				return $this->send($validate_result);
			}
			$relation_model    = '';
			$relation_model_id = '';
			if ($post['type_id'] > 1 && !$post['relation_model_id']) {
				return $this->send('该消息类型，必须关联数据');
			} else {
				$relation_model = model('MessageType')->where(['id' => $post['type_id']])->value('model');
				if (!$relation_model) {
					return $this->send('请填写关联表名');
				}
				$relation_model_id = $post['relation_model_id'];
			}
			$is_group         = $post['is_group'] ? 1 : 0;
			$user_model       = model('User');
			$message_model    = model('Message');
			$post['user_ids'] = $post['user_ids'] ? array_unique($post['user_ids']) : array();

			if ($is_group == 0 && empty($post['user_ids'])) {
				return $this->send('请选择用户');
			}

			$message_model->startTrans();

			try {
				$message_id = $message_model->addMessage([
					'title'             => trim($post['title']),
					'body'              => trim($post['body']),
					'type_id'           => $post['type_id'],
					'relation_model'    => $relation_model,
					'relation_model_id' => $relation_model_id,
					'is_group'          => $is_group,
					'create_time'       => time(),
				]);

				if ($message_id > 0) {
					$user_ids = $is_group ? $user_model->column('id') : $post['user_ids'];
					$add_data = [];
					foreach ($user_ids as $user_id) {
						$add_data[] = [
							'to_user_id'     => $user_id,
							'message_id'     => $message_id,
							'app_push_state' => 0,
						];
					}

					$result = model('MessageState')->addMessageStateAll($add_data);

					if ($result) {
						$message_model->commit();

						return $this->send('发送成功');
					} else {
						$message_model->rollback();
						return $this->send('发送失败');
					}
				} else {
					return $this->send('发送失败');
				}
			} catch (\Exception $e) {
				$message_model->rollback();
				return $this->send($e->getMessage());
			}
		} else {
			$type_list = model('MessageType')->getmessageTypelist(['status' => 1, 'id' => ['in', [2]]], '*', 'id asc', '1,100');
			$this->assign('type_list', $type_list);
			return $this->send();
		}
	}
	/**
	 * 消息类型列表
	 * @method     GET
	 * @datetime 2017-06-14T12:38:04+0800
	 * @author 韩文博
	 */
	public function messageTypeIndex() {
		$list = model('MessageType')->getMessageTypeList([], '*', 'id desc', '1,1000');
		$this->assign('list', $list);
		return $this->send();
	}
	/**
	 * 消息类型添加
	 * @method     GET
	 * @datetime 2017-06-14T12:27:15+0800
	 * @author 韩文博
	 */
	public function messageTypeAdd() {
		if ($this->post) {
			$post = $this->post;
			model('MessageType')->addMessageType($post);
			return $this->send('添加成功');
		} else {
			return $this->send();
		}
	}
	/**
	 * 消息类型添加
	 * @method     GET
	 * @datetime 2017-06-14T12:27:15+0800
	 * @author 韩文博
	 */
	public function messageTypeEdit() {
		if ($this->post) {
			$post = $this->post;
			model('MessageType')->editMessageType(['id' => $post['id']], $post);
			return $this->send('修改成功');
		} else {
			$get = $this->get;
			$row = model('MessageType')->getMessageTypeInfo(['id' => $get['id']]);
			$this->assign('row', $row);
			return $this->send();
		}
	}
	/**
	 * 获得消息关联数据的搜索接口
	 * 注意：返回的数据要拼成return的数据约定格式
	 * @method     GET
	 * @datetime 2017-06-14T14:06:51+0800
	 * @author 韩文博
	 * @param int $type_id 消息类型id
	 * @param string $keywords 关键词
	 * @return  array  [{
	 *    'title'=>'',
	 *    'description'=>''
	 *    'id',
	 * }]
	 */
	public function getMessageRelationModelDataSearch() {
		$get  = $this->get;
		$rows = isset($get['rows']) ? $get['rows'] : 10;
		switch ($get['type_id']) {
		case 2:
			// 文章
			$model              = model('Info');
			$condition['title'] = ['like', '%' . $get['keywords'] . '%'];
			$count         = $model->where($condition)->count();
			$list               = $model->getInfoList($condition, 'id,title,`desc` as description', 'id desc', $this->getPageLimit());

			break;
		default:
			// 3客户动态
			$list       = [];
			$count      = 0;
			break;
		}
		return $this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );

	}
}
?>