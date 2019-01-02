<?php
/**
 *
 * 配置
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 配置
 * Class Setting
 * @package App\HttpController\Admin
 */
class Setting extends Admin
{
    /**
     * 配置信息
     * @method GET
     * @param string key
     * @author 孙泉
     */
    public function info()
    {
        $get   = $this->get;
        $error = $this->validate($get, 'Admin/Setting.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $setting_model    = model('Setting');
            $condition        = [];
            $condition['key'] = $get['key'];
            $info             = $setting_model->getSettingInfo($condition);
            return $this->send(Code::success, ['info' => $info]);
        }
    }

    /**
     * 添加配置
     * @method POST
     * @param string key              键值
     * @param string name             名称
     * @param array  config           配置
     * @param int    status           接口状态0禁用1启用
     * @param string remark           备注 非必须
     */
    public function add()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Setting.add');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $setting_model = model('Setting');

            $setting_data = $setting_model->getSettingInfo(['key' => $post['key']]);
            if ($setting_data) {
                return $this->send(Code::param_error, [], '已经存在该配置');
            } else {
                $data           = [];
                $data['key']    = $post['key'];
                $data['name']   = $post['name'];
                $data['config'] = $post['config'];
                $data['status'] = $post['status'];
                $data['remark'] = $post['remark'];
                $result = $setting_model->insert($data);
                if (!$result) {
                    return $this->send(Code::error);
                }
                return $this->send(Code::success);
            }
        }
    }

    /**
     * 编辑配置
     * @method POST
     * @method POST
     * @param string key              键值
     * @param string name             名称
     * @param array  config           配置
     * @param int    status           接口状态0禁用1启用
     * @param string remark           备注 非必须
     */
    public function edit()
    {
        $post  = $this->post;
        $error = $this->validate($post, 'Admin/Setting.edit');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $setting_model = model('Setting');

            $setting_data = $setting_model->getSettingInfo(['key' => $post['key']]);
            if (!$setting_data) {
                return $this->send(Code::param_error, [], '配置不存在');
            } else {
                $condition        = [];
                $condition['key'] = $post['key'];
                $data             = [];
                $data['name']     = $post['name'];
                $data['config']   = $post['config'];
                $data['status']   = $post['status'];
                $data['remark']   = $post['remark'];

                $result = $setting_model->updateSetting($condition, $data);
                if (!$result) {
                    return $this->send(Code::error);
                }
                return $this->send(Code::success);
            }
        }
    }

}