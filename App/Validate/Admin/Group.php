<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/18
 * Time: 下午11:00
 *
 */

namespace App\Validate\Admin;

use ezswoole\Validate;
use ezswoole\Db;
use App\Logic\VerifyCode;

class Group extends Validate
{
	protected $rule
		= [
            'id'               => 'require|integer',
            'title'            => 'require',
            'time_over_day'    => 'require|integer',
            'time_over_hour'   => 'require|integer',
            'time_over_minute' => 'require|integer',
            'start_time'       => 'require|checkTime',
            'end_time'         => 'require|checkTime',
            'limit_buy_num'    => 'require|integer',
            'limit_group_num'  => 'require|integer',
            'limit_goods_num'  => 'require|integer',
            'group_id'         => 'require',
            'goods_id'         => 'require',
        ];
	protected $message
		= [
            'id.require'               => "id必须",
            'title.require'            => "名称必须",
            'time_over_day.require'    => "时限天数必须",
            'time_over_hour.require'   => "时限小时必须",
            'time_over_minute.require' => "时限分钟必须",
            'start_time.require'       => "开始时间必须",
            'end_time.require'         => "结束时间必须",
            'limit_buy_num.require'    => "拼团人数必须",
            'limit_group_num.require'  => "每位用户可进行的团数必须",
            'limit_goods_num.require'  => "用户每次参团时可购买件数必修",
            'group_id.require'         => '拼团活动id必须',
            'goods_id.require'         => '商品id必填',
        ];


	protected $scene
		= [
			'add' => [
				'title',
                'time_over_day',
                'time_over_hour',
                'time_over_minute',
                'start_time',
                'end_time',
                'limit_buy_num',
                'limit_group_num',
                'limit_goods_num',
            ],

			'edit' => [
				'id',
                'title',
                'time_over_day',
                'time_over_hour',
                'time_over_minute',
                'start_time',
                'end_time',
                'limit_buy_num',
                'limit_group_num',
                'limit_goods_num',
			],

			'info' => [
				'id',
			],

			'del' => [
				'id',
			],

            'selectableGoods' => [
                'group_id',
            ],

            'selectedGoods' => [
                'group_id',
            ],

            'goodsSkuList' => [
                'group_id',
                'goods_id',
            ],
		];

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkTime( $value, $rule, $data )
	{
        if(!check_date($data['start_time'], ["Y-m-d H:i:s"])){
            return '开始时间格式不正确';
        }
        if(!check_date($data['end_time'], ["Y-m-d H:i:s"])){
            return '结束时间格式不正确';
        }

	    if( strtotime($data['start_time']) >= strtotime($data['end_time']) ){
            return '结束时间必须大于开始时间';

        }

        if( ($data['time_over_day']*86400 + $data['time_over_hour']*3600 + $data['time_over_minute']*60) > (strtotime($data['end_time'])-strtotime($data['start_time'])) ){
            return '活动时限不能大于活动时间差';
        }else{
            $result = true;
        }
		return $result;

	}

	/**
	 * @access protected
	 * @param mixed $value 字段值
	 * @param mixed $rule  验证规则
	 * @return bool
	 */
	protected function checkOverType( $value, $rule, $data )
	{
		if( in_array( $value, [0,1] )){
			$result = true;
		} else{
			$result = '参数错误';

		}
		return $result;
	}


}