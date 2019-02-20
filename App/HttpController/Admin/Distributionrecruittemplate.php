<?php
/**
 *
 * 分销招募计划模板
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;

use App\Utils\Code;

/**
 * 分销招募计划模板
 * Class Distributionrecruittemplate
 * @package App\HttpController\Admin
 */
class Distributionrecruittemplate extends Admin
{
    /**
     * 模板列表
     * @method GET
     * @param string $keywords 关键词 活动名称
     * @param int $state 状态 0未开始 10进行中 20已结束 30已失效
     */
    public function list()
    {
        $get                                 = $this->get;
        $condition                           = [];
        $distribution_recruit_template_model = new \App\Model\DistributionRecruitTemplate;
        $count                               = $distribution_recruit_template_model->getDistributionRecruitTemplateCount($condition);
        $list                                = $distribution_recruit_template_model->getDistributionRecruitTemplateList($condition, '*', 'id desc', $this->getPageLimit());
        $this->send(Code::success, [
            'total_number' => $count,
            'list'         => $list,
        ]);
    }

    /**
     * 模板信息
     * @method GET
     * @param int $id
     * @author 孙泉
     */
    public function info()
    {
        $get   = $this->get;
        $error = $this->validator($get, 'Admin/DistributionRecruitTemplate.info');
        if ($error !== true) {
            return $this->send(Code::error, [], $error);
        } else {
            $condition['id']                     = $get['id'];
            $field                               = '*';
            $distribution_recruit_template_model = new \App\Model\DistributionRecruitTemplate;
            $info                                = $distribution_recruit_template_model->getDistributionRecruitTemplateInfo($condition, $field);
            $this->send(Code::success, ['info' => $info]);
        }
    }


}