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

namespace App\Validator\Admin;

use ezswoole\Validator;

class Setting extends Validator
{
    protected $rule
        = [
            'key'    => 'require|checkKey',
            'name'   => 'require',
            'config' => 'require|checkConfig', //TODO 验证每个键值对应的config
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
                'config',
                'status',
            ],

            'edit' => [
                'id',
                'key',
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
    protected function checkKey($value, $rule, $data)
    {
        if (in_array($value, ['alidayu', 'alipay', 'poster_goods', 'poster_group_goods', 'wechat', 'wechat_mini_template'])) {
            $result = true;
        } else {
            $result = '键值错误';
        }
        return $result;
    }

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

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkConfig($value, $rule, $data)
    {
        $result = true;
        if ($data['key'] == 'alidayu') {
            if (!$value['access_key_id']) {
                $result = 'Access KeyID必须';
            }
            if (!$value['access_key_secret']) {
                $result = 'Access KeySecret必须';
            }
            if (!$value['signature']) {
                $result = '短信签名必须';
            }

        }
        if ($data['key'] == 'alipay') {
            if (!$value['app_id']) {
                $result = '支付宝AppId必须';
            }
            if (!$value['alipay_public_key']) {
                $result = '支付宝公钥必须';
            }
            if (!$value['merchant_private_key']) {
                $result = '商户私钥必须';
            }
            if (!$value['callback_domain']) {
                $result = '回调域名必须';
            }
        }
        if ($data['key'] == 'poster_goods') {

        }
        if ($data['key'] == 'poster_group_goods') {

        }
        if ($data['key'] == 'wechat') {

            if (!$value['mch_id']) {
                $result = '微信商户ID必须';
            }
            if (!$value['key']) {
                $result = '微信商户API密钥名必须';
            }
            if (!$value['appid'] && !$value['app_id'] && !$value['mini_app_id']) {
                $result = '至少需要填写一种appid';
            }
            if (!$value['callback_domain']) {
                $result = '回调域名必须';
            }
        }
        if ($data['key'] == 'wechat_mini_template') {

        }

        return $result;
    }

}