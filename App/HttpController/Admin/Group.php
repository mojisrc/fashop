<?php
/**
 *
 * 拼团活动
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
 * 拼团活动
 * Class Group
 * @package App\HttpController\Admin
 */
class Group extends Admin
{
	/**
	 * 拼团活动列表
	 * @method GET
	 * @param string $keywords 关键词 活动名称
	 * @param int    $state    状态 0未开始 10进行中 20已结束 30已失效
	 */
	public function list()
	{
		$get           = $this->get;
		$time          = time();
		$condition     = [];
		if( isset( $get['keywords'] ) ){
			$condition['title'] = ['like', '%'.$get['keywords'].'%'];
		}
		if( isset( $get['state'] ) && $get['state'] >= 0 ){

			switch( $get['state'] ){
			case 0:
				$condition['start_time'] = ['>', $time];
				$condition['is_show']    = 1;
			break;
			case 10:
				$condition['start_time'] = ['<=', $time];
				$condition['end_time']   = ['>=', $time];
				$condition['is_show']    = 1;
			break;
			case 20:
				$condition['end_time'] = ['<=', $time];
				$condition['is_show']  = 1;
			break;
			case 30:
				$condition['is_show'] = 0;
			break;
			}
		}

		$count = \App\Model\Group::getGroupCount( $condition );
		$list  = \App\Model\Group::init()->getGroupList( $condition, '*', 'id desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 拼团活动信息
	 * @method GET
	 * @param int $id
	 * @author 孙泉
	 */
	public function info()
	{
		$get   = $this->get;
		$error = $this->validator( $get, 'Admin/Group.info' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$prefix            = \EasySwoole\EasySwoole\Config::getInstance()->getConf('MYSQL.prefix');
			$table_goods       = $prefix."goods";
			$table_group       = $prefix."group";
			$table_group_goods = $prefix."group_goods";
			$condition         = [];
			$condition['id']   = $get['id'];
			$field             = '*'.",(SELECT img from $table_goods WHERE id=(SELECT goods_id FROM $table_group_goods WHERE group_id=$table_group.id LIMIT 1)) AS goods_img";
			$info              = \App\Model\Group::getGroupInfo( $condition, '', $field );
			$this->send( Code::success, ['info' => $info] );
		}

	}

	/**
	 * 添加拼团活动
	 * @method POST
	 * @param string title              名称
	 * @param string time_over_day      时限天数
	 * @param string time_over_hour     时限小时
	 * @param string time_over_minute   时限分钟
	 * @param string start_time         开始时间
	 * @param string end_time           结束时间
	 * @param string limit_buy_num      拼团人数
	 * @param string limit_group_num    每位用户可进行的团数
	 * @param string limit_goods_num    用户每次参团时可购买件数
	 * @param array  group_goods        数组 格式 [ ['goods_id'=>1,'goods_sku_id'=>1,'group_price'=>1,'captain_price'=>1],['goods_id'=>2,'goods_sku_id'=>2,'group_price'=>2,'captain_price'=>2...] ] 商品选择数组
	 * 注释：
	 * goods_id         商品主表id 只能选择一个商品 group_goods里goods_id必须为一样
	 * goods_sku_id     商品id
	 * group_price      拼团价格
	 * captain_price    团长价格
	 */
	public function add()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Group.add' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$goods_id_arr = array_column( $post['group_goods'], 'goods_id' );
			if( count( array_unique( $goods_id_arr ) ) != 1 ){
				return $this->send( Code::param_error, [], '只能选择一个商品' );
			}

			$goods_id   = $post['group_goods'][0]['goods_id'];
			$goods_info = \App\Model\Goods::getGoodsInfo( ['is_on_sale' => 1, 'id' => $goods_id] );
			if( !$goods_info ){
				return $this->send( Code::param_error, [], '商品信息错误' );
			}

			$goods_sku = \App\Model\GoodsSku::getGoodsSkuList( ['goods_id' => $goods_id], '*', 'id desc', [1,100] );
			if( !$goods_sku ){
				return $this->send( Code::param_error, [], '商品信息错误' );
			}

			$goods_sku_ids = array_column( $goods_sku, 'id' );
			$post_sku_ids  = array_column( $post['group_goods'], 'goods_sku_id' );
			if( array_diff( $post_sku_ids, $goods_sku_ids ) || array_diff( $goods_sku_ids, $post_sku_ids ) ){
				return $this->send( Code::param_error, [], '规格错误' );
			}

			$time = time();
			//查询未开始和正在进行活动
			$condition             = [];
			$condition['goods_id'] = $goods_id;
			$condition['is_show']  = 1;
			$condition_str         = "(start_time>$time) OR (start_time<=$time AND end_time>=$time)";
			$group_info            = \App\Model\Group::getGroupInfo( $condition, $condition_str );
			if( $group_info ){
				return $this->send( Code::param_error, [], '商品信息错误' );
			}

			$data                     = [];
			$data['title']            = $post['title'];
			$data['time_over_day']    = $post['time_over_day'];
			$data['time_over_hour']   = $post['time_over_hour'];
			$data['time_over_minute'] = $post['time_over_minute'];
			$data['limit_buy_num']    = $post['limit_buy_num'];
			$data['limit_group_num']  = $post['limit_group_num'];
			$data['limit_goods_num']  = $post['limit_goods_num'];
			$data['time_over']        = ($post['time_over_day'] * 24 + $post['time_over_hour']).':'.$post['time_over_minute'];
			$data['start_time']       = strtotime( $post['start_time'] );
			$data['end_time']         = strtotime( $post['end_time'] );
			$data['create_time']      = time();
			$data['update_time']      = time();
			$data['is_show']          = 1;
			$data['goods_id']         = $goods_id;

			\App\Model\Group::startTransaction();
			$group_id = \App\Model\Group::insertGroup( $data );
			if( !$group_id ){
				\App\Model\Group::rollback();
				return $this->send( Code::error );
			}

			$group_goods       = [];

			foreach( $post['group_goods'] as $key => $value ){
				if( intval( $value['goods_id'] ) <= 0 || intval( $value['goods_sku_id'] ) <= 0 ){
					return $this->send( Code::param_error, [], '必须选择商品规格' );
				}

				if( $value['captain_price'] > $value['group_price'] ){
					return $this->send( Code::param_error, [], '团长价不能大于拼团价' );
				}

				foreach( $goods_sku as $k => $v ){
					if( $value['goods_sku_id'] == $v['id'] && $value['group_price'] > $v['price'] ){
						return $this->send( Code::param_error, [], '拼团价不能大于原价' );
					}
				}

				$group_goods[$key]['group_id']      = $group_id;
				$group_goods[$key]['goods_id']      = $value['goods_id'];
				$group_goods[$key]['goods_sku_id']  = $value['goods_sku_id'];
				$group_goods[$key]['group_price']   = $value['group_price'];
				$group_goods[$key]['captain_price'] = $value['captain_price'];
				$group_goods[$key]['create_time']   = time();
			}

			$group_goods_result = \App\Model\GroupGoods::init()->addMultiGroupGoods( $group_goods );
			if( !$group_goods_result ){
				\App\Model\Group::rollback();
				return $this->send( Code::error );
			}

			\App\Model\Group::commit();
			return $this->send( Code::success );

		}
	}

	/**
	 * 编辑拼团活动
	 * @method POST
	 * @param int    id                 数据id
	 * @param string title              名称
	 * @param string time_over_day      时限天数
	 * @param string time_over_hour     时限小时
	 * @param string time_over_minute   时限分钟
	 * @param string start_time         开始时间
	 * @param string end_time           结束时间
	 * @param string limit_buy_num      拼团人数
	 * @param string limit_group_num    每位用户可进行的团数
	 * @param string limit_goods_num    用户每次参团时可购买件数
	 * @param array  group_goods        数组 格式 [ ['goods_id'=>1,'goods_sku_id'=>1,'group_price'=>1,'captain_price'=>1],['goods_id'=>2,'goods_sku_id'=>2,'group_price'=>2,'captain_price'=>2...] ] 商品选择数组 可为空数组
	 * 注释：
	 * goods_id         商品主表id 只能选择一个商品 group_goods里goods_id必须为一样
	 * goods_sku_id     商品id
	 * group_price      拼团价格
	 * captain_price    团长价格
	 */
	public function edit()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Group.edit' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$group_data  = \App\Model\Group::getGroupInfo( ['id' => $post['id']], '', '*' );
			if( !$group_data ){
				return $this->send( Code::error, [], '参数错误' );
			}

			$goods_id_arr = array_column( $post['group_goods'], 'goods_id' );
			if( count( array_unique( $goods_id_arr ) ) != 1 ){
				return $this->send( Code::param_error, [], '只能选择一个商品' );
			}

			$group_goods       = [];
			$map               = [];
			$map['group_id']   = $post['id'];
			//查询活动商品sku ids
			$group_goods_sku_ids = \App\Model\GroupGoods::getGroupGoodsIndexesColumn( $map, '', 'goods_sku_id', 'id' );
			if( !$group_goods_sku_ids ){
				return $this->send( Code::error, [], '参数错误' );
			}

			$post_sku_ids = array_column( $post['group_goods'], 'goods_sku_id' );
			if( array_diff( $post_sku_ids, $group_goods_sku_ids ) || array_diff( $group_goods_sku_ids, $post_sku_ids ) ){
				return $this->send( Code::param_error, [], '规格错误' );
			}

			$goods_id = $post['group_goods'][0]['goods_id'];
			if( $goods_id != $group_data['goods_id'] ){
				return $this->send( Code::error, [], '参数错误' );
			}

			$data               = [];
			$group_goods_updata = [];

			if( time() >= $group_data['start_time'] && time() <= $group_data['end_time'] ){
				//进行中
				$error = $this->validator( $post, 'Admin/Group.editStart' );
				if( $error !== true ){
					return $this->send( Code::error, [], $error );
				}
				$data['title']       = $post['title'];
				$data['end_time']    = strtotime( $post['end_time'] );
				$data['update_time'] = time();

				if( $data['end_time'] < $group_data['end_time'] ){
					return $this->send( Code::error, [], '活动结束时间不能小于之前设置' );
				}
			} elseif( time() < $group_data['start_time'] ){
				//未开始
				$error = $this->validator( $post, 'Admin/Group.editUnstart' );
				if( $error !== true ){
					return $this->send( Code::error, [], $error );
				}
				$data['title']            = $post['title'];
				$data['time_over_day']    = $post['time_over_day'];
				$data['time_over_hour']   = $post['time_over_hour'];
				$data['time_over_minute'] = $post['time_over_minute'];
				$data['limit_buy_num']    = $post['limit_buy_num'];
				$data['limit_group_num']  = $post['limit_group_num'];
				$data['limit_goods_num']  = $post['limit_goods_num'];
				$data['time_over']        = ($post['time_over_day'] * 24 + $post['time_over_hour']).':'.$post['time_over_minute'];
				$data['start_time']       = strtotime( $post['start_time'] );
				$data['end_time']         = strtotime( $post['end_time'] );
				$data['update_time']      = time();

				$goods_sku = \App\Model\GoodsSku::getGoodsSkuList( ['goods_id' => $goods_id], '*', 'id desc', [1,100] );
				if( !$goods_sku ){
					return $this->send( Code::param_error, [], '商品信息错误' );
				}

				$goods_sku_ids = array_column( $goods_sku, 'id' );
				if( array_diff( $post_sku_ids, $goods_sku_ids ) || array_diff( $goods_sku_ids, $post_sku_ids ) ){
					return $this->send( Code::param_error, [], '规格错误' );
				}

				foreach( $post['group_goods'] as $key => $value ){
					if( intval( $value['goods_id'] ) <= 0 || intval( $value['goods_sku_id'] ) <= 0 ){
						return $this->send( Code::param_error, [], '必须选择商品规格' );
					}

					if( $value['captain_price'] > $value['group_price'] ){
						return $this->send( Code::param_error, [], '团长价不能大于拼团价' );
					}

					foreach( $goods_sku as $k => $v ){
						if( $value['goods_sku_id'] == $v['id'] && $value['group_price'] > $v['price'] ){
							return $this->send( Code::param_error, [], '拼团价不能大于原价' );
						}
					}

					$group_goods[$key]['group_id']      = $post['id'];
					$group_goods[$key]['goods_id']      = $value['goods_id'];
					$group_goods[$key]['goods_sku_id']  = $value['goods_sku_id'];
					$group_goods[$key]['group_price']   = $value['group_price'];
					$group_goods[$key]['captain_price'] = $value['captain_price'];
					$group_goods[$key]['update_time']   = time();

				}

				foreach( $group_goods as $key => $value ){
					if( in_array( $value['goods_sku_id'], $group_goods_sku_ids ) ){
						$value['id']          = array_search( $value['goods_sku_id'], $group_goods_sku_ids );
						$group_goods_updata[] = $value;
					}
				}


			} elseif( time() > $group_data['end_time'] ){
				//已结束
				return $this->send( Code::error, [], '参数错误' );

			}

			if( $group_data['is_show'] == 0 ){
				//已失效
				return $this->send( Code::error, [], '参数错误' );
			}

			\App\Model\Group::startTransaction();

			$condition       = [];
			$condition['id'] = $post['id'];
			$group_result    = \App\Model\Group::updateGroup( $condition, $data );
			if( !$group_result ){
				\App\Model\Group::rollback();
				return $this->send( Code::error );
			}

			if( $group_goods_updata ){
				$group_goods_result = \App\Model\GroupGoods::init()->editMultiGroupGoods( $group_goods_updata );
				if( !$group_goods_result ){
					\App\Model\Group::rollback();// 回滚事务
					return $this->send( Code::error );
				}
			}

			\App\Model\Group::commit();
			return $this->send( Code::success );
		}
	}

	/**
	 * 拼团活动可选择商品列表
	 * @method GET
	 * @param string title          商品名称
	 * @param array  category_ids   分类id 数组格式
	 */
	public function selectableGoods()
	{

		$get               = $this->get;
		$time              = time();
		//查询未开始和正在进行活动
		$condition            = [];
		$condition['is_show'] = 1;
		$condition_str        = "(start_time>$time) OR (start_time<=$time AND end_time>=$time)";
		$group_ids            = \App\Model\Group::getGroupColumn( $condition, $condition_str );

		$param               = [];
		$param['is_on_sale'] = 1;
		if( isset( $get['title'] ) ){
			$param['title'] = $get['title'];
		}

		if( isset( $get['category_ids'] ) ){
			$param['category_ids'] = $get['category_ids'];
		}

		//查询活动商品ids
		if( $group_ids ){
			$goods_ids = \App\Model\GroupGoods::getGroupGoodsColumn( ['group_id' => ['in', $group_ids]], '', 'goods_id' );
			if( $goods_ids ){
				$param['not_in_ids'] = $goods_ids;
			}
		}

		$goodsLogic = new \App\Biz\GoodsSearch( $param );
		return $this->send( Code::success, [
			'total_number' => $goodsLogic->count(),
			'list'         => $goodsLogic->list(),
		] );


	}

	/**
	 * 拼团活动已选择商品sku列表
	 * @method GET
	 * @param int    group_id 拼团活动id
	 */
	public function goodsSkuList()
	{

		$get   = $this->get;
		$error = $this->validator( $get, 'Admin/Group.goodsSkuList' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			//查询活动
			$group_data = \App\Model\Group::getGroupInfo( ['id' => $get['group_id']], '', '*' );
			if( !$group_data ){
				return $this->send( Code::param_error );
			}

			//查询活动商品sku ids
			$goods_sku_ids = \App\Model\GroupGoods::getGroupGoodsColumn( ['group_id' => $group_data['id']], '', 'goods_sku_id' );

			if( !$goods_sku_ids ){
				return $this->send( Code::error );
			}

			$condition                         = [];
			$condition['goods_sku.id']         = ['in', $goods_sku_ids];
			$condition['group_goods.group_id'] = $group_data['id'];

			//查询该商品下所有sku和已设置拼团活动的数据
			$goods_sku_count = \App\Model\GroupGoods::getGoodsSkuMoreCount( $condition );
			$goods_sku_list  = \App\Model\GroupGoods::getGoodsSkuMoreList( $condition, '', 'goods_sku.*,group_goods.group_id,group_price,captain_price', 'goods_sku.id asc', '' );

			return $this->send( Code::success, [
				'total_number' => $goods_sku_count,
				'list'         => $goods_sku_list,
			] );

		}

	}

	/**
	 * 拼团活动设置
	 * @method POST
	 * @param int id 拼团活动id
	 */
	public function showSet()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Group.info' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$time        = time();
			//查询未开始和正在进行活动
			$condition            = [];
			$condition['id']      = $post['id'];
			$condition['is_show'] = 1;
			$condition_str        = "(start_time>$time) OR (start_time<=$time AND end_time>=$time)";
			$group_info           = \App\Model\Group::getGroupInfo( $condition, $condition_str );

			if( !$group_info ){
				return $this->send( Code::param_error );
			} else{
				$result = \App\Model\Group::updateGroup( ['id' => $post['id']], ['is_show' => 0] );
				if( $result ){
					return $this->send( Code::success );
				} else{
					return $this->send( Code::error );
				}
			}

		}
	}


	/**
	 * 删除拼团活动
	 * @method POST
	 * @param int id 拼团活动id
	 */
	public function del()
	{
		$post  = $this->post;
		$error = $this->validator( $post, 'Admin/Group.del' );
		if( $error !== true ){
			return $this->send( Code::error, [], $error );
		} else{
			$time              = time();

			//查询未开始和正在进行活动
			$condition            = [];
			$condition['id']      = $post['id'];
			$condition['is_show'] = 1;
			$condition_str        = "(start_time>$time) OR (start_time<=$time AND end_time>=$time)";
			$group_info           = \App\Model\Group::getGroupInfo( $condition, $condition_str );

			if( $group_info ){
				return $this->send( Code::param_error, [], '不可删除' );
			} else{

				\App\Model\Group::startTransaction();
				//删除拼团活动
				$group_result = \App\Model\Group::init()->delGroup( ['id' => $post['id']] );
				if( !$group_result ){
					\App\Model\Group::rollback();
					return $this->send( Code::error );
				}
				//删除拼团活动商品
				$group_goods_result = \App\Model\GroupGoods::init()->delGroupGoods( ['group_id' => $post['id']] );
				if( !$group_goods_result ){
					\App\Model\Group::rollback();
					return $this->send( Code::error );
				}

				\App\Model\Group::commit();
				return $this->send( Code::success );
			}

		}
	}

	/**
	 * 商品列表
	 * @method GET
	 * @author 孙泉
	 */
	public function pageGoods()
	{
		$param                   = $this->get;
		$condition               = [];
		$time                    = time();
		$condition['start_time'] = ['<=', $time];
		$condition['end_time']   = ['>=', $time];
		$condition['is_show']    = 1;

		//查询正在进行的拼团
		$group_list = \App\Model\Group::init()->getGroupList( $condition, '*', 'id desc',[1,1000] );
		if( !$group_list ){
			$this->send( Code::success, [
				'total_number' => 0,
				'list'         => [],
			] );
		} else{
			$group_ids                   = array_column( $group_list, 'id' );
			$group_goods_ids             = array_column( $group_list, 'goods_id' );
			$map                         = [];
			$map['group_goods.group_id'] = ['in', $group_ids];
			//            $map_str                     = 'group_goods.group_price<goods_sku.price';
			$min_group_price = \App\Model\GroupGoods::join( 'goods_sku', 'group_goods.goods_sku_id = goods_sku.id', 'LEFT' )->where( $map )->group( 'goods_id' )->column( 'group_goods.goods_id,min(group_goods.group_price)' );

			$param['ids']  = $group_goods_ids;
			$param['page'] = $this->getPageLimit();
			$goodsLogic    = new \App\Biz\GoodsSearch( $param );
			$goods_count   = $goodsLogic->count();
			$goods_list    = $goodsLogic->list();

			foreach( $goods_list as $key => $value ){
				$goods_list[$key]['group_price'] = $min_group_price[$value['id']];
				foreach( $group_list as $k => $v ){
					if( $value['id'] == $v['goods_id'] ){
						$goods_list[$key]['limit_buy_num'] = $v['limit_buy_num'];
					}
				}

			}
			$this->send( Code::success, [
				'total_number' => $goods_count,
				'list'         => $goods_list,
			] );
		}
	}


}