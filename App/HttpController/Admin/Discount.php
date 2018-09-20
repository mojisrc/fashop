<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/4
 * Time: 下午5:51
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use ezswoole\Validate;

/**
 * 限时折扣
 * Class Shop
 * @package App\HttpController\Admin
 */
class Discount extends Admin
{

	/**
	 * 限时折扣活动列表
	 * @method GET
	 * @param string keywords   关键词 活动名称
	 * @param int    state 		活动状态 0未开始 1进行中 2已结束
	 */
	public function list()
	{
		$condition = [];
		if( $this->get['keywords'] ){
				$condition['title'] = ['like', '%'.$this->get['keywords'].'%'];
		}

		if( $this->get['state'] ){
			switch ($this->get['state']) {
				case 0:
					$condition['start_time'] = array('gt',time());
					break;

				case 1:
					$condition['start_time'] = array('elt',time());
					$condition['end_time']   = array('gt',time());
					break;

				case 2:
					$condition['end_time']   = array('elt',time());
					break;

			}
		}

		$discount_model = model( "Discount" );
		$count          = $discount_model->getDiscountCount( $condition );
		$list           = $discount_model->getDiscountList( $condition, '*', 'id desc', $this->getPageLimit() );
		return $this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 限时折扣活动详情
	 * @method GET
	 * @param int    id   		活动id
	 */
	public function info()
	{
		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Discount.info' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$condition 		 = [];
			$condition['id'] = $get['id'];
			$result          = [];
			$result['info']  = model( 'Discount' )->getDiscountInfo($condition, '*');
			return $this->send( Code::success, $result );
		}
	}

	/**
	 * 添加折扣活动
	 * @method POST
	 * @param string title   		活动名称
	 * @param string start_time 	活动开始时间 yyyy-mm-dd hh:ii：ss
	 * @param string end_time 		活动结束时间 yyyy-mm-dd hh:ii：ss
	 * @param int    limit_number 	限购件数 默认0不限制
	 */
	public function add()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Discount.add' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$post['start_time'] = strtotime($post['start_time']);
			$post['end_time']   = strtotime($post['end_time']);

			if(intval($post['start_time'])>=($post['end_time'])){
				return $this->send( Code::error, [], '开始时间必须小于结束时间' );

			}

			$post['create_time']= time();

			$result = model( 'Discount' )->insertDiscount( $post );
			if( $result ){
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 编辑折扣活动
	 * @method POST
	 * @param int    id   			活动id
	 * @param string title   		活动名称
	 * @param string start_time 	活动开始时间 yyyy-mm-dd hh:ii：ss
	 * @param string end_time 		活动结束时间 yyyy-mm-dd hh:ii：ss
	 * @param int    limit_number 	限购件数 默认0不限制
	 */
	public function edit()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Discount.edit' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$condition          = [];
			$condition['id']    = $post['id'];
			$post['start_time'] = strtotime($post['start_time']);
			$post['end_time']   = strtotime($post['end_time']);

			if(intval($post['start_time'])>=($post['end_time'])){
				return $this->send( Code::error, [], '开始时间必须小于结束时间' );

			}

			unset( $post['id'] );

			$result = model( 'Discount' )->updateDiscount( $condition, $post );

			if( $result ){
			return $this->send( Code::success, [], '修改成功' );
			} else{
				return $this->send( Code::error );
			}

		}
	}

	/**
	 * 删除折扣活动
	 * @method POST
	 * @param int id 活动id
	 */
	public function del()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Discount.del' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$condition       = [];
			$condition['id'] = $post['id'];

			$discount_model  = model( 'Discount' );

			$discount_model->startTrans();// 启动事务

			//查询活动
			$row             = $discount_model->getDiscountInfo( $condition, '*' );
			if( !$row ){
				$discount_model->rollback();// 回滚事务
				return $this->send( Code::param_error );
			}

			//删除活动
			$discount_result = $discount_model->delDiscount( $condition );

			if( !$discount_result ){
				$discount_model->rollback();// 回滚事务
				return $this->send( Code::error );
			}

			//删除活动下商品
			$discount_goods_model = model('DiscountGoods');
			$discount_goods_result = $discount_goods_model->delDiscountGoods( array('discount_id'=>$post['id']) );

			if( !$discount_goods_result ){
				$discount_model->rollback();// 回滚事务
				return $this->send( Code::error );
			}

		    $discount_model->commit();// 提交事务

			return $this->send( Code::success );
		}
	}


	/**
	 * 限时折扣活动可选择商品列表
	 * @method GET
	 * @param int 	 discount_id 限时折扣活动id
	 * @param string keywords 	 关键词 商品名称
	 * @param array  category_ids商品分类
	 */
	public function selectableGoods()
	{

		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Discount.selectableGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$discount_model 	  = model('Discount');
			$discount_goods_model = model('DiscountGoods');

			//查询活动
			$discount_data        = $discount_model->getDiscountInfo( array('id'=>$get['discount_id']), '*' );
			if( !$discount_data ){
				return $this->send( Code::param_error );
			}

			$param = [];
			if(isset($get['keywords'])){
				$param['title'] = $get['keywords'];
			}

			if(isset($get['category_ids'])){
				$param['category_ids'] = $get['category_ids'];
			}

			//查询活动商品ids
            $goods_ids = $discount_goods_model->getDiscountGoodsColumn(array('discount_id'=>$get['discount_id']), 'goods_id');
            if($goods_ids){
            	$param['not_in_ids'] = $goods_ids;
            }

			$goodsLogic = new \App\Logic\GoodsSearch( $param );
			return $this->send( Code::success, [
				'total_number' => $goodsLogic->count(),
				'list'         => $goodsLogic->list(),
			] );

		}

	}

	/**
	 * 限时折扣活动已选择商品列表
	 * @method GET
	 * @param int 	 discount_id 限时折扣活动id
	 */
	public function selectedGoods()
	{

		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Discount.selectedGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$discount_model 	  = model('Discount');
			$discount_goods_model = model('DiscountGoods');


			//查询活动
			$discount_data        = $discount_model->getDiscountInfo( array('id'=>$get['discount_id']), '*' );
			if( !$discount_data ){
				return $this->send( Code::param_error );
			}

			//查询活动商品ids
            $goods_ids = $discount_goods_model->getDiscountGoodsColumn(array('discount_id'=>$get['discount_id']), 'goods_id');
            if($goods_ids){
				$online_goods_ids = model('Goods')->getGoodsColumn(array('in'=>$goods_ids,'is_on_sale'=>1), 'id');
            }

            //交集 discount_goods表和goods表的商品交集
			$intersection_goods_ids  = array_values(array_intersect($goods_ids,$online_goods_ids));

			//删除活动下失效商品
			$discount_goods_result = $discount_goods_model->delDiscountGoods( array('discount_id'=>$get['discount_id'],'goods_id'=>array('not in',$intersection_goods_ids)) );
			if( !$discount_goods_result ){
				return $this->send( Code::error );
			}

			$param 		  = [];
            $param['ids'] = $intersection_goods_ids;

			$goodsLogic = new \App\Logic\GoodsSearch( $param );
			return $this->send( Code::success, [
				'total_number' => $goodsLogic->count(),
				'list'         => $goodsLogic->list(),
			] );

		}

	}

	/**
	 * 限时折扣活动选择商品
	 * @method POST
	 * @param int 	 discount_id 限时折扣活动id
	 * @param array  goods_ids   商品id
	 */
	public function choiceGoods()
	{

		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Discount.choiceGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$goods_sku_model 	  = model('GoodsSku');
			$discount_goods_model = model('DiscountGoods');

			$goods_sku_data = $goods_sku_model->getGoodsSkuList( array('goods_id'=>array('in',$post['goods_ids'])), 'id AS goods_sku_id,goods_id', 'goods_id asc,goods_sku_id asc', '' );
			if(!$goods_sku_data){
				return $this->send( Code::param_error );

			}

			foreach ($goods_sku_data as $key => $value) {
				$goods_sku_data[$key]['discount_id'] = $post['discount_id'];
				$goods_sku_data[$key]['create_time'] = time();
			}

			$result = $discount_goods_model->insertAllDiscountGoods($goods_sku_data);

			if( !$result ){
				return $this->send( Code::error );
			}

			return $this->send( Code::success );

		}

	}

    /**
     * 限时折扣活动已选择商品sku列表
     * @method GET
     * @param int    discount_id 限时折扣活动id
     * @param int    goods_id    限时折扣活动商品id
     */
    public function goodsSkuList()
    {

        $get  = $this->get;
        $error = $this->validate( $get, 'Admin/Discount.goodsSkuList' );
        if( $error !== true ){
            return $this->send( Code::error, [], $error );
        } else{

            $discount_model       = model('Discount');
            $discount_goods_model = model('DiscountGoods');
			$goods_sku_model 	  = model('GoodsSku');

            //查询活动
            $discount_data        = $discount_model->getDiscountInfo( array('id'=>$get['discount_id']), '*' );
            if( !$discount_data ){
                return $this->send( Code::param_error );
            }

            $condition = array();
            $condition['goods_sku.goods_id'] = $get['goods_id'];

            //查询该商品下所有sku和已设置折扣的数据
            $goods_sku_count = $discount_goods_model->getGoodsSkuMoreCount($condition);
			$goods_sku_list  = $discount_goods_model->getGoodsSkuMoreList($condition, 'goods_sku.*,discount_goods.discounts,minus,price,discount_id', 'goods_sku.id asc', '');

            return $this->send( Code::success, [
                'total_number' => $goods_sku_count,
                'list'         => $goods_sku_list,
            ] );

        }

    }

    /**
     * 修改限时折扣活动已选择商品sku
     * @method GET
     * 传过来是一个二维数组 里面的每个子数组下面有如下数据
     * @param int    discount_id 	限时折扣活动id
     * @param int    goods_id    	限时折扣活动商品id
     * @param int    goods_sku_id   限时折扣活动商品sku id
     * @param float  discounts 		XXX折
     * @param float  minus    		立减XXX元
     * @param float  price   		打折后XXX元
     */
    public function editGoodsSku(){
	    //post数据格式
		// array(
		// 	'discount_id'	=>100,
		// 	'goods_id'		=>100,
		// 	'goods_sku'		=>array(

		// 		0=>array(
		// 			'goods_sku_id'	=>12,
		// 			'discounts' 	=> 1,
		// 			'minus' 		=> 1.2,
		// 			'price' 		=> 1.2,
		// 		),

		// 		1=>array(
		// 			'goods_sku_id'	=>12,
		// 			'discounts' 	=> 1,
		// 			'minus' 		=> 1.2,
		// 			'price' 		=> 1.2,
		// 		),

		// 		2=>array(
		// 			'goods_sku_id'	=>12,
		// 			'discounts' 	=> 1,
		// 			'minus' 		=> 1.2,
		// 			'price' 		=> 1.2,
		// 		),

		// 	)

		// );

		$post  = $this->post;

		$error = $this->validate( $post, 'Admin/Discount.editGoodsSku' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );

		} else{
            $discount_goods_model = model('DiscountGoods');
			$goods_sku_model 	  = model('GoodsSku');

            $discount_goods_model->startTrans();// 启动事务

			//为空代表删除所有goods_sku
			if(empty($post['goods_sku'])){

				$condition = array();
				$condition['discount_id'] = $post['discount_id'];
				$condition['goods_id'] = $post['goods_id'];

	            //删除活动下商品
	            $discount_goods_result = $discount_goods_model->delDiscountGoods( $condition );
	            if( !$discount_goods_result ){
	            	$discount_goods_model->rollback();// 回滚事务
	                return $this->send( Code::error );
	            }

			}else{
				$post_goods_sku = $post['goods_sku'];
				foreach ($post_goods_sku as $key => $value) {
					$post_goods_sku[$key]['discount_id'] = $post['discount_id'];
					$post_goods_sku[$key]['goods_id'] 	 = $post['goods_id'];
					$post_goods_sku[$key]['create_time'] = time();

				}

				//查询活动商品sku ids
	            $goods_sku_ids = $discount_goods_model->getDiscountGoodsColumn($condition, 'goods_sku_id');

	            if($goods_sku_ids){

					$post_goods_sku_ids = array_column($post_goods_sku,'goods_sku_id');

					//交集
					$intersection_goods_sku_ids   = array_intersect($goods_sku_ids,$post_goods_sku_ids);

					//返回出现在第一个数组中但其他数组中没有的值 [新添加的sku]
					$difference_goods_sku_add_ids = array_diff($goods_sku_ids,$post_goods_sku_ids);

					//返回出现在第一个数组中但其他数组中没有的值 [已删除的sku]
					$difference_goods_sku_del_ids  = array_diff($post_goods_sku_ids,$goods_sku_ids);


					//交集
					if($intersection_goods_sku_ids){
						$discount_goods_updata = array();

						foreach ($post_goods_sku as $key => $value) {
							if(in_array($value['goods_sku_id'], $intersection_goods_sku_ids)){
								$discount_goods_updata[] = $value;
							}
						}

						$result = array();
						$result = $discount_goods_model->updateAllDiscountGoods($discount_goods_updata);
						if( !$result ){
							$discount_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}

					}

					//差集 [新添加的sku]
					if($difference_goods_sku_add_ids){
						$discount_goods_insert_data = array();

						foreach ($post_goods_sku as $key => $value) {
							if(in_array($value['goods_sku_id'], $difference_goods_sku_add_ids)){
								$discount_goods_insert_data[] = $value;
							}
						}

						$result = array();
						$result = $discount_goods_model->insertAllDiscountGoods($discount_goods_insert_data);
						if( !$result ){
							$discount_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}
					}

					//差集 [已删除的sku]
					if($difference_goods_sku_del_ids){
						$condition['goods_sku_id'] = array('in',$difference_goods_sku_del_ids);
						$result = array();
						$result = $discount_goods_model->delDiscountGoods($condition);

						if( !$result ){
							$discount_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}

					}

	            }else{
	            	$result = array();
					$result = $discount_goods_model->insertAllDiscountGoods($post_goods_sku);
					if( !$result ){
						$discount_goods_model->rollback();// 回滚事务
						return $this->send( Code::error );
					}

	            }


			}

            $discount_goods_model->commit();// 提交事务
			return $this->send( Code::success );

		}

    }


}