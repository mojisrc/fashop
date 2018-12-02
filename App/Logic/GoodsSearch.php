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
	 * @var boolean
	 */
	private $make;
	/**
	 * @var string
	 */
	private $field = "*";
	/**
	 * @var array | float
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
	 * @var string
	 */
	private $keywords;

	/**
	 * @var int
	 */
	private $saleState;

	/**
	 * @var array [ 'gt' , time()]
	 */
	private $saleTime;


	/**
	 * @param array $ids
	 */
	public function setIds( array $ids ) : void
	{
		$this->ids = $ids;
	}

	/**
	 * @param array $condition
	 */
	public function setCondition( array $condition ) : void
	{
		$this->condition = $condition;
	}

	/**
	 * @param string $page
	 */
	public function setPage( string $page ) : void
	{
		$this->page = $page;
	}

	/**
	 * @param string $field
	 */
	public function setField( string $field ) : void
	{
		$this->field = $field;
	}

	/**
	 * @param int $isOnSale
	 */
	public function setOnSale( int $isOnSale ) : void
	{
		$this->isOnSale = $isOnSale;
	}

	/**
	 * @param array $categoryIds
	 */
	public function setCategoryIds( array $categoryIds ) : void
	{
		$this->categoryIds = $categoryIds;
	}

	/**
	 * @param int $order_type
	 */
	public function setOrderType( int $order_type ) : void
	{
		$this->orderType = $order_type;
	}

	/**
	 * @param string $title
	 */
	public function setTitle( string $title ) : void
	{
		$this->title = $title;
	}

	/**
	 * @param string $order
	 */
	public function setOrder( string $order ) : void
	{
		$this->order = $order;
	}

	/**
	 * @param array $price
	 */
	public function setPrice( array $price ) : void
	{
		$this->price = $price;
	}

	/**
	 * @param array $ids
	 */
	public function setNotInIds( array $notInIds ) : void
	{
		$this->ids = $notInIds;
	}

	/**
	 * @param string $keywords
	 */
	public function setKeywords( string $keywords ) : void
	{
		$this->keywords = $keywords;
	}

	/**
	 * @var \App\Model\Goods
	 */
	public $goodsModel;
	/**
	 * @var \App\Model\GoodsSku
	 */
	public $goodsSkuModel;
	/**
	 * @var \App\Model\GoodsImage
	 */
	public $goodsImageModel;

	/**
	 * @param string $sale_state
	 */
	public function setSaleState( int $sale_state ) : void
	{
		$this->saleState = $sale_state;
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

		if( isset( $options['sale_state'] ) && in_array( $options['sale_state'], [1, 2, 3] ) ){
			$this->setSaleState( $options['sale_state'] );
		}
		if( isset( $options['sale_time'] )){
			$this->saleTime = $options['sale_time'];
		}

		$this->goodsModel      = model( 'Goods' );
		$this->goodsSkuModel   = model( 'GoodsSku' );
		$this->goodsImageModel = model( 'GoodsImage' );
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
		if( isset( $this->saleTime ) ){
			$this->condition['sale_time'] = $this->saleTime;
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

		if( !empty( $this->price )){
			if(is_array($this->price)){
				$this->condition['price'] = [
					'between',
					$this->price,
				];
			}else{
				$this->condition['price'] = $this->price;
			}
		}

		//商品标题
		if( !empty( $this->keywords ) ){
			$this->condition['title'] = ['like', '%'.$this->keywords.'%'];
		}

		//商品状态
		if( !empty( $this->sale_state ) ){
			switch( $this->sale_state ){
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

	public function make() : void
	{
		if( empty( $this->make ) ){
			$this->buildCondition();
			$this->make = true;
		}
	}

	public function count() : int
	{
		$this->make();
		return $this->goodsModel->where( $this->condition )->count();
	}

	public function list() : ?array
	{
		$this->make();
		return $this->goodsModel->getGoodsList( $this->condition, $this->field, $this->order, $this->page );
	}

	/**
	 * 获得商品列表
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
	 * @param float  $price_from     价格区间开始
	 * @param float  $price_to       价格区间结束
	 * @return   array
	 */
	public function getGoodsList( $search_options, $field = "id,title,category_ids,price,img,freight", $order = '', $page = '1,10' )
	{
		// 分类
		if( isset( $search_options['category_id'] ) ){
			$category_ids                   = model( 'GoodsCategory', 'Logic' )->getSelfAndChildId( $search_options['category_id'] );
			$this->condition['category_id'] = ['in', $category_ids];
		}
		return $this->goodsModel->getGoodsList( $this->condition, $field, $order, $page );

	}
}
