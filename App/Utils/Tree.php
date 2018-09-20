<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/9/2
 * Time: 下午4:01
 *
 */
namespace App\Utils;
class Tree
{
	/**
	 * 创建Tree
	 */
	static function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
		$tree = array();
		if (is_array($list)) {
			// 创建基于主键的数组引用
			$refer = array();
			foreach ($list as $key => $data) {
				$list[$key][$child] = array();
				$refer[$data[$pk]]  = &$list[$key];
			}
			foreach ($list as $key => $data) {
				// 判断是否存在parent
				$parentId = $data[$pid];
				if ($root == $parentId) {
					$tree[] = &$list[$key];
				} else {
					if (isset($refer[$parentId])) {
						$parent           = &$refer[$parentId];
						$parent[$child][] = &$list[$key];
					}
				}
			}
		}
		return $tree;
	}
	/**
	 * 返回某个子数组 以树形的结构
	 */
	static function pidListToTree($id, $list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
		$list = self::listToTree($list, $pk, $pid, $child, $root);
		foreach ($list as $key => $value) {
			if ($value['id'] == $id) {
				return $value;
			}
		}
	}
	/**
	 * pid 获得子数组
	 */
	static function pidList($list, $pid, $flag = 'e') {
		static $tree = array();
		if (!isset($tree[$flag])) {
			$tree[$flag] = array();
		}

		foreach ($list as $vo) {
			if ($vo['pid'] == $pid) {
				array_push($tree[$flag], $vo);
				self::pidList($list, $vo['id'], $flag);
			}
		}
		return $tree[$flag];
	}
	/**
	 * 获得所有分类下的某个父级下的及本身的数组
	 */
	static function getListByPid($list, $pid, $flag) {
		$plist = array();
		if (is_array($list)) {
			foreach ($list as $value) {
				if ($value['id'] == $pid) {
					$plist[] = $value;
					break;
				}
			}
			$child = self::pidList($list, $pid, $flag);
			foreach ($child as $v) {
				array_push($plist, $v);
			}
		}
		return $plist;
	}
}