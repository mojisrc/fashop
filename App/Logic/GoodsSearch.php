<?php
/**
 * 商品搜索模型
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\Logic;

class GoodsSearch
{
	/**
	 * 是否需上架出售 0 否 1 是
	 * @var int
	 */
	private $isOnSale;
	/**
	 * 分类id 数组格式
	 * @var array
	 */
	private $categoryIds;
	/**
	 * order_type 1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早 9排序高到低 10排序低到高
	 * @var int
	 */
	private $orderType;
	/**
	 * 商品名称
	 * @var string
	 */
	private $title;
	/*
	 * 默认排序
	 * @var string
	 */
	private $order = 'create_time desc';
	/**
	 * @var array
	 */
	private $condition;
	/**
	 * @var string
	 */
	private $page;
	/**
	 * @var \App\Model\Goods
	 */
	private $make;
	/**
	 * @var string
	 */
	private $field = "*";
	/**
	 * @var array
	 */
	private $price;
	/**
	 * @var array
	 */
	private $ids;
	/**
	 * @var array
	 */
	private $notInIds;

	/**
	 * @return array
	 */
	public function getIds() : array
	{
		return $this->ids;
	}

	/**
	 * @param array $ids
	 */
	public function setIds( array $ids ) : void
	{
		$this->ids = $ids;
	}

	/**
	 * @return array
	 */
	public function getCondition() : array
	{
		return $this->condition;
	}

	/**
	 * @param array $condition
	 */
	public function setCondition( array $condition ) : void
	{
		$this->condition = $condition;
	}

	/**
	 * @return string
	 */
	public function getPage() : string
	{
		return $this->page;
	}

	/**
	 * @param string $page
	 */
	public function setPage( string $page ) : void
	{
		$this->page = $page;
	}

	/**
	 * @return GoodsSearch
	 */
	public function getMake() : \App\Model\Goods
	{
		return $this->make;
	}

	/**
	 * @return string
	 */
	public function getField() : string
	{
		return $this->field;
	}

	/**
	 * @param string $field
	 */
	public function setField( string $field ) : void
	{
		$this->field = $field;
	}

	/**
	 * @return int
	 */
	public function getOnSale() : int
	{
		return $this->isOnSale;
	}

	/**
	 * @param int $isOnSale
	 */
	public function setOnSale( int $isOnSale ) : void
	{
		$this->isOnSale = $isOnSale;
	}

	/**
	 * @return array
	 */
	public function getCategoryIds() : array
	{
		return $this->categoryIds;
	}

	/**
	 * @param array $categoryIds
	 */
	public function setCategoryIds( array $categoryIds ) : void
	{
		$this->categoryIds = $categoryIds;
	}

	/**
	 * @return int
	 */
	public function getOrderType() : int
	{
		return $this->orderType;
	}

	/**
	 * @param int $order_type
	 */
	public function setOrderType( int $order_type ) : void
	{
		$this->orderType = $order_type;
	}

	/**
	 * @return string
	 */
	public function getTitle() : string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle( string $title ) : void
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getOrder() : string
	{
		return $this->order;
	}

	/**
	 * @param string $order
	 */
	public function setOrder( string $order ) : void
	{
		$this->order = $order;
	}

	/**
	 * @return array
	 */
	public function getPrice() : array
	{
		return $this->price;
	}


	/**
	 * @param array $price
	 */
	public function setPrice( array $price ) : void
	{
		$this->price = $price;
	}

	/**
	 * @return array
	 */
	public function getNotInIds() : array
	{
		return $this->notInIds;
	}

	/**
	 * @param array $ids
	 */
	public function setNotInIds( array $notInIds ) : void
	{
		$this->ids = $notInIds;
	}
    /**
     * @return string
     */
    public function getKeywords() : string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords( string $keywords ) : void
    {
        $this->keywords = $keywords;
    }

    /**
     * @return int
     */
    public function getSaleState() : int
    {
        return $this->sale_state;
    }

    /**
     * @param string $sale_state
     */
    public function setSaleState( int $sale_state ) : void
    {
        $this->sale_state = $sale_state;
    }

	public function __construct( $options = [] )
	{
		if( isset( $options['is_on_sale'] ) ){
			$this->setOnSale( $options['is_on_sale'] );
		}
		if( isset( $options['title'] ) ){
			$this->setTitle( $options['title'] );
		}
		if( isset( $options['order_type'] ) ){
			$this->setOrderType( $options['order_type'] );
		}
		if( isset( $options['category_ids'] ) ){
			$this->setCategoryIds( $options['category_ids'] );
		}
		if( isset( $options['price'] ) ){
			$this->setPrice( $options['price'] );
		}
		if( isset( $options['ids'] ) ){
			$this->setIds( $options['ids'] );
		}
		if( isset( $options['page'] ) ){
			$this->setPage( $options['page'] );
		}

		if( isset( $options['not_in_ids'] ) ){
			$this->setNotInIds( $options['not_in_ids'] );
		}
        if( isset( $options['keywords'] ) ){
            $this->setKeywords( $options['keywords'] );
        }

        if( isset( $options['sale_state'] ) && in_array($options['sale_state'],[1,2,3])){
            $this->setSaleState( $options['sale_state'] );
        }
	}


	public function buildCondition() : void
	{
		if( !empty( $this->ids ) ){
			$this->condition['id'] = ['in', $this->ids];
		}

		if( !empty( $this->notInIds ) ){
			$this->condition['id'] = ['not in', $this->notInIds];
		}

		//是否需上架出售 0 否 1 是
		if( isset( $this->isOnSale ) ){
			$this->condition['is_on_sale'] = $this->isOnSale;
		}

		//商品标题
		if( !empty( $this->title ) ){
			$this->condition['title'] = ['like', '%'.$this->title.'%'];
		}

		// 分类
		if( !empty( $this->categoryIds ) && is_array( $this->categoryIds ) ){
			foreach( $this->categoryIds as $category_id ){
				$category_id_keywords[] = "%{$category_id}%";
			}
			$this->condition['category_ids'] = ['like', $category_id_keywords, 'or'];
		}
		//1商品价格低到高 2商品价格高到低 3销量多到少 4销量少到多 5库存多到少 6库存少到多 7创建时间早到晚 8创建时间晚到早 9排序高到低 10排序低到高
		if( !empty( $this->orderType ) ){
			switch( $this->orderType ){
			case 1:
				$this->order = 'price asc';
			break;

			case 2:
				$this->order = 'price desc';
			break;

			case 3:
				$this->order = 'sale_num desc';
			break;

			case 4:
				$this->order = 'sale_num asc';
			break;

			case 5:
				$this->order = 'stock desc';
			break;

			case 6:
				$this->order = 'stock asc';

			break;

			case 7:
				$this->order = 'create_time asc';
			break;

			case 8:
				$this->order = 'create_time desc';
			break;

				// (9排序高到低 10排序低到高 预留)
				// case 9:
				// 	$this->order = 'sort desc';
				// break;

				// case 10:
				// 	$this->order = 'sort asc';
				// break;
			default :
			break;
			}
		}

		if( !empty( $this->price ) ){
			$this->condition['price'] = [
				'between',
				$this->price,
			];
		}

        //商品标题
        if( !empty( $this->keywords ) ){
            $this->condition['title'] = ['like', '%'.$this->keywords.'%'];
        }

        //商品状态
        if( !empty( $this->sale_state ) ){
            switch ($this->sale_state) {
                case 1:
                    $this->condition['is_on_sale'] = 1;
                    break;
                case 2:
                    $this->condition['stock'] = 0;
                    break;
                case 3:
                    $this->condition['is_on_sale'] = 0;
                    break;
            }
        }

    }

	public function make() : \App\Model\Goods
	{
		if( empty( $this->make ) ){
			$this->buildCondition();
			$this->make = model( 'Goods' );
		}
		return $this->make;
	}

	public function count() : int
	{
		return $this->make()->where( $this->condition )->count();
	}

	public function list() : ? array
	{
		return $this->make()->getGoodsList( $this->condition, $this->field, $this->order, $this->page );
	}

	/**
	 * 获得商品列表
	 * @method     GET
	 * @datetime 2017-05-28T15:43:37+0800
	 * @author   韩文博
	 * @param array  $search_options 搜索条件
	 * @param string $field          字段
	 * @param string $order          排序
	 * @param string $page           分页
	 *                               $search_options 子参数
	 * @param array  $ids            商品id集合
	 * @param int    $category_id    分类id
	 * @param string $keywords       关键词 目前只对商品标题有效果
	 * @param array  $brand_items    品牌
	 * @param array  $attr_items     属性
	 * @param float  $price_from     价格区间开始
	 * @param float  $price_to       价格区间结束
	 * @return   array
	 */
	public function getGoodsList( $search_options, $field = "id,title,category_ids,price,img,freight", $order = '', $page = '1,10' )
	{
		$goods_common_model = model( 'Goods' );
		$goods_model        = model( 'Goods' );
		$goods_image_model  = model( 'GoodsImage' );
		$condition          = [];

		$in_goods_common_ids = [];
		// 商品
		if( isset( $search_options['ids'] ) ){
			$in_goods_common_ids = $goods_model->where( [
				'id' => [
					'in',
					$search_options['ids'],
				],
			] )->column( 'goods_common_id' );
		}

		// 分类
		if( isset( $search_options['category_id'] ) ){
			$category_ids                   = model( 'GoodsCategory', 'Logic' )->getSelfAndChildId( $search_options['category_id'] );
			$this->condition['category_id'] = ['in', $category_ids];
		}

		// 品牌
		if( is_array( $search_options['brand_items'] ) ){
			$this->condition['brand_id'] = ['in', $search_options['brand_items']];
		}

		// 属性
		if( is_array( $search_options['attr_items'] ) ){
			$attr_goods_common_ids = array_unique( model( 'GoodsAttributeIndex' )->where( [
				'in',
				$search_options['attr_items'],
			] )->column( 'goods_common_id' ) );
			$in_goods_common_ids   = array_merge( $in_goods_common_ids, $attr_goods_common_ids );
		}

		// 关键词
		if( $search_options['keywords'] ){
			$this->condition['title'] = ['like', '%'.$search_options['keywords'].'%'];
			// 记录用户的搜索
			model( 'GoodsSearchHistory' )->addGoodsSearchHistory( ['keywords' => $search_options['keywords']] );
		}

		// 城市
		if( intval( $search_options['city_id'] ) > 0 ){
			$this->condition['city_id'] = intval( $search_options['city_id'] );
		}

		// 区县
		if( intval( $search_options['area_id'] ) > 0 ){
			$this->condition['area_id'] = intval( $search_options['area_id'] );
		}

		// 判断商品和属性是否存在限制的id
		if( !empty( $in_goods_common_ids ) ){
			$this->condition['id'] = ['in', $in_goods_common_ids];
		}
		// 判断价格区间
		if( intval( $search_options['price_from'] ) >= 0 && intval( $search_options['price_to'] ) ){
			$this->condition['price'] = [
				['gt', intval( $search_options['price_from'] )],
				['lt', intval( $search_options['price_to'] )],
			];
		} else if( intval( $search_options['price_from'] ) >= 0 && empty( $search_options['price_to'] ) ){
			$this->condition['price'] = ['gt', intval( $search_options['price_from'] )];
		}
		$count = $goods_common_model->getGoodsOnlineCount( $condition );

		$goods_common_list = $goods_common_model->getGoodsOnlineList( $condition, $field, $order, $page );
		// 商品多图
		if( !empty( $goods_common_list ) ){

			$goods_common_ids = array_column( $goods_common_list, 'id' );

			// sku商品信息
			$goods_list = $goods_model->getGoodsList( [
				'goods_common_id' => [
					'in',
					$goods_common_ids,
				],
			], 'id,goods_common_id,stock,sale_num', 'id asc', '1,10000' );

			// 商品多图
			$goods_images = $goods_image_model->getGoodsImageList( [
				'goods_common_id' => [
					'in',
					$goods_common_ids,
				],
			], 'goods_common_id,img', 'sort asc', '1,5' );

			foreach( $goods_common_list as $key => $goods ){
				$goods_common_list[$key]['stock']    = 0;
				$goods_common_list[$key]['sale_num'] = 0;
				$goods_common_list[$key]['images']   = [];

				foreach( $goods_list as $goods_detail ){
					if( $goods['id'] == $goods_detail['goods_common_id'] ){
						$goods_common_list[$key]['stock']    += $goods_detail['stock'];
						$goods_common_list[$key]['sale_num'] += $goods_detail['sale_num'];
						$goods_common_list[$key]['id']       = $goods_detail['id'];

					}
				}
				// 商品多图
				foreach( $goods_images as $image ){
					if( $goods['id'] == $image['goods_common_id'] ){
						unset( $image['goods_common_id'] );
						$goods_common_list[$key]['images'][] = $image;
					}
				}
				// $goods_common_list[$key]['id'] = $goods_list[0]['id'];
			}
		}
		$result          = [];
		$result['count'] = $count;
		$result['list']  = (array)$goods_common_list;
		return $result;

	}

	/**
	 * 生成排序的sql语句
	 * @method     GET
	 * @datetime 2017-05-28T17:02:01+0800
	 * @author   韩文博
	 * @return   string
	 */
	public function generateGoodsOrderSql( $order_type, $order )
	{
		if( in_array( $order_type, [1, 2, 3] ) ){
			$sequence    = $this->order == 1 ? 'asc' : 'desc';
			$this->order = str_replace( [1, 2, 3], ['sale_num', 'visit_count', 'price'], $order_type );
			return $this->order .= ' '.$sequence;
		} else{
			return $this->order = 'sort asc,id desc';
		}
	}
}
