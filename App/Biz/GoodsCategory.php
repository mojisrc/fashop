<?php
/**
 * 商品分类逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Biz;
use ezswoole\Model;


class GoodsCategory extends Model {
	/**
	 * 获得所有分类
	 * @return   int
	 */
	public function getAll() {
		return cacheGoodsCategory(1);
	}
	/**
	 * 获得某个id下的下一集分类
	 * @param    integer $id 父级id
	 * @return   array
	 */
	public function getSon($id) {
		$child = array();
		foreach ($this->getAll() as $key => $value) {
			if ($value['pid'] == $id) {
				$child[] = $value;
			}
		}
		return $child;
	}
	/**
	 * 获得某个点下的所有子 如果出现重复现象请在添加唯一flag
	 * @param    integer $id
	 * @param    string $flag
	 * @return   array
	 */
	public function getChilds($id, $flag = null) {
		return pidList($this->getAll(), $id, $flag ? $flag : $id);
	}
	/**
	 * 获得son的id
	 * @param    integer $id
	 * @return   array
	 */
	public function getSonId($id) {
		$ids = array();
		foreach ($this->getAll() as $key => $value) {
			if ($value['pid'] == $id) {
				$ids[] = $value['id'];
			}
		}
		return $ids;
	}
	/**
	 * 获得某条分类
	 * @param    integer $id
	 * @return   array
	 */
	public function getRow($id) {
		foreach ($this->getAll() as $key => $value) {
			if ($value['id'] == $id) {
				return $value;
			}
		}
	}
	/**
	 * 获得所有分类的树形结构
	 * @return   array
	 */
	public function getTree() {
		return \App\Utils\Tree::listToTree($this->getAll());
	}
	/**
	 * 获得某个点下的树形结构 root填主节点的id即可
	 * @param    integer $root
	 * @param    string $pk
	 * @param    string $pid
	 * @param    string $child
	 * @return   array
	 */
	public function getChildTree($root = 0, $pk = 'id', $pid = 'pid', $child = '_child') {
		return \App\Utils\Tree::listToTree($this->getAll(), $pk, $pid, $child, $root);
	}
	/**
	 * 获得某个点下的所有子一级
	 * @param    integer $id
	 * @return   array
	 */
	public function getAllChild($id) {
		return getListByPid($this->getAll(), $id, 'type_' . $id);
	}
	/**
	 * 获得某个点下的所有子的id
	 * @datetime 2017-04-18T15:07:04+0800
	 * @param    integer $id
	 * @return   array
	 */
	public function getAllChildId($id) {
		$ids = array();
		foreach ($this->getAllChild($id) as $key => $value) {
			$ids[] = $value['id'];
		}
		return $ids;
	}
	/**
	 * 获得某个殿下的所有id和自己的id
	 * @param    integer $id
	 * @return   array
	 */
	public function getSelfAndChildId($id) {
		return array_merge(array($id), $this->getAllChildId($id));
	}
}
