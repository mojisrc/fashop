<?php

namespace App\Validator\Server;

use ezswoole\Validator;


/**
 * 分销员
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
class Distributor extends Validator
{
    //验证
    protected $rule
        = [
            'distributor_user_id' => 'require|checkDistributor',
            'user_id'             => 'require|checkUser',
        ];
    //提示
    protected $message
        = [
            'distributor_user_id.require' => '分销员用户id必须',
            'user_id.require'             => '用户id必填',
        ];
    //场景
    protected $scene
        = [
            'inviteCustomer' => [
                'distributor_user_id',
                'user_id',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkDistributor($value, $rule, $data)
    {
        if ($value <= 0) {
            return '参数错误';
        } else {
            $user_model        = new \App\Model\User;
            $distributor_model = new \App\Model\Distributor;

            $user = $user_model->getUserInfo(['id' => $value, 'phone IS NOT NULL'], '*');
            if (!$user) {
                return '分销员用户信息异常';
            }

            $distributor = $distributor_model->getDistributorInfo(['user_id' => $value, 'state' => 1, 'is_retreat' => 0]);
            if (!$distributor) {
                return '分销员信息异常';
            }
        }

        return true;
    }

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkUser($value, $rule, $data)
    {
        if ($value <= 0) {
            $result = '参数错误';

        } else {
            $user_model = new \App\Model\User;
            $user       = $user_model->getUserInfo(['id' => $value], '*');
            if (!$user) {
                return '用户信息异常';
            }
        }
        return true;
    }


}