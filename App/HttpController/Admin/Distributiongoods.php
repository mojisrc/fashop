<?php
/**
 *
 * 分销商品
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
 * 分销商品
 * Class DistributionGoods
 * @package App\HttpController\Admin
 */
class Distributiongoods extends Admin
{

	/**
	 * 分销商品---有效的商品列表（库存大于0并且上架状态） TODO 此接口设计图估计有变动 待优化吧
	 * @method GET
	 * @param string title                商品名称
	 * @param array  category_ids         分类id 数组格式
	 * @param array  distribution_state   分销状态  0代表关闭分销或者代表没有设置分销 1开启分销
	 */
	public function list()
	{
		$get                      = $this->get;
		$distribution_goods_model = new \App\Model\DistributionGoods;
		$param['is_on_sale']      = 1;
		$param['stock']           = 1; //查询库存大于0
		if( isset( $get['title'] ) ){
			$param['title'] = $get['title'];
		}

		if( isset( $get['category_ids'] ) ){
			$param['category_ids'] = $get['category_ids'];
		}

		if( isset( $get['distribution_state'] ) ){
            //查询开启参与的分销的商品id
			$goods_ids            = $distribution_goods_model->getDistributionGoodsColumn( ['is_show' => 1], 'goods_id' );
			if( $goods_ids ){
				if( intval( $get['distribution_state'] ) == 1 ){
                    //参与的 distribution_goods表is_show为1的商品
					$param['ids'] = $goods_ids;
				} else{
                    //不参与的  distribution_goods表is_show不为1 [包含distribution_goods表is_show为0的商品 和 不在distribution_goods表的商品]
					$param['not_in_ids'] = $goods_ids;
				}
			}
		}

        $distribution_goods_list = $distribution_goods_model->getDistributionGoodsList( [], 'is_show,goods_id', 'id desc', '');

		$param['page']      = $this->getPageLimit();
		$goodsLogic         = new \App\Logic\GoodsSearch( $param );
		$goods_count        = $goodsLogic->count();
		$goods_list         = $goodsLogic->list();

		if( $goods_list){
		    if($distribution_goods_list){
		        foreach ($distribution_goods_list as $key => $value) {
                    $distribution_goods[$value['goods_id']] = $value['is_show'];
		        }
                foreach( $goods_list as $key => $value ){
                    if( isset( $distribution_goods[$value['id']] ) ){
                        $goods_list[$key]['distribution_state'] = $distribution_goods[$value['id']];
                    } else{
                        $goods_list[$key]['distribution_state'] = 0; //0代表关闭分销或者代表没有设置分销 1开启分销
                    }
                }
            }else{
                foreach( $goods_list as $key => $value ){
                    $goods_list[$key]['distribution_state'] = 0; //0代表关闭分销或者代表没有设置分销 1开启分销
                }
            }
		}
		return $this->send( Code::success, [
			'total_number' => $goods_count,
			'list'         => $goods_list,
		] );
	}

	/**
	 * 分销商品信息
	 * @method GET
	 * @param int id 数据id
	 * @author 孙泉
	 */
	public function info()
	{
		$get   = $this->get;
		$error = $this->validator( $get, 'Admin/DistributionGoods.info' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$distribution_goods_model = new \App\Model\DistributionGoods;
			$condition['id']          = $get['id'];
			$field                    = '*';
			$info                     = $distribution_goods_model->getDistributionGoodsInfo( $condition, $field );
			return $this->send( Code::success, ['info' => $info] );
		}

	}

	/**
	 * 分销商品编辑
	 * @method POST
	 * @param int goods_id          商品id
	 * @param int ratio             佣金比例
	 * @param int invite_ratio      邀请奖励佣金比例
	 * @param int is_show           是否正在执行 0未执行 1执行
	 * @param int type              0默认结算方式 1商品自定义
	 * 如果没有设置分销 则会创建一条数据
	 */
	public function edit()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/DistributionGoods.edit' );
		if( $error !== true ){
			$this->send( Code::error, [], $error );
		} else{
			$goods_condition['is_on_sale'] = 1;
			$goods_condition['stock']      = ['>', 0]; //查询库存大于0
			$goods_condition['id']         = $post['goods_id'];
			$goods_info                    = \App\Model\Goods::init()->getGoodsInfo( $goods_condition, '*' );
			if( !$goods_info ){
				$this->send( Code::param_error, [], '商品信息不存在' );
			} else{
				$distribution_goods_model = new \App\Model\DistributionGoods;
				$condition['goods_id']    = $post['goods_id'];
				$distribution_goods_info  = $distribution_goods_model->getDistributionGoodsInfo( $condition );
				if( !$distribution_goods_info ){
					$insert_data['goods_id']     = $post['goods_id'];
					$insert_data['ratio']        = floatval( $post['ratio'] );
					$insert_data['invite_ratio'] = floatval( $post['invite_ratio'] );
					$insert_data['is_show']      = intval( $post['is_show'] );
					$insert_data['type']         = intval( $post['type'] );
					$insert_data['update_time']  = time();
					$result                      = $distribution_goods_model->insertDistributionGoods( $insert_data );
				} else{
					$update_data['ratio']        = floatval( $post['ratio'] );
					$update_data['invite_ratio'] = floatval( $post['invite_ratio'] );
					$update_data['is_show']      = intval( $post['is_show'] );
					$update_data['type']         = intval( $post['type'] );
					$update_data['update_time']  = time();
					$result                      = $distribution_goods_model->updateDistributionGoods( ['id' => $distribution_goods_info['id']], $update_data );
				}

				if( $result ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			}
		}
	}

}