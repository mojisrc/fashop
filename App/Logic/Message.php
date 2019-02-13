<?php
/**
 * 消息业务逻辑
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic;
use ezswoole\Exception;
use ezswoole\Model;


class Message extends Model {
	/**
	 * 添加消息
	 * @param    string $to_user_id
	 * @param    string $title
	 * @param    string $body
	 * @param    string $relation_model
	 * @param    int $relation_model_id
	 * @param    int $type_id
	 * @return int | array
	 */
	function addMessage(int $to_user_id, string $title, string $body, string $relation_model, int $relation_model_id, int $type_id) {
		$message_id = \App\Model\Message::init()->addMessage([
			'title'             => $title,
			'body'              => $body,
			'relation_model'    => $relation_model,
			'relation_model_id' => $relation_model_id,
			'type_id'           => $type_id,
			'is_group'          => 0,
		]);
		if ($message_id > 0) {
			\App\Model\MessageState::init()->addMessageState([
				'to_user_id'     => $to_user_id,
				'message_id'     => $message_id,
				'app_push_state' => 0,
			]);
			self::asynCheckMessagePush();
		} else {
			throw new \Exception('发送失败');
		}
		return $message_id;
	}

}
