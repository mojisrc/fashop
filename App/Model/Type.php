<?php

namespace App\Model;
use ezswoole\Model;
use traits\model\SoftDelete;
use EasySwoole\Core\Component\Di;

class Type extends Model {
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

	/**
	 * 获取分类详细信息
	 * @param  milit   $id 分类ID或标识
	 * @param  boolean $field 查询字段
	 * @return array     分类信息
	 */
	public function info($id, $field = true) {
		/* 获取分类信息 */
		$map = array();
		if (is_numeric($id)) {
			//通过ID查询
			$map['id'] = $id;
		} else {
			//通过标识查询
			$map['name'] = $id;
		}
		return $this->field($field)->where($map)->find();
	}
	public function siblings($id, $field = 'id,title', $order = 'sort asc,id desc') {
		$pid = $this->where(array('id' => $id))->value('pid');
		return $this->where(array('pid' => $pid))->field($field)->order($order)->select();
	}
	/**
	 * 获取指定分类子分类ID
	 * @param  string $cate 分类ID
	 * @return string       id列表
	 */
	public function getChildrenId($cate) {
		$field = 'id,pid';
		$type  = $this->getTree($cate, $field);
		$ids   = array();
		foreach ($type['_'] as $key => $value) {
			$ids[] = $value['id'];
		}
		return implode(',', $ids);
	}
	/**
	 * 获取分类树，指定分类则返回指定分类极其子分类，不指定则返回所有分类树
	 * @param  integer $id    分类ID
	 * @param  boolean $field 查询字段
	 * @return array          分类树
	 */
	public function getTree($id = 0, $field = true) {
		/* 获取当前分类信息 */
		if ($id) {
			$info = $this->info($id);
			$id   = $info['id'];
		}

		/* 获取所有分类 */
		$map  = array('status' => 1);
		$list = $this->field($field)->where($map)->order('sort')->select();
		$list = \App\Utils\Tree::listToTree($list, $pk = 'id', $pid = 'pid', $child = '_', $root = $id);

		/* 获取返回数据 */
		if (isset($info)) {
			//指定分类则返回当前分类极其子分类
			$info['_'] = $list;
		} else {
			//否则返回所有分类
			$info = $list;
		}

		return $info;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelType($condition) {
        return $this->where($condition)->find()->delete();
    }
}
?>