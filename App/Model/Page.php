<?php
/**
 * 模板模型
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

class Page extends Model{
	use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $resultSetType = 'collection';

    protected $type = [
        'body'      =>  'json'
    ];
	/*
		array
		如果设置为强制转换为array类型，系统会自动把数组编码为json格式字符串写入数据库，取出来的时候会自动解码。
		json
		指定为json类型的话，数据会自动json_encode写入，并且在读取的时候自动json_decode处理。
	 */

	/**
	 * 添加
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param  array $data
	 * @return int pk
	 */
	public function addPage($data = array()) {
		$data['create_time'] = time();
		$result              = $this->allowField(true)->save($data);
		if ($result) {
			return $this->getLastInsID();
		}
		return $result;
	}
	/**
	 * 添加多条
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param array $data
	 * @return boolean
	 */
	public function addPageAll($data) {
		return $this->insertAll($data);
	}
	/**
	 * 修改
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editPage($condition = array(), $data = array()) {
		$data['update_time'] = time();
		return $this->update($data, $condition, true);
	}
	/**
	 * 获取模板单条数据
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param array $condition 条件
	 * @param string $field 字段
	 * @return array | false
	 */
	public function getPageInfo($condition = array(), $field = '*') {
		$info = $this->where($condition)->field($field)->find();
		return $info ? $info->toArray() : false;
	}
	/**
	 * 获得模板列表
	 * @datetime 2017-10-17 15:18:56
	 * @author 韩文博
	 * @param    array $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getPageList($condition = array(), $field = '*', $order = '', $page = '1,10') {
		$list = $this->where($condition)->order($order)->field($field)->page($page)->select();
		return $list ? $list->toArray() : false;
	}

    /**
     * 软删除
     * @param    array  $condition
     */
    public function softDelPage($condition) {
        return $this->where($condition)->find()->delete();
    }
}