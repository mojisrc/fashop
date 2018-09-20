<?php
/**
 * 消息数据模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class Message extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 添加
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addMessage($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addMessageAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editMessage($condition = array(), $data = array()) {
		return $this->update($data, $condition, true);
	}
	/**
	 * 删除
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delMessage($condition = array()) {
		return $this->where($condition)->delete();
	}
	/**
	 * 计算数量
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param array $condition 条件
	 * @return int
	 */
	public function getMessageCount($condition) {
		return $this->where($condition)->count();
	}
	/**
	 * 获取消息单条数据
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getMessageInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得消息列表
	 * @datetime 2017-06-15 16:22:25
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array | false
	 */
	public function getMessageList($condition = array(), $field = '*', $order = '', $page = '1,10', $group = '') {
		$list = $this->where($condition)->order($order)->field($field)->group($group)->page($page)->select();
		return $list ? $list->toArray() : false;
	}
	/**
	 * 消息列表
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @param    string $group
	 * @return   array
	 * @author 孙泉
	 */
	public function getMessageListMore($condition, $field = '*', $order = "id desc", $page = '1,10', $group = '')  {
		$data = $this->alias('message')->join('__MESSAGE_STATE__ message_state', 'message.id = message_state.message_id', 'LEFT')->where($condition)->field($field)->page($page)->order($order)->group($group)->select();
		return $data ? $data->toArray() : $data;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelMessage($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>