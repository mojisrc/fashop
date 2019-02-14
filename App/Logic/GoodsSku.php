<?php
/**
 * 商品业务逻辑层
 *
 *
 *
 *
 * @copyright  Copyright (c) 2019 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class GoodsSku
{

    /**
     * @var \App\Model\GoodsSku
     */
    private $model;

    /**
     * @return \App\Model\GoodsSku
     */
    public function getModel(): \App\Model\GoodsSku
    {
        if (!$this->model instanceof \App\Model\GoodsSku) {
            $this->model = new \App\Model\GoodsSku;
        }
        return $this->model;
    }

    /**
     * @var array
     */
    private $skus;
    /**
     * @var int
     */
    private $goodsId;
    /**
     * @var string
     */
    private $goodsTitle;

    /**
     * @return string
     */
    public function getGoodsTitle(): string
    {
        return $this->goodsTitle;
    }

    /**
     * @param string $goodsTitle
     */
    public function setGoodsTitle(string $goodsTitle): void
    {
        $this->goodsTitle = $goodsTitle;
    }

    public function __construct(array $options)
    {
        if (isset($options['goods_id'])) {
            $this->goodsId = $options['goods_id'];
        }
        if (isset($options['goods_title'])) {
            $this->goodsTitle = $options['goods_title'];
        }
        if (isset($options['skus'])) {
            $this->skus = $options['skus'];
        }
    }

    /** todo spec id 验证int
     * @return bool
     * @throws \Exception
     */
    public function add(): bool
    {
        $now_time = time();
        foreach ($this->skus as $key => $sku) {
            // 生成以id升序的spec_sign
            $spec_ids = array_column($sku['spec'], 'id');
            asort($spec_ids);
            // 生成以id升序的spec_sign
            $spec_values_ids = array_column($sku['spec'], 'value_id');
            asort($spec_values_ids);

            // 名字可能有个需求 就是规格名的前后顺序
            $addData[$key] = [
                'title'           => $this->goodsTitle . " " . implode(" ", array_column($sku['spec'], 'value_name')),
                'goods_id'        => $this->goodsId,
                'spec'            => json_encode($sku['spec']),
                'spec_sign'       => json_encode(array_values($spec_ids)),
                'spec_value_sign' => json_encode(array_values($spec_values_ids)),
                'price'           => $sku['price'],
                'stock'           => $sku['stock'],
                'create_time'     => $now_time,
            ];
            if (isset($sku['weight'])) {
                $addData[$key]['weight'] = $sku['weight'];
            }
            if (isset($sku['code'])) {
                $addData[$key]['code'] = $sku['code'];
            }
            if (isset($sku['img'])) {
                $addData[$key]['img'] = $sku['img'];
            }
        }
        $count = $this->getModel()->addMultiGoodsSku($addData);
        if ($count > 0) {
            return true;
        } else {
            throw new \Exception("goods sku add fail {$this->getModel()->getError()}");
        }
    }

    /**
     * todo spec id 验证int
     * @return bool
     * @throws \Exception
     */
    public function edit(): bool
    {
        $now_time    = time();
        $update_ids  = [];
        $update_skus = [];
        $add_skus    = [];
        $exist_skus  = $this->getModel()->getGoodsSkuList(['goods_id' => $this->goodsId], '*', 'id desc', [1,1000]);
        if ($exist_skus) {
            $exist_skus = array_column($exist_skus, null, 'spec_value_sign');
        }
        $exist_spec_value_signs = array_column($exist_skus, 'spec_value_sign');
        $exist_ids              = array_column($exist_skus, 'id');
        // 对比 spec_value_signs 来判断是否存在
        foreach ($this->skus as $sku) {
            // 生成以id升序的spec_sign
            $spec_ids = array_column($sku['spec'], 'id');
            asort($spec_ids);
            // 生成以id升序的spec_sign
            $spec_values_ids = array_column($sku['spec'], 'value_id');
            asort($spec_values_ids);
            $sku['spec_sign']       = json_encode(array_values($spec_ids));
            $sku['spec_value_sign'] = json_encode(array_values($spec_values_ids));
            if (in_array($sku['spec_value_sign'], $exist_spec_value_signs)) {
                $sku['id']     = $exist_skus[$sku['spec_value_sign']]['id'];
                $update_ids[]  = $sku['id'];
                $update_skus[] = $sku;
            } else {
                $add_skus[] = $sku;
            }
        }

        //查询是否涉及到拼团
        $logic_group = new \App\Logic\Group(['goods_id' => $this->goodsId, 'goods_skus' => $update_skus]);
        $have_goods  = $logic_group->haveGoods();
        if ($have_goods) {
            if (!$update_skus) {
                return true; //说明sku有变动(前端错误提交) 无需修改 直接返回
            }
            $filter_update_skus = $logic_group->filteGoodsSku();

            if ($filter_update_skus) {

                $state = $this->getModel()->editMulti($filter_update_skus['goods_skus']);
                if ($state === false) {
                    throw new \Exception("goods sku update all fail");
                }

                $goods_state = \App\Model\Goods::init()->editGoods(['id' => $this->goodsId], ['sku_list' => $filter_update_skus['sku_list'], 'stock' => array_sum(array_column($filter_update_skus['sku_list'], 'stock'))]);
                if (!$goods_state) {
                    throw new \Exception("sku_list update fail");
                }

            }
            return true;
        }


        // 删除不存在
        $del_ids = array_diff($exist_ids, $update_ids);
        if (!empty($del_ids)) {
            // 删除不存在的商品
            foreach ($del_ids as $del_id) {
                $state = $this->getModel()->delGoodsSku(['id' => $del_id]);
                if ($state === false) {
                    throw new \Exception("goods sku del fail");
                }
            }
        }
        // 添加新的
        if (!empty($add_skus)) {
            foreach ($add_skus as $key => $sku) {
                $addData[$key] = [
                    'title'           => $this->goodsTitle . " " . implode(" ", array_column($sku['spec'], 'value_name')),
                    'goods_id'        => $this->goodsId,
                    'spec'            => json_encode($sku['spec']),
                    'spec_sign'       => $sku['spec_sign'],
                    'spec_value_sign' => $sku['spec_value_sign'],
                    'price'           => $sku['price'],
                    'stock'           => $sku['stock'],
                    'create_time'     => $now_time,
                ];
                if (isset($sku['weight'])) {
                    $addData[$key]['weight'] = $sku['weight'];
                }
                if (isset($sku['code'])) {
                    $addData[$key]['code'] = $sku['code'];
                }
                if (isset($sku['img'])) {
                    $addData[$key]['img'] = $sku['img'];
                }
            }
            $count = $this->getModel()->addMultiGoodsSku($addData);
            if (!$count) {
                throw new \Exception("goods sku add all fail");
            }
        }
        // 修改老的 老的修改需要
        if (!empty($update_skus)) {
            foreach ($update_skus as $key => $sku) {

                $update_skus[$key] = [
                    'id'    => $sku['id'],
                    'price' => $sku['price'],
                    'stock' => $sku['stock'],
                ];
                if (isset($sku['weight'])) {
                    $update_skus[$key]['weight'] = $sku['weight'];
                }
                if (isset($sku['code'])) {
                    $update_skus[$key]['code'] = $sku['code'];
                }
                if (isset($sku['img'])) {
                    $update_skus[$key]['img'] = $sku['img'];
                }
            }
            // 不可以通过model 进行转换json等type约定
            $state = $this->getModel()->editMulti($update_skus);
            if ($state === false) {
                throw new \Exception("goods sku update all fail");
            }
        }
        return true;
    }

    /**
     * @param array $ids
     * @return bool
     * @throws \Exception
     */
    public function del(array $ids)
    {
        $state = $this->getModel()->delGoodsSku(['id' => $ids]);
        if ($state !== true) {
            throw new \Exception("goods sku del fail");
        } else {
            return true;
        }
    }

    public static function init(array $options = []): GoodsSku
    {
        return new static($options);
    }
}
