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

class DistributionGoods extends Validate
{
    protected $rule
        = [
            'id'           => 'require|integer',
            'goods_id'     => 'require|integer',
            'ratio'        => 'require|checkRatio',
            'invite_ratio' => 'require|checkInviteRatio',
            'type'         => 'require|checkType',
            'is_show'      => 'require|checkIsShow',

        ];

    protected $message
        = [
            'id.require'           => "id必须",
            'goods_id.require'     => "goods_id必须",
            'ratio.require'        => "佣金比例必须",
            'invite_ratio.require' => "邀请奖励佣金比例必须",
            'type.require'         => "佣金类型必须",
            'is_show.require'      => "状态必须",

        ];

    protected $scene
        = [
            'info' => [
                'id',
            ],
            'edit' => [
                'goods_id',
                'ratio',
                'invite_ratio',
                'is_show',
                'type',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkIsShow($value, $rule, $data)
    {
        if (in_array($value, [0, 1])) {
            $result = true;
        } else {
            $result = '参数错误';

        }
        return $result;
    }


    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkType($value, $rule, $data)
    {
        if (in_array($value, [0, 1])) {
            $result = true;
        } else {
            $result = '参数错误';

        }
        return $result;
    }

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkRatio($value, $rule, $data)
    {
        if (floatval($value) <= 0.01 || floatval($value) > 100) {
            $result = '允许输入比例为0.01-100，保留两位小数';

        } else {
            $result = true;
        }

        return $result;
    }

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkInviteRatio($value, $rule, $data)
    {
        if (floatval($value) <= 0.01 || floatval($value) > 100) {
            $result = '允许输入比例为0.01-100，保留两位小数';

        } else {
            $result = true;
        }
        return $result;
    }

}