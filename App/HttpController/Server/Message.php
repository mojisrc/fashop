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
namespace App\HttpController\Server;
use App\Utils\Code;
use ezswoole\Db;

class Message extends Server {

	/**
	 * 消息分类
	 * http_method get
	 */
	public function typeList() {
		$message_type_model  = model('MessageType');
		$condition           = array();
		$condition['status'] = 1;
		$count               = $message_type_model->where($condition)->count();

		$list                = $message_type_model->getmessageTypelist($condition, '*', 'id asc', '1,100');

		$this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 消息首页
	 * @method GET
	 * @author 孙泉
	 */
	public function search() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$user            					   = $this->getRequestUser();
				$user_id                               = $user['id'];
				$condition                             = array();
				$condition['message_state.to_user_id'] = $user_id;
				$message_model                         = model('Message');
				$count                                 = $message_model->alias('message')->join('__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT')->where($condition)->count('distinct type_id');

				$field = 'max(message_state.id) as max_id,message.type_id as message_type,(select ez_message.body from ez_message LEFT JOIN ez_message_state ON ez_message.id=ez_message_state.message_id where ez_message_state.id=max(message_state.id) and ez_message_state.to_user_id=' . $user_id . ') as body,(select COUNT(ez_message_state.id) from ez_message LEFT JOIN ez_message_state ON ez_message.id=ez_message_state.message_id where ez_message.type_id=message_type and ez_message_state.to_user_id=' . $user_id . ') as unreadcount';

				$order        = 'type_id asc,max_id desc';
				$group        = 'type_id';
				$list         = $message_model->getMessageListMore($condition, $field, $order, $this->getPageLimit(), $group);

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => $list,
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 具体type下的用户消息列表
	 * @method GET
	 * @param int type_id 类型id
	 * @author 孙泉
	 */
	public function typeMessages() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );

		} else{

			$get                                  		   = $this->get;

			// 1系统公告
			if ($get['type_id'] === '' || $get['type_id'] === NULL || $get['type_id'] === false) {
				$this->send( Code::error );

			}else{

				try{
					$user          = $this->getRequestUser();
					$user_id       = $user['id'];
					$message_model = model('Message');
					$condition     = array();
					$count         = 0;
					$list          = [];

					$type          = $get['type_id'];

					$where_string  = "message_state.to_user_id=$user_id AND message_state.del_state=0 AND message_state.del_time=0 AND message.type_id=$type";

					switch ($type) {
						case 1:

							$count  = $message_model->alias('message')->join('__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT')->where($where_string)->count();

							$field        = 'message_state.*,message.type_id,title,body,relation_model,relation_model_id,message.create_time';
							$order        = 'message.create_time desc';
							$message_list = $message_model->getMessageListMore($where_string, $field, $order, $this->getPageLimit(), $group = '');

				        	$list = array_values($message_list);

							break;
					}

					$this->send( Code::success, [
						'total_number' => $count,
						'list'         => $list,
					] );

				} catch( \Exception $e ){
					$this->send( Code::server_error, [], $e->getMessage() );
				}

			}
		}
	}


	/**
	 * 统计系统消息未读条数
	 * @method GET
	 */
	public function sysUnReadCount() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$get           = $this->get;
				$message_model = model('Message');

				$user          = $this->getRequestUser();
				$user_id       = $user['id'];
				$where_string  = "message_state.read_state=0 AND message_state.to_user_id=$user_id AND message_state.del_state=0 AND message_state.del_time=0 AND message.type_id=1";
				$count         = $message_model->alias('message')->join('__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT')->where($where_string)->count();

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => []
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 统计消息未读条数
	 * @method GET
	 * @author 孙泉
	 */
	public function unReadCount() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$get                     = $this->get;
				$message_state_model     = model('MessageState');

				$user                    = $this->getRequestUser();
				$user_id                 = $user['id'];
				$condition               = array();
				$condition['read_state'] = 0; //0未读 1已读
				$condition['to_user_id'] = $this->user['id']; //用户id
				$count                   = $message_state_model->where($condition)->count();

				$this->send( Code::success, [
					'total_number' => $count,
					'list'         => []
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 未读消息分组数量
	 * @method     GET
	 * @datetime 2017-06-21T11:25:51+0800
	 * @author 韩文博
	 */
	public function unreadGroupCount() {

		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$get                     = $this->get;
				$message_state_model     = model('MessageState');

				$user                    = $this->getRequestUser();
				$user_id                 = $user['id'];


				$data = [
					'info_detail_count'  => 0,
					'order_send_count'   => 0,
					'coupon_send_count' => 0,
					'order_refund_count' => 0,
				];

				$message_state_model                   = model('MessageState');
				$condition                             = array();
				$condition['message_state.read_state'] = 0;
				$condition['message_state.to_user_id'] = $user_id;
				$condition['message.type_id']          = ['neq', 0];

				$list = $message_state_model->alias('message_state')
					->join('__MESSAGE__ message', 'message.id = message_state.message_id', 'LEFT')
					->where($condition)
					->field('message_state.id,message.relation_model')
					->select();

				if ($list) {
					foreach ($list as $key => $value) {
						$data[$value['relation_model'] . '_count']++;
					}
				}

				$this->send( Code::success, [
					'list'         => $data
				] );

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 *  更改用户消息状态
	 *  @ethod POST
	 *  @param int 	 $classify 分类：1读操作，2删除操作
	 *  @param array $ids 	  消息的id数组
	 *  @author 孙泉
	 */
	public function changeState() {
		if( $this->verifyResourceRequest() !== true ){
			$this->send( Code::user_access_token_error );
		} else{
			try{
				$post                    = $this->post;
				$ids       				 = $post['ids'];

				if ( !is_array($ids) || !in_array($post['classify'],array(1,2)) ) {
					$this->send( Code::error );

				}else{
					$message_state_model = model('MessageState');
					$user                = $this->getRequestUser();
					$user_id             = $user['id'];
					$table_prefix        = config('database.prefix');
					$condition           = array();
					$param               = array();

					switch ($post['classify']) {
					case 1: //读操作
						$param['read_state'] = 1;
						$param['read_time']  = time();
						break;

					case 2: //删除操作
						$param['del_state'] = 1;
						$param['del_time']  = time();
						break;
					}

					$result = $message_state_model->updateMessageState($user_id, $ids, $param);
					if( $result ){
						return $this->send( Code::success );
					} else{
						return $this->send( Code::error );
					}

				}

			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}
	}

	/**
	 * 设置某个分组为全部已经读取
	 * @method     GET
	 * @param string $type 类型
	 * @datetime 2017-06-21T15:44:41+0800
	 * @author 韩文博
	 */
	public function setGroupAllRead() {

	}

}
