<?php

namespace App\Validate\Admin\Wechat;

use ezswoole\Validate;

/**
 * 微信验证
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 * @author     邓凯
 */
class Broadcast extends Validate
{
	protected $rule
		= [

			'id'                 => 'require',
			'condition_type'     => 'require',
			//基础
			'sex'                => 'checkSex',
			'province'           => 'checkProvince',
			'cost_average_price' => 'checkCostAveragePrice',
			'cost_times'         => 'checkCostTimes',
			'resent_cost_time'   => 'checkResentCostTime',
			'resent_visit_time'  => 'checkResentVisitTime',
			'register_time'      => 'checkRegisterTime',
			'user_tag'           => 'checkUserTag',
			// 添加
			'condition'          => 'require|checkCondition',
			'is_timing'          => 'require|checkIsTiming',
			'send_content'       => 'require|array|checkSendContent',
			'send_time'          => 'require|integer',
		];
	protected $message
		= [];
	protected $scene
		= [
			'userSearch' => [null],
			'create'     => [
				'condition_type',
				'send_content',
			],
			'surplus'    => [
				'condition_type',
				'send_time',
			],
			'del'        => ['id'],

		];

	protected function checkCondition( $value, $rule, $data )
	{
		if( !empty( $value ) ){

			if( isset( $value['sex'] ) ){
				$result = $this->checkSex( $value['sex'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['province'] ) ){
				$result = $this->checkProvince( $value['province'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['cost_average_price'] ) ){
				$result = $this->checkCostAveragePrice( $value['cost_average_price'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['cost_times'] ) ){
				$result = $this->checkCostTimes( $value['cost_times'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['resent_cost_time'] ) ){
				$result = $this->checkResentCostTime( $value['resent_cost_time'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['resent_visit_time'] ) ){
				$result = $this->checkResentVisitTime( $value['resent_visit_time'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['register_time'] ) ){
				$result = $this->checkRegisterTime( $value['register_time'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			if( isset( $value['user_tag'] ) ){
				$result = $this->checkUserTag( $value['user_tag'], $rule, $data );
				if( $result !== true ){
					return $result;
				}
			}
			return true;
		} else{
			return true;
		}
	}

	protected function checkIsTiming( $value, $rule, $data )
	{
		if( !in_array( $value, [0, 1] ) ){
			return '定时参数错误';
		}
		if( !isset( $data['send_time'] ) || $this->is( $data['send_time'], 'integer' ) !== true || time() > $data['send_time'] ){
			return '定时时间无效';
		} else{
			return true;
		}
	}

	protected function checkSendContent( $value, $rule, $data )
	{
		if( !isset( $value['type'] ) ){
			return "回复类型必填";
		}
		if( !in_array( $value['type'], ['text', 'image', 'news', 'voice', 'video', 'local_news'] ) ){
			return "回复类型不存在";
		}
		if( $value['type'] == 'text' && !isset( $value['content'] ) ){
			return "回复文本内容必填";
		}
		if( in_array( $value['type'], ['image', 'news', 'voice', 'video'] ) && !isset( $value['media_id'] ) ){
			return "微信用就素材id必填";
		}
		return true;
	}

	protected function checkSex( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'sex 数组格式错误';
		}
		foreach( $value as $item ){
			if( !in_array( $item, [1, 2, 3] ) ){
				return '没有该性别类型';
			}
		}
		return true;
	}

	protected function checkProvince( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'province 数组格式错误';
		}
		foreach( $value as $item ){
			if(
			!in_array( $item, [
				'北京',
				'天津',
				'上海',
				'重庆',
				'河北',
				'山西',
				'辽宁',
				'吉林',
				'黑龙江',
				'江苏',
				'浙江',
				'安徽',
				'福建',
				'江西',
				'山东',
				'河南',
				'湖北',
				'湖南',
				'广东',
				'海南',
				'四川',
				'贵州',
				'云南',
				'陕西',
				'甘肃',
				'青海',
				'台湾',
				'内蒙古自治区',
				'广西壮族自治区',
				'西藏自治区',
				'宁夏回族自治区',
				'新疆维吾尔自治区',
				'香港特别行政区',
				'澳门特别行政区',
			] )
			){
				return '没有该份';
			}
		}
		return true;
	}

	protected function checkCostAveragePrice( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'cost_average_price 数组格式错误';
		}
		foreach( $value as $item ){
			if( count( $item ) === 2 ){
				foreach( $item as $float ){
					if( $this->is( $float, 'float' ) !== true ){
						return '平均花费子格式错误';
					}
				}
			} else{
				return '平均花费参数格式错误';
			}
		}
		return true;
	}

	protected function checkCostTimes( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'cost_times 数组格式错误';
		}
		foreach( $value as $int ){
			if( $this->is( $int, 'integer' ) !== true ){
				return '消费频率格式错误';
			}
		}
		return true;
	}

	protected function checkResentCostTime( $value, $rule, $data )
	{
		foreach( $value as $item ){
			if( count( $item ) === 2 ){
				if( isset( $item[0] ) && isset( $item[1] ) && $this->is( $item[0], 'integer' ) && $this->is( $item[1], 'integer' ) && $item[0] > $item[1] ){
					return '格式错误 or 最近消费时间开始时间不能大于结束时间';
				}
			} else{
				return '最近消费时间格式错误';
			}
		}
		return true;
	}

	protected function checkResentVisitTime( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'resent_visit_time 数组格式错误';
		}
		foreach( $value as $item ){
			if( count( $item ) === 2 ){
				if( isset( $item[0] ) && isset( $item[1] ) && $this->is( $item[0], 'integer' ) && $this->is( $item[1], 'integer' ) && $item[0] > $item[1] ){
					return '格式错误 or 最近访问时间开始时间不能大于结束时间';
				}
			} else{
				return '最近访问时间格式错误';
			}
		}
		return true;
	}

	protected function checkRegisterTime( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'register_time 数组格式错误';
		}
		foreach( $value as $item ){
			if( count( $item ) === 2 ){
				if( isset( $item[0] ) && isset( $item[1] ) && $this->is( $item[0], 'integer' ) && $this->is( $item[1], 'integer' ) && $item[0] > $item[1] ){
					return '格式错误 or 最近注册时间开始时间不能大于结束时间';
				}
			} else{
				return '最近注册时间格式错误';
			}
		}
		return true;
	}

	protected function checkUserTag( $value, $rule, $data )
	{
		if( !is_array( $value ) ){
			return 'user_tag 数组格式错误';
		}
		foreach( $value as $item ){
			if( count( $item ) === 2 ){
				if( isset( $item[0] ) && isset( $item[1] ) && $this->is( $item[0], 'integer' ) && $this->is( $item[1], 'integer' ) && $item[0] > $item[1] ){
					return '格式错误 or 最近注册时间开始时间不能大于结束时间';
				}
			} else{
				return '最近注册时间格式错误';
			}
		}
		return true;
	}

}