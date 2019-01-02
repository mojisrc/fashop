<?php
/**
 * 配置
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

class Setting extends Validate
{
    protected $rule
        = [
            'key'    => 'require',
            'name'   => 'require',
            'config' => 'require', //TODO 验证每个键值对应的config
            'status' => 'require|checkStatus',

        ];
    protected $message
        = [
            'key.require'    => "键值必须",
            'name.require'   => "名称必须",
            'config.require' => "配置必须",
            'status.require' => "状态必须",
        ];


    protected $scene
        = [
            'info' => [
                'key',
            ],

            'add' => [
                'key',
                'name',
                'config',
                'status',
            ],

            'edit' => [
                'id',
                'key',
                'name',
                'config',
                'status',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkStatus($value, $rule, $data)
    {
        if (in_array($value, [0, 1])) {
            $result = true;
        } else {
            $result = '参数错误';
        }
        return $result;
    }


}