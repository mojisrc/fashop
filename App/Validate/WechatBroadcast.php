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
class WechatBroadcast extends Validate {
    //验证
    protected $rule = [
        'mediaId' => 'require',
        'fun_name' => 'require|broadcast_fun_Rule',
        'path' => 'require',
        'title' => 'require',
        'desc' => 'require',
    ];
    //提示
    protected $message = [
        'mediaId.require' => '素材id丢失',
        'fun_name.require' => '方法名不存在',
        'path.require'=>'视频文件不存在',
        'title.require'=>'请输入视频标题',
        'desc.require'=>'请输入视频描述',
    ];
    //场景
    protected $scene = [
        'sendBroadcast' => [
            'mediaId',
            'fun_name',
        ],
        'sendVideoGroup'=>[
            'path',
            'title',
            'desc'
        ]
    ];


    //验证方法名是否存在在指定的范围
    protected function  broadcast_fun_Rule($value){
        $funs = ['sendNews','sendImage','sendVoice'];
        if(!in_array($value['fun_name'],$funs)){
            return '方法名无效';
        }
    }

}