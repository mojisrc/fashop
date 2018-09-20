<?php
// todo 废弃

////////////////////////////////////////行为管理////////////////////////////////////////////////////
/**
 * 记录行为日志，并执行该行为的规则
 * @param string $action 行为标识
 * @param string $model 触发行为的模型名
 * @param int $record_id 触发行为的记录id
 * @param int $user_id 执行行为的用户id
 * @return boolean
 * @author huajie <banhuajie@163.com>
 */
function action_log($action = null, $model = null, $record_id = null, $user_id = null) {

	//参数检查
	if (empty($action) || empty($model) || empty($record_id)) {
		return '参数不能为空';
	}
	if (empty($user_id)) {
		$user_id = is_login();
	}

	//查询行为,判断是否执行
	$action_info = db('Action')->getByName($action);
	if ($action_info['status'] != 1) {
		return '该行为被禁用或删除';
	}

	//插入行为日志
	$data['action_id']   = $action_info['id'];
	$data['user_id']     = $user_id;
	$data['action_ip']   = ip2long(\App\Utils\Ip::getClientIp());
	$data['model']       = $model;
	$data['record_id']   = $record_id;
	$data['create_time'] = time();

	//解析日志规则,生成日志备注
	if (!empty($action_info['log'])) {
		if (preg_match_all('/\[(\S+?)\]/', $action_info['log'], $match)) {
			$log['user']   = $user_id;
			$log['record'] = $record_id;
			$log['model']  = $model;
			$log['time']   = time();
			$log['data']   = array('user' => $user_id, 'model' => $model, 'record' => $record_id, 'time' => time());
			foreach ($match[1] as $value) {
				$param = explode('|', $value);
				if (isset($param[1])) {
					$replace[] = call_user_func($param[1], $log[$param[0]]);
				} else {
					$replace[] = $log[$param[0]];
				}
			}
			$data['remark'] = str_replace($match[0], $replace, $action_info['log']);
		} else {
			$data['remark'] = $action_info['log'];
		}
	} else {
		//未定义日志规则，记录操作url
		$data['remark'] = '操作url：' . $_SERVER['REQUEST_URI'];
	}

	db('ActionLog')->insert($data);

	if (!empty($action_info['rule'])) {
		//解析行为
		$rules = parse_action($action, $user_id);

		//执行行为
		$res = execute_action($rules, $action_info['id'], $user_id);
	}
}

/**
 * 解析行为规则
 * 规则定义  table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
 * 规则字段解释：table->要操作的数据表，不需要加表前缀；
 *              field->要操作的字段；
 *              condition->操作的条件，目前支持字符串，默认变量{$self}为执行行为的用户
 *              rule->对字段进行的具体操作，目前支持四则混合运算，如：1+points*2/2-3
 *              cycle->执行周期，单位（小时），表示$cycle小时内最多执行$max次
 *              max->单个周期内的最大执行次数（$cycle和$max必须同时定义，否则无效）
 * 单个行为后可加 ； 连接其他规则
 * @param string $action 行为id或者name
 * @param int $self 替换规则里的变量为执行用户的id
 * @return boolean|array: false解析出错 ， 成功返回规则数组
 * @author huajie <banhuajie@163.com>
 */
function parse_action($action = null, $self) {
	if (empty($action)) {
		return false;
	}

	//参数支持id或者name
	if (is_numeric($action)) {
		$map = array('id' => $action);
	} else {
		$map = array('name' => $action);
	}

	//查询行为信息
	$info = db('Action')->where($map)->find();
	if (!$info || $info['status'] != 1) {
		return false;
	}

	//解析规则:table:$table|field:$field|condition:$condition|rule:$rule[|cycle:$cycle|max:$max][;......]
	$rules  = $info['rule'];
	$rules  = str_replace('{$self}', $self, $rules);
	$rules  = explode(';', $rules);
	$return = array();
	foreach ($rules as $key => &$rule) {
		$rule = explode('|', $rule);
		foreach ($rule as $k => $fields) {
			$field = empty($fields) ? array() : explode(':', $fields);
			if (!empty($field)) {
				$return[$key][$field[0]] = $field[1];
			}
		}
		//   dump($return[$key]);
		//    dump(!array_key_exists('cycle', $return[$key]));
		//   dump(!array_key_exists('max', $return[$key]));
		//   dump(is_array($return[$key]));
		// exit;
		//cycle(检查周期)和max(周期内最大执行次数)必须同时存在，否则去掉这两个条件

		if (is_array($return[$key])) {
			if (!array_key_exists('cycle', $return[$key]) || !array_key_exists('max', $return[$key])) {
				dump(1);exit;
				unset($return[$key]['cycle'], $return[$key]['max']);
			}
		}

	}

	return $return;
}

/**
 * 执行行为
 * @param array $rules 解析后的规则数组
 * @param int $action_id 行为id
 * @param array $user_id 执行的用户id
 * @return boolean false 失败 ， true 成功
 * @author huajie <banhuajie@163.com>
 */
function execute_action($rules = false, $action_id = null, $user_id = null) {
	if (!$rules || empty($action_id) || empty($user_id)) {
		return false;
	}

	$return = true;
	foreach ($rules as $rule) {

		//检查执行周期
		$map                = array('action_id' => $action_id, 'user_id' => $user_id);
		$map['create_time'] = array('gt', time() - intval($rule['cycle']) * 3600);
		$exec_count         = db('ActionLog')->where($map)->count();
		if ($exec_count > $rule['max']) {
			continue;
		}

		//执行数据库操作
		$Model = db(ucfirst($rule['table']));
		$field = $rule['field'];
		$res   = $Model->where($rule['condition'])->setField($field, array('exp', $rule['rule']));

		if (!$res) {
			$return = false;
		}
	}
	return $return;
}
/**
 * 获取行为数据
 * @param string $id 行为id
 * @param string $field 需要获取的字段
 * @author huajie <banhuajie@163.com>
 */
function get_action($id = null, $field = null) {
	if (empty($id) && !is_numeric($id)) {
		return false;
	}
	$list = cache('action_list');
	if (empty($list[$id])) {
		$map       = array('status' => array('gt', -1), 'id' => $id);
		$list[$id] = db('Action')->where($map)->field(true)->find();
	}
	return empty($field) ? $list[$id] : $list[$id][$field];
}
/**
 * 根据用户ID获取用户昵称
 * @param  integer $uid 用户ID
 * @return string       用户昵称
 */
function get_nickname($uid = 0) {
	static $list;
	if (!($uid && is_numeric($uid))) {
		//获取当前登录用户名
		return session('user_auth.username');
	}

	/* 获取缓存数据 */
	if (empty($list)) {
		$list = cache('sys_user_nickname_list');
	}

	/* 查找用户信息 */
	$key = "u{$uid}";
	if (isset($list[$key])) {
		//已缓存，直接使用
		$name = $list[$key];
	} else {
		//调用接口获取用户信息
		$info = db('User')->field('nickname')->find($uid);
		if ($info !== false && $info['nickname']) {
			$nickname = $info['nickname'];
			$name     = $list[$key]     = $nickname;
			/* 缓存用户 */
			$count = count($list);
			$max   = config('USER_MAX_CACHE');
			while ($count-- > $max) {
				array_shift($list);
			}
			cache('sys_user_nickname_list', $list);
		} else {
			$name = '';
		}
	}
	return $name;
}
/**
 * 时间戳格式化
 * @param int $time
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i') {
	$time = $time === NULL ? time() : intval($time);
	return date($format, $time);
}
////////////////////////////////////////行为管理////////////////////////////////////////////////////

?>