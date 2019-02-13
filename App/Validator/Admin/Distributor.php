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

class Distributor extends Validator
{
    protected $rule
        = [
            'id'       => 'require|integer',
            'nickname' => 'require',
            'state'    => 'require|checkState',
        ];

    protected $message
        = [
            'id.require'       => "id必须",
            'nickname.require' => "昵称必须",
            'state.require'    => "审核状态必须",

        ];

    protected $scene
        = [
            'info'    => [
                'id',
            ],
            'edit'    => [
                'id',
                'nickname',
            ],
            'retreat' => [
                'id',
            ],
            'review'  => [
                'id',
                'state',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkState($value, $rule, $data)
    {
        if (in_array($value, [1, 2])) {
            $result = true;
        } else {
            $result = '参数错误';

        }
        return $result;
    }
}