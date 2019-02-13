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

namespace App\Validator\Admin;

use ezswoole\Validator;

class DistributorLevel extends Validator
{
    protected $rule
        = [
            'id'            => 'require|integer',
            'title'         => 'require',
            'ratio'         => 'require|checkRatio',
            'invite_ratio'  => 'require|checkInviteRatio',
            'upgrade_rules' => 'require|checkUpgradeRules',
        ];

    protected $message
        = [
            'id.require'            => "id必须",
            'title.require'         => "名称必须",
            'ratio.require'         => "佣金比例必须",
            'invite_ratio.require'  => "邀请奖励佣金比例必须",
            'upgrade_rules.require' => "升级规则必须",
        ];

    protected $scene
        = [
            'info' => [
                'id',
            ],
            'add'  => [
                'title',
                'ratio',
                'invite_ratio',
                'upgrade_rules',
            ],
            'edit' => [
                'id',
                'title',
                'ratio',
                'invite_ratio',
                'upgrade_rules',
            ],
            'del'  => [
                'id',
            ],
        ];

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

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkUpgradeRules($value, $rule, $data)
    {
        //第一级不检查规则
        if (isset($data['id']) && $data['id'] == 1) {
            return true;
        }

        foreach ($value as $k => $v) {
            if (!in_array($v, ['promotion_amount', 'total_amount', 'customer_num', 'distributor_num'])) {
                return '规则错误';
            } else {
                switch ($v) {
                    case 'promotion_amount':
                        if (floatval($data['promotion_amount']) <= 0) {
                            return '推广金必须大于0';
                        }
                        break;
                    case 'total_amount':
                        if (floatval($data['total_amount']) <= 0) {
                            return '总金额必须大于0';
                        }
                        break;
                    case 'customer_num':
                        if (intval($data['customer_num']) <= 0) {
                            return '累计客户数必须大于0';
                        }
                        break;
                    case 'distributor_num':
                        if (intval($data['distributor_num']) <= 0) {
                            return '累计分销员数必须大于0';
                        }
                        break;
                }
            }
        }

        return true;
    }

}