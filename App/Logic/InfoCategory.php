<?php
/**
 * 信息分类逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic;
use ezswoole\Model;
use EasySwoole\Core\Component\Di;

class InfoCategory extends Model {
	/**
	 * 获得所有分类
	 * @datetime 2017-04-18T15:00:22+0800
	 * @author 韩文博
	 * @return   int
	 */
	public function getAll() {
		return cacheInfoCategory(1);
	}
	/**
	 * 获得某个id下的下一集分类
	 * @datetime 2017-04-18T15:00:53+0800
	 * @author 韩文博
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
	 * @datetime 2017-04-18T15:00:22+0800
	 * @author 韩文博
	 * @param    integer $id
	 * @param    string $flag
	 * @return   array
	 */
	public function getChilds($id, $flag = null) {
		return pidList($this->getAll(), $id, $flag ? $flag : $id);
	}
	/**
	 * 获得son的id
	 * @datetime 2017-04-18T15:02:10+0800
	 * @author 韩文博
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
	 * @datetime 2017-04-18T15:03:14+0800
	 * @author 韩文博
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
	 * @datetime 2017-04-18T15:03:44+0800
	 * @author 韩文博
	 * @return   array
	 */
	public function getTree() {
		return \App\Utils\Tree::listToTree($this->getAll());
	}
	/**
	 * 获得某个点下的树形结构 root填主节点的id即可
	 * @datetime 2017-04-18T15:04:11+0800
	 * @author 韩文博
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
	 * @datetime 2017-04-18T15:04:34+0800
	 * @author 韩文博
	 * @param    integer $id
	 * @return   array
	 */
	public function getAllChild($id) {
		return getListByPid($this->getAll(), $id, 'info_category_' . $id);
	}
	/**
	 * 获得某个点下的所有子的id
	 * @datetime 2017-04-18T15:07:04+0800
	 * @author 韩文博
	 * @param    integer $id
	 * @return   array
	 */
	public function getAllChildId($id) {
		dump($this->getAllChild($id));
		$ids = array();
		foreach ($this->getAllChild($id) as $key => $value) {
			echo "string";
			$ids[] = $value['id'];
		}
		return $ids;
	}
	/**
	 * 获得某个殿下的所有id和自己的id
	 * @datetime 2017-04-18T15:07:27+0800
	 * @author 韩文博
	 * @param    integer $id
	 * @return   array
	 */
	public function getSelfAndChildId($id) {
		return array_merge(array($id), $this->getAllChildId($id));
	}
}
