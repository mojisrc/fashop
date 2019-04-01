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

class DistributorThresholdGoods extends Validator
{
    protected $rule
        = [
            'ids'       => 'require||checkIds',
            'goods_ids' => 'require|checkGoodsIds',
        ];

    protected $message
        = [
            'ids.require'       => "id必须",
            'goods_ids.require' => "商品id必须",
        ];

    protected $scene
        = [

            'add' => [
                'goods_ids',
            ],
            'del' => [
                'ids',
            ],
        ];

    /**
     * @access protected
     * @param mixed $value 字段值
     * @param mixed $rule 验证规则
     * @return bool
     */
    protected function checkIds($value, $rule, $data)
    {
        if (!is_array($value)) {
            $result = '参数错误';

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
    protected function checkGoodsIds($value, $rule, $data)
    {
        if (!is_array($value)) {
            $result = '参数错误';

        } else {
            $result = true;
        }

        return $result;
    }


}