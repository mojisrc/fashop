<?php
/**
 * 会员中心——卖家评价
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
 * 商品评价
 * Class Evaluate
 * @package App\HttpController\Admin
 */
class Goodsevaluate extends Admin
{
	/**
	 * 评价列表
	 * @method GET
	 * @param string $keywords_type 关键词类型：商品名称 goods_name 、用户昵称 user_nicknname 、用户手机号 user_phone
	 * @param string $keywords      关键词
	 * @param array  $create_time   时间区间[开始时间戳,结束时间戳]
	 * @param string $type          默认为全部评价，好评positive 、中评 moderate、差评negative
	 *
	 */
	public function list()
	{
        $table_prefix         = config('database.prefix');
        $table_user           = $table_prefix . 'user';
        $table_user_profile   = $table_prefix . 'user_profile';

        $param                = !empty($this->post) ? $this->post : $this->get;
        $goods_evaluate_model = model('GoodsEvaluate');
		$condition = [];
		if( isset( $param['keywords_type'] ) && isset( $param['keywords'] ) ){
			switch( $param['keywords_type'] ){
			case 'goods_name':
				$condition['evaluate.goods_title'] = ['like', '%'.$param['keywords'].'%'];
			break;
			case 'user_nicknname':
				$condition["(SELECT nickname FROM ".$table_user_profile." WHERE user_id=evaluate.user_id)"] = [
					'like',
					'%'.$param['keywords'].'%',
				];
			break;
			case 'user_phone':
				$condition["(SELECT phone FROM ".$table_user." WHERE id=evaluate.user_id)"] = [
					'like',
					'%'.$param['keywords'].'%',
				];
			break;
			}
		}
		if( isset( $param['create_time'] ) ){
			$condition['evaluate.create_time'] = ['between', $param['create_time']];
		}
		if( isset( $param['type'] ) ){
			switch( $param['type'] ){
			case 'positive':
				$condition['evaluate.score'] = 5;
			break;

			case 'moderate':
				$condition['evaluate.score'] = ['in', '3,4'];
			break;

			case 'negative':
				$condition['evaluate.score'] = ['in', '1,2'];
			break;
			}
		}
		$count = $goods_evaluate_model->alias( 'evaluate' )->join( 'order order', 'evaluate.order_id = order.id', 'LEFT' )->group( 'evaluate.id' )->where( $condition )->count();
		$list  = $goods_evaluate_model->alias( 'evaluate' )->join( 'order order', 'evaluate.order_id = order.id', 'LEFT' )->join( 'order_goods goods', 'evaluate.order_goods_id = goods.id' )->join( 'user user', 'evaluate.user_id = user.id', 'LEFT' )->join( '__USER_PROFILE__ user_profile', 'user.id = user_profile.user_id', 'LEFT' )->where( $condition )->field( 'evaluate.id,score,evaluate.goods_img,evaluate.content,evaluate.create_time,evaluate.images,additional_content,additional_images,additional_time,reply_time,reply_content,reply_time2,reply_content2,display,top,goods.goods_spec,goods.goods_title,user.phone,user_profile.nickname,user_profile.avatar' )->order( 'evaluate.id desc' )->page( $this->getPageLimit() )->group( 'evaluate.id' )->select();
		$this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 添加回复
	 * @method POST
	 * @param int    $id            goods_evaluate表id
	 * @param string $reply_content 回复内容
	 */
	public function reply()
	{
		if( $this->validate( $this->post, 'Admin/Evaluation.reply' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$goods_evaluate_model = model( 'GoodsEvaluate' );
				$condition['id']      = $this->post['id'];
				$row                  = $goods_evaluate_model->getGoodsEvaluateInfo( $condition, '*' );
				if( $row['content'] != '' && $row['reply_content'] == '' ){
					if( isset( $this->post['reply_content'] ) && $this->post['reply_content'] != '' ){
						$data['reply_content'] = $this->post['reply_content'];
						$data['reply_time']    = time();
					}
				} elseif( $row['additional_time'] > 0 && !$row['reply_time2'] ){
					if( isset( $this->post['reply_content'] ) && $this->post['reply_content'] != '' ){
						$data['reply_content2'] = $this->post['reply_content'];
						$data['reply_time2']    = time();
					}
				}
				$result = $goods_evaluate_model->editGoodsEvaluate( $condition, $data );
				if( $result ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}
		}

	}

	/**
	 * 是否展示
	 * @method POST
	 * @param int $id goods_evaluate表ID
	 */
	public function display()
	{
		if( $this->validate( $this->post, 'Admin/Evaluation.display' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			try{
				$goods_evaluate_model = model( 'GoodsEvaluate' );
				$condition['id']      = $this->post['id'];
				$row                  = $goods_evaluate_model->getGoodsEvaluateInfo( $condition, '*' );
				if( $row['display'] === 1 ){
					$data['display'] = 0;
				} else{
					$data['display'] = 1;
				}
				$result = $goods_evaluate_model->editGoodsEvaluate( $condition, $data );
				if( $result ){
					$this->send( Code::success );
				} else{
					$this->send( Code::error );
				}
			} catch( \Exception $e ){
				$this->send( Code::server_error, [], $e->getMessage() );
			}

		}
	}
}
