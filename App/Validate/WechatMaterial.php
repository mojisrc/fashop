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
class WechatMaterial extends Validate {
    //验证
    protected $rule = [
        'path' => 'require|checkVoiceType',
        'video_path' => 'require',
        'title' => 'require',
        'description' => 'require',
        'article' => 'require|array|articleRule',
        'media_id' => 'require',
        'type' => 'require',

    ];
    //提示
    protected $message = [
        'path.require' => '请上传音频',
        'video_path.require' => '请上传视频',
        'title.require' => '请填写标题',
        'description.require' => '请填写描述',
        'article.array' => '图文消息必须是数组',
        'media_id.require' => 'media_id参数丢失',
        'type.require' => '素材的类型必选',
    ];
    //场景
    protected $scene = [
        'material_voice_add'=>[
            'path',
        ],
        'material_video_add'=>[
            'video_path',
            'title',
            'description',
        ],
        'material_article_add'=>[
            'article',
        ],
        'material_article_update'=>[
            'article',
            'media_id',
        ],
        'material_single'=>[
            'media_id',
        ],
        'material_list'=>[
            'type',
        ],
        'del'=>[
            'media_id',
        ]
    ];
    /**
     * 检查数据字段值
     * @method
     * @param $data
     * @datetime 2017/12/20 0020 上午 10:19
     * @author 邓凯
     */
    public function articleRule($data){
        foreach($data as $key => $val){
            if(!$val['title']){
                return '请输入标题';
            }
            if(!$val['thumb_media_id']){
                return 'media_id丢失';
            }
        }
        return true;
    }

    /**
     * 检查音频格式
     * @method
     * @param path 音频文件路径
     * @param $rule_arr 验证规则
     * @datetime 2017/12/20 0020 上午 10:19
     * @author 邓凯
     */
    public function checkVoiceType($path){
        $rule_arr = ['mp3','wma','wav','amr'];
        if(!Validate::in($value,$rule_arr)){
            return '音频格式错误';
        }
        return true;
    }




}