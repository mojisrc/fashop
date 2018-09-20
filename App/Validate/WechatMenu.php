<?php
namespace App\Validate;

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
 * @author 邓凯
 */
class WechatMenu extends Validate {
    //验证
    protected $rule = [
        'buttons' => 'require|array|menuRule',
    ];
    //提示
    protected $message = [
        'buttons.array' => '模板内容必须是数组',
    ];
    //场景
    protected $scene = [
        'menuCreate' => [
            'buttons',
        ],

    ];

    /**
     * 菜单检测
     * @method
     * @param $value 数据
     * @datetime 2017/1/5 0020 上午 15:00
     * @author 邓凯
     */
    protected function menuRule($value) {

        if (empty($value) || !is_array($value)) {
            return '菜单格式不正确';
        }

        $array = array();
        foreach ($value as $key => $val) {
            $array = $val['name'];
            if (!$val['name']) {
                return '菜单名称不能为空';
            }
            if (!empty($val['sub_button'])) {
                $bool = $this->Verification($val);
                if ($bool !== true) {
                    return $bool;
                }
            } else {
                $bool = $this->Verification($val);
                if ($bool !== true) {
                    return $bool;
                }
            }
        }
        return true;
    }

    /**
     * 菜单检测
     * @method
     * @param $data 数据
     * @datetime 2017/1/5 0020 上午 15:00
     * @author 邓凯
     */
    protected function Verification($data) {
        //需要检测相同下标的的类型声明一个数组存放
        $testing_one   = ['clike', 'scancode_push', 'scancode_waitmsg', 'pic_sysphoto', 'pic_photo_or_album', 'pic_weixin', 'location_select'];
        $testing_two   = ['view'];
        $testing_three = ['media_id', 'view_limited'];
        if (!empty($data['sub_button'])) {
            foreach ($data['sub_button'] as $sub_key => $sub_val) {
                if ($sub_val['type']) {
                    if (in_array($sub_val['type'], $testing_one)) {
                        if (!$sub_val['name']) {
                            return '菜单名称不能为空';
                        }
                        $key_bool = wechart_key($sub_val['key']);
                        if ($key_bool !== true) {
                            return $key_bool;
                        }
                    } elseif (in_array($sub_val['type'], $testing_two)) {
                        if (!$sub_val['name']) {
                            return '菜单名称不能为空';
                        }
                        if (!$sub_val['url']) {
                            return 'url地址不能为空';
                        }
                    } elseif (in_array($sub_val['type'], $testing_three)) {
                        if (!$sub_val['name']) {
                            return '菜单名称不能为空';
                        }
                        if (!$sub_val['media_id']) {
                            return '素材合法media_id不能为空';
                        }
                    } else {
                        return '菜单类型不符合';
                    }

                } else {
                    return '菜单类型必选';
                }
            }
        } else {
            if (in_array($data['type'], $testing_one)) {
                if (!$data['name']) {
                    return '菜单名称不能为空';
                }
                $key_bool = wechart_key($data['key']);
                if ($key_bool !== true) {
                    return $key_bool;
                }
            } elseif (in_array($data['type'], $testing_two)) {
                if (!$data['name']) {
                    return '菜单名称不能为空';
                }
                if (!$data['url']) {
                    return 'url地址不能为空';
                }
            } elseif (in_array($data['type'], $testing_three)) {
                if (!$data['name']) {
                    return '菜单名称不能为空';
                }
                if (!$data['media_id']) {
                    return '素材合法media_id不能为空';
                }
            } else {
                return '菜单类型必选';
            }
        }
        return true;
    }
}