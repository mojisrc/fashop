<?php
/**
 * 版本控制
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
 * 版本控制
 * Class Version
 * @package App\HttpController\Admin
 */
class Version extends Admin {
	public function _initialize() {
		parent::_initialize();
	}
	/**
	 * 模板列表
	 * @author 韩文博
	 */
	public function index() {
		$list = model('Version')->paginate(10);
		$page = $list->render();
		$this->assign('list', $list);
		$this->assign('page', $page);
		return $this->send();
	}
	/**
	 * 添加
	 * @author 韩文博
	 */
	public function add() {
		if ($this->post) {
			$model                = model('Version');
			$data                 = $this->post;
			$data['publish_time'] = strtotime($data['publish_time']);
			if ($id = $model->addVersion($data)) {
				$this->send(lang('common_op_succ'));
			} else {
				$this->send(lang('common_op_fail'));
			}
		} else {
			return $this->send();
		}
	}
	/**
	 * 修改
	 * @author 韩文博
	 */
	public function edit() {
		if ($this->post) {
			$model                = model('Version');
			$data                 = $this->post;
			$data['publish_time'] = strtotime($data['publish_time']);
			$model->editVersion(['id' => $data['id']], $data) ? $this->send(lang('common_save_succ')) : $this->send(lang('common_save_fail'));
		} else {
			$row = model('Version')->getVersionInfo(['id' => input('get.id')]);
			$this->assign('row', $row);
			return $this->send();
		}
	}
	/**
	 * 删除
	 * @author 韩文博
	 */
	public function del() {
		$ids = input('post.ids');
		model('Version')->where(
			array(
				'id' => is_array($ids) ? array('in', implode(',', $ids)) : $ids,
			)
		)->delete() ? $this->send(lang('common_del_succ')) : $this->send(lang('common_del_fail'));
	}
}
?>