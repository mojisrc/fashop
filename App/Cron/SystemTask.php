<?php
/**
 * 消息推送
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Cron;

use EasySwoole\Config;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\Logger;
use ezswoole\Db;
use EasySwoole\Core\Swoole\Task\TaskManager;

/**
 * todo 多加几家app推送
 * 其实我也可以不这么写
 * 就是在消息创建的时候就执行
 * 这个呢 只是用来检查有什么没执行的任务
 *
 */
class SystemTask
{
	static function getInstance()
	{
		$instance = Di::getInstance()->get('SystemTask');
		if (is_null($instance)) {
			$instance = new SystemTask();
			Di::getInstance()->set('SystemTask', $instance);
		}
		return $instance;
	}

	// 运行次数，每次心跳算一次
	private $runTimes = 0;
	// 正在处理的最大id
	private $maxProcessingId = 0;
	// 等待秒数
	private $waitSecond = 20;

	// 设置最大运行中的id
	private function setMaxProcessingId(int $message_push_id)
	{
		$instance = SystemTask::getInstance();
		return $instance->maxProcessingId = $message_push_id;
	}

	public function setRunTimes()
	{
		$instance = SystemTask::getInstance();
		$instance->runTimes++;
	}

	/**
	 * 消息推送
	 * @datetime 2017-11-03T14:13:24+0800
	 * @author   韩文博
	 */
	public static function send()
	{
		$instance     = SystemTask::getInstance();
		$message_list = $instance->getTaskList();
		$instance->runTimes++;

		if (!empty($message_list) && $last_id = end($message_list)['id']) {

			$instance->setMaxProcessingId($last_id);

			$adapters = Config::getInstance()->getConf('task.adapter');

			try {
				foreach ($message_list as $message) {
					try {
						$message['content'] = json_decode($message['content'], true);
						$taskClass = new Task('taskData');
						\EasySwoole\Core\Swoole\Task\TaskManager::async($taskClass);


						TaskManager::getInstance()->add(function () use ($instance, $adapters, $message) {

							$target_class = $adapters[$message['type']];

							if (class_exists($target_class)) {

								$task_class = new $target_class($message['content']);
								$instance->updateRecord(['id' => $message['id'], 'state' => $task_class->processTask(), 'result' => $task_class->getResult(),]);
							} else {
								Logger::getInstance()->log("不存在：{$adapters[$message['type']]}");
							}
						});
					} catch (\Exception $e) {
						Logger::getInstance()->log($e);
					}
				}
				//$instance->updateRecords($results);
			} catch (\Exception $e) {
				Logger::getInstance()->log($e);
			}
		}
	}

	/**
	 * 获得任务列表
	 * @method     GET
	 * @datetime 2017-11-06T14:34:03+0800
	 * @author   韩文博
	 * @return array
	 */
	private function getTaskList()
	{
		$condition['state'] = 0;
		if ($this->runTimes === 0) {
			$condition['id'] = ['gt', $this->maxProcessingId];
		}
		$this->runTimes++;

		$rows = $this->waitSecond * Config::getInstance()->getConf('SERVER.CONFIG.task_worker_num'); // 如果task 有在其他地方用到就会出问题，现在是饱和
		return model('SystemTask')->getSystemTaskList($condition, '*', 'create_time desc', "1,{$rows}");
	}

	/**
	 * 修改单条数据
	 * @method     GET
	 * @datetime 2017-11-06T14:58:15+0800
	 * @author   韩文博
	 * @param    array $result
	 */
	private function updateRecord(array $result)
	{
		return model('SystemTask')->editSystemTask(['id' => $result['id']], ['deal_time' => time(), 'state' => $result['state'] == true ? 1 : -1,]);
	}

	/**
	 * 批量修改
	 * @datetime 2017-11-05T23:37:44+0800
	 * @author   韩文博
	 * todo 配置文件完善后 这里使用动态的前缀
	 */
	private function updateRecords(array $results)
	{
		$ids       = implode(',', array_column($results, 'id'));
		$deal_time = time();
		$sql       = "UPDATE ez_message_push SET deal_time = {$deal_time}, state = CASE id ";
		foreach ($results as $result) {
			$sql .= sprintf("WHEN %d THEN %d ", $result['id'], $result['state'] == true ? 1 : -1);
		}
		$sql .= "END WHERE id IN ($ids)";
		return Db::query($sql);
	}
}
