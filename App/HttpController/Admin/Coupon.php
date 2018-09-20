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
 * 优惠券
 * Class Shop
 * @package App\HttpController\Admin
 */
class Coupon extends Admin
{

	/**
	 * 优惠券列表
	 * @method GET
	 * @param string keywords   关键词 优惠券名称
	 * @param int    state 		优惠券状态 0未开始 1进行中 2已结束
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

		$coupon_model   = model( "Coupon" );
		$count          = $coupon_model->getCouponCount( $condition );
		$list           = $coupon_model->getCouponList( $condition, '*', 'id desc', $this->getPageLimit() );
		return $this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 优惠券详情
	 * @method GET
	 * @param int id 优惠券id
	 */
	public function info()
	{
		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Coupon.info' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$condition 		 = [];
			$condition['id'] = $get['id'];
			$result          = [];
			$result['info']  = model( 'Coupon' )->getCouponInfo($condition, '*');
			return $this->send( Code::success, $result );
		}
	}

	/**
	 * 添加优惠券
	 * @method POST
	 * @param string	title   			优惠券名称
     * @param fload 	denomination 		面额
     * @param string 	start_time 			开始时间 yyyy-mm-dd hh:ii：ss
     * @param string 	end_time 			结束时间 yyyy-mm-dd hh:ii：ss
     * @param string 	use_start_time 		使用开始时间 yyyy-mm-dd hh:ii：ss
     * @param string 	use_end_time 		使用结束时间 yyyy-mm-dd hh:ii：ss
     * @param int 		time_type 			有效时间类型 默认0 XXX天内有效 1固定时间段
     * @param int 		effective_days 		XXX天内有效
     * @param int 		number 				发放数量
     * @param int 		limit_type 			使用条件 默认0不限制 1满XXX使用
     * @param fload 	limit_price 		满XXX使用
     * @param int    	receive_limit_num 	每人限领 0不限制
	 * @param int       level 				级别 默认0全店 1商品级
	 */
	public function add()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Coupon.add' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			// 有效时间类型 默认0 XXX天内有效 1固定时间段
			switch ($post['time_type']) {
				case 0:
					if(intval($post['effective_days']) <=0){
						return $this->send( Code::error, [], 'XXX天内有效必须' );
					}

					break;
				case 1:
					if(!$post['start_time'] || !$post['end_time']){
						return $this->send( Code::error, [], '开始时间和结束时间必须' );
					}
					$post['use_start_time'] = strtotime($post['use_start_time']);
					$post['use_end_time']   = strtotime($post['use_end_time']);

					if((intval($post['use_start_time'])<=time()) || (intval($post['use_end_time'])<=time())){
						return $this->send( Code::error, [], '使用时间必须大于当前时间' );

					}

					if(intval($post['use_start_time'])>=($post['use_end_time'])){
						return $this->send( Code::error, [], '使用开始时间必须小于结束时间' );

					}

					break;
			}

			//使用条件 默认0不限制 1满XXX使用
			if($post['limit_type'] ==1){
				if(floatval($post['limit_price']) <=0){
					return $this->send( Code::error, [], '满XXX使用必须' );
				}
			}

			$post['start_time'] = strtotime($post['start_time']);
			$post['end_time']   = strtotime($post['end_time']);

			if(intval($post['start_time'])>=($post['end_time'])){
				return $this->send( Code::error, [], '开始时间必须小于结束时间' );

			}

			$post['create_time']= time();

			$result = model( 'Coupon' )->insertCoupon( $post );
			if( $result ){
				return $this->send( Code::success );
			} else{
				return $this->send( Code::error );
			}
		}
	}

	/**
	 * 编辑优惠券
	 * @method POST
	 * @param int    	id   				优惠券id
	 * @param string	title   			优惠券名称
     * @param fload 	denomination 		面额
     * @param string 	start_time 			开始时间 yyyy-mm-dd hh:ii：ss
     * @param string 	end_time 			结束时间 yyyy-mm-dd hh:ii：ss
     * @param string 	use_start_time 		使用开始时间 yyyy-mm-dd hh:ii：ss
     * @param string 	use_end_time 		使用结束时间 yyyy-mm-dd hh:ii：ss
     * @param int 		time_type 			有效时间类型 默认0 XXX天内有效 1固定时间段
     * @param int 		effective_days 		XXX天内有效
     * @param int 		number 				发放数量
     * @param int 		limit_type 			使用条件 默认0不限制 1满XXX使用
     * @param fload 	limit_price 		满XXX使用
     * @param int    	receive_limit_num 	每人限领 0不限制
	 * @param int       level 				级别 默认0全店 1商品级
	 */
	public function edit()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Coupon.edit' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			// 有效时间类型 默认0 XXX天内有效 1固定时间段
			switch ($post['time_type']) {
				case 0:
					if(intval($post['effective_days']) <=0){
						return $this->send( Code::error, [], 'XXX天内有效必须' );
					}

					break;
				case 1:
					if(!$post['start_time'] || !$post['end_time']){
						return $this->send( Code::error, [], '使用开始时间和结束时间必须' );
					}
					$post['use_start_time'] = strtotime($post['use_start_time']);
					$post['use_end_time']   = strtotime($post['use_end_time']);

					if((intval($post['use_start_time'])<=time()) || (intval($post['use_end_time'])<=time())){
						return $this->send( Code::error, [], '使用时间必须大于当前时间' );

					}

					if(intval($post['use_start_time'])>=($post['use_end_time'])){
						return $this->send( Code::error, [], '使用开始时间必须小于结束时间' );

					}


					break;
			}

			//使用条件 默认0不限制 1满XXX使用
			if($post['limit_type'] ==1){
				if(floatval($post['limit_price']) <=0){
					return $this->send( Code::error, [], '满XXX使用必须' );
				}
			}

			$condition          = [];
			$condition['id']    = $post['id'];

			$post['start_time'] = strtotime($post['start_time']);
			$post['end_time']   = strtotime($post['end_time']);

			if(intval($post['start_time'])>=($post['end_time'])){
				return $this->send( Code::error, [], '开始时间必须小于结束时间' );

			}

			unset( $post['id'] );

			$result = model( 'Coupon' )->updateCoupon( $condition, $post );

			if( $result ){
			return $this->send( Code::success, [], '修改成功' );
			} else{
				return $this->send( Code::error );
			}

		}
	}

	/**
	 * 删除优惠券
	 * @method POST
	 * @param int id coupon表ID
	 */
	public function del()
	{
		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Coupon.del' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$condition       = [];
			$condition['id'] = $post['id'];

			$coupon_model   = model( 'Coupon' );

			$coupon_model->startTrans();// 启动事务

			//查询优惠券
			$row             = $coupon_model->getCouponInfo( $condition, '*' );
			if( !$row ){
				$coupon_model->rollback();// 回滚事务
				return $this->send( Code::param_error );
			}

			//删除优惠券
			$coupon_result = $coupon_model->delCoupon( $condition );

			if( !$coupon_result ){
				$coupon_model->rollback();// 回滚事务
				return $this->send( Code::error );
			}


			//级别 默认0全店 1商品级
			if($row['level'] == 1){
				//删除优惠券下商品
				$coupon_goods_model = model('CouponGoods');
				$coupon_goods_result = $coupon_goods_model->delCouponGoods( array('coupon_id'=>$post['id']) );

				if( !$coupon_goods_result ){
					$coupon_model->rollback();// 回滚事务
					return $this->send( Code::error );
				}
			}


		    $coupon_model->commit();// 提交事务

			return $this->send( Code::success );
		}
	}


	/**
	 * 优惠券可选择商品列表
	 * @method GET
	 * @param int 	 coupon_id 	 优惠券id
	 * @param string keywords 	 关键词 商品名称
	 * @param array  category_ids商品分类
	 */
	public function selectableGoods()
	{

		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Coupon.selectableGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$coupon_model 	  = model('Coupon');
			$coupon_goods_model = model('CouponGoods');

			//查询优惠券
			$coupon_data        = $coupon_model->getCouponInfo( array('id'=>$get['coupon_id']), '*' );
			if( !$coupon_data ){
				return $this->send( Code::param_error );
			}

            //级别 默认0全店 1商品级
            if($coupon_data['level'] == 0){
				return $this->send( Code::success, [
					'total_number' => 0,
					'list'         => 0,
				] );
            }


			$param = [];
			if(isset($get['keywords'])){
				$param['title'] = $get['keywords'];
			}

			if(isset($get['category_ids'])){
				$param['category_ids'] = $get['category_ids'];
			}

			//查询优惠券商品ids
            $goods_ids = $coupon_goods_model->getCouponGoodsColumn(array('coupon_id'=>$get['coupon_id']), 'goods_id');
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
	 * 优惠券已选择商品列表
	 * @method GET
	 * @param int 	 coupon_id 优惠券id
	 */
	public function selectedGoods()
	{

		$get  = $this->get;
		$error = $this->validate( $get, 'Admin/Coupon.selectedGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$coupon_model 	  = model('Coupon');
			$coupon_goods_model = model('CouponGoods');


			//查询优惠券
			$coupon_data        = $coupon_model->getCouponInfo( array('id'=>$get['coupon_id']), '*' );
			if( !$coupon_data ){
				return $this->send( Code::param_error );
			}

            //级别 默认0全店 1商品级
            if($coupon_data['level'] == 0){
				return $this->send( Code::success, [
					'total_number' => 0,
					'list'         => 0,
				] );
            }

			//查询优惠券商品ids
            $goods_ids = $coupon_goods_model->getCouponGoodsColumn(array('coupon_id'=>$get['coupon_id']), 'goods_id');
            if($goods_ids){
				$online_goods_ids = model('Goods')->getGoodsColumn(array('in'=>$goods_ids,'is_on_sale'=>1), 'id');
            }

            //交集 coupon_goods表和goods表的商品交集
			$intersection_goods_ids  = array_values(array_intersect($goods_ids,$online_goods_ids));

			//删除优惠券下失效商品
			$coupon_goods_result = $coupon_goods_model->delCouponGoods( array('coupon_id'=>$get['coupon_id'],'goods_id'=>array('not in',$intersection_goods_ids)) );
			if( !$coupon_goods_result ){
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
	 * 优惠券选择商品
	 * @method POST
	 * @param int 	 coupon_id 优惠券id
	 * @param array  goods_ids   商品id
	 */
	public function choiceGoods()
	{

		$post  = $this->post;
		$error = $this->validate( $post, 'Admin/Coupon.choiceGoods' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{

			$goods_sku_model 	  = model('GoodsSku');
			$coupon_goods_model = model('CouponGoods');

			//查询优惠券
			$coupon_data        = $coupon_model->getCouponInfo( array('id'=>$get['coupon_id']), '*' );
			if( !$coupon_data ){
				return $this->send( Code::param_error );
			}

            //级别 默认0全店 1商品级
            if($coupon_data['level'] == 0){
				return $this->send( Code::param_error );
            }

			$goods_sku_data = $goods_sku_model->getGoodsSkuList( array('goods_id'=>array('in',$post['goods_ids'])), 'id AS goods_sku_id,goods_id', 'goods_id asc,goods_sku_id asc', '' );
			if(!$goods_sku_data){
				return $this->send( Code::param_error );

			}

			foreach ($goods_sku_data as $key => $value) {
				$goods_sku_data[$key]['coupon_id'] = $post['coupon_id'];
				$goods_sku_data[$key]['create_time'] = time();
			}

			$result = $coupon_goods_model->insertAllCouponGoods($goods_sku_data);

			if( !$result ){
				return $this->send( Code::error );
			}

			return $this->send( Code::success );

		}

	}

    /**
     * 优惠券已选择商品sku列表
     * @method GET
     * @param int    coupon_id 优惠券id
     * @param int    goods_id   优惠券商品id
     */
    public function goodsSkuList()
    {

        $get  = $this->get;
        $error = $this->validate( $get, 'Admin/Coupon.goodsSkuList' );
        if( $error !== true ){
            return $this->send( Code::error, [], $error );
        } else{

            $coupon_model       = model('Coupon');
            $coupon_goods_model = model('CouponGoods');
			$goods_sku_model 	  = model('GoodsSku');

            //查询优惠券
            $coupon_data        = $coupon_model->getCouponInfo( array('id'=>$get['coupon_id']), '*' );
            if( !$coupon_data ){
                return $this->send( Code::param_error );
            }

            //级别 默认0全店 1商品级
            if($coupon_data['level'] == 0){
				return $this->send( Code::param_error );
            }

            $condition = array();
            $condition['goods_sku.goods_id'] = $get['goods_id'];

            //查询该商品下所有sku和已设置的数据
            $goods_sku_count = $coupon_goods_model->getGoodsSkuMoreCount($condition);
			$goods_sku_list  = $coupon_goods_model->getGoodsSkuMoreList($condition, 'goods_sku.*,coupon_goods.coupon_id', 'goods_sku.id asc', '');

            return $this->send( Code::success, [
                'total_number' => $goods_sku_count,
                'list'         => $goods_sku_list,
            ] );

        }

    }

    /**
     * 修改优惠券已选择商品sku
     * @method GET
     * 传过来是一个二维数组 里面的每个子数组下面有如下数据
     * @param int    coupon_id 	优惠券id
     * @param int    goods_id    	优惠券商品id
     * @param array  goods_sku      优惠券商品sku ids
     */
    public function editGoodsSku(){
	    //post数据格式
		// $post['goods_sku'] = array(
		// 	'coupon_id'	=>100,
		// 	'goods_id'		=>100,
		// 	'goods_sku'		=>array(1,2,3,4,5)
		// );

		$post  = $this->post;

		$error = $this->validate( $post, 'Admin/Coupon.editGoodsSku' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );

		} else{
            $coupon_goods_model = model('CouponGoods');
			$goods_sku_model 	  = model('GoodsSku');

            $coupon_goods_model->startTrans();// 启动事务

			//为空代表删除所有goods_sku
			if(empty($post['goods_sku'])){

				$condition = array();
				$condition['coupon_id'] = $post['coupon_id'];
				$condition['goods_id'] = $post['goods_id'];

	            //删除优惠券下商品
	            $coupon_goods_result = $coupon_goods_model->delCouponGoods( $condition );
	            if( !$coupon_goods_result ){
	            	$coupon_goods_model->rollback();// 回滚事务
	                return $this->send( Code::error );
	            }

			}else{
				$post_goods_sku = array();
				foreach ($post['goods_sku'] as $key => $value) {
					$post_goods_sku[$key]['coupon_id']  = $post['coupon_id'];
					$post_goods_sku[$key]['goods_id'] 	 = $post['goods_id'];
					$post_goods_sku[$key]['goods_sku_id']= $value;
					$post_goods_sku[$key]['create_time'] = time();

				}

				//查询优惠券商品sku ids
	            $goods_sku_ids = $coupon_goods_model->getCouponGoodsColumn($condition, 'goods_sku_id');

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
						$coupon_goods_updata = array();

						foreach ($post_goods_sku as $key => $value) {
							if(in_array($value['goods_sku_id'], $intersection_goods_sku_ids)){
								$coupon_goods_updata[] = $value;
							}
						}

						$result = array();
						$result = $coupon_goods_model->updateAllCouponGoods($coupon_goods_updata);
						if( !$result ){
							$coupon_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}

					}

					//差集 [新添加的sku]
					if($difference_goods_sku_add_ids){
						$coupon_goods_insert_data = array();

						foreach ($post_goods_sku as $key => $value) {
							if(in_array($value['goods_sku_id'], $difference_goods_sku_add_ids)){
								$coupon_goods_insert_data[] = $value;
							}
						}

						$result = array();
						$result = $coupon_goods_model->insertAllCouponGoods($coupon_goods_insert_data);
						if( !$result ){
							$coupon_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}
					}

					//差集 [已删除的sku]
					if($difference_goods_sku_del_ids){
						$condition['goods_sku_id'] = array('in',$difference_goods_sku_del_ids);
						$result = array();
						$result = $coupon_goods_model->delCouponGoods($condition);

						if( !$result ){
							$coupon_goods_model->rollback();// 回滚事务
							return $this->send( Code::error );
						}

					}

	            }else{
	            	$result = array();
					$result = $coupon_goods_model->insertAllCouponGoods($post_goods_sku);
					if( !$result ){
						$coupon_goods_model->rollback();// 回滚事务
						return $this->send( Code::error );
					}

	            }


			}

            $coupon_goods_model->commit();// 提交事务
			return $this->send( Code::success );

		}

    }


}