<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/10
 * Time: 下午3:04
 *
 */

namespace App\Logic;


class Goods
{
	const onSale  = 1; // 出售中
	const offSale = 0; // 下架
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;
	/**
	 * @var int
	 */
	private $freightTemplateId;
	/**
	 * @var array
	 */
	private $images;
	/**
	 * @var array
	 */
	private $categoryIds;
	/**
	 * @var array
	 */
	private $skus;
	/**
	 * @var string
	 */
	private $img;
	/**
	 * @var float
	 */
	private $price;
	/**
	 * @var int
	 */
	private $baseSaleNum = 0;
	/**
	 * @var array
	 */
	private $body;
	/**
	 * @var int
	 */
	private $isOnSale = 1;
	/**
	 * @var int
	 */
	private $imageSpecId;
	/**
	 * @var array
	 */
	private $imageSpecImages;
	/**
	 * @var int
	 */
	private $stock = 0;

	/**
	 * @var float
	 */
	private $freight = 0;
	/**
	 * @var int
	 */
	private $saleTime;
	/**
	 * @var \Exception;
	 */
	private $exception;

	/**
	 * @var array
	 */
	private $skuList;

	/**
	 * @return array
	 */
	public function getSkusList() : array
	{
		return $this->skuList;
	}

	/**
	 * @param array $skuList
	 */
	public function setSkusList( array $skuList ) : void
	{
		$this->skuList = $skuList;
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
	 * @return int
	 */
	public function getFreightTemplateId() : int
	{
		return $this->freightTemplateId;
	}

	/**
	 * @param int $freightTemplateId
	 */
	public function setFreightTemplateId( int $freightTemplateId ) : void
	{
		$this->freightTemplateId = $freightTemplateId;
	}

	/**
	 * @return array
	 */
	public function getImages() : array
	{
		return $this->images;
	}

	/**
	 * @param array $images
	 */
	public function setImages( array $images ) : void
	{
		$this->images = $images;
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
	 * @return array
	 */
	public function getSkus() : array
	{
		return $this->skus;
	}

	/**
	 * @param array $skus
	 */
	public function setSkus( array $skus ) : void
	{
		$this->skus = $skus;
	}

	/**
	 * @return string
	 */
	public function getImg() : string
	{
		return $this->img;
	}

	/**
	 * @param string $img
	 */
	public function setImg( string $img ) : void
	{
		$this->img = $img;
	}

	/**
	 * @return float
	 */
	public function getPrice() : float
	{
		return $this->price;
	}

	/**
	 * @param float $price
	 */
	public function setPrice( float $price ) : void
	{
		$this->price = $price;
	}

	/**
	 * @return int
	 */
	public function getBaseSaleNum() : int
	{
		return $this->baseSaleNum;
	}

	/**
	 * @param int $baseSaleNum
	 */
	public function setBaseSaleNum( int $baseSaleNum ) : void
	{
		$this->baseSaleNum = $baseSaleNum;
	}

	/**
	 * @return array
	 */
	public function getBody() : array
	{
		return $this->body;
	}

	/**
	 * @param array $body
	 */
	public function setBody( array $body ) : void
	{
		$this->body = $body;
	}

	/**
	 * @return int
	 */
	public function getisOnSale() : int
	{
		return $this->isOnSale;
	}

	/**
	 * @param int $isOnSale
	 */
	public function setIsOnSale( int $isOnSale ) : void
	{
		$this->isOnSale = $isOnSale;
	}

	/**
	 * @return int
	 */
	public function getImageSpecId() : int
	{
		return $this->imageSpecId;
	}

	/**
	 * @param int $useImageSpecId
	 */
	public function setImageSpecId( int $useImageSpecId ) : void
	{
		$this->useImageSpecId = $useImageSpecId;
	}

	/**
	 * @return array
	 */
	public function getImageSpecImages() : array
	{
		return $this->imageSpecImages;
	}

	/**
	 * @param array $imageSpecImages
	 */
	public function setImageSpecImages( array $imageSpecImages ) : void
	{
		$this->imageSpecImages = $imageSpecImages;
	}

	/**
	 * @return int
	 */
	public function getStock() : int
	{
		return $this->stock;
	}

	/**
	 * @param int $stock
	 */
	public function setStock( int $stock ) : void
	{
		$this->stock = $stock;
	}

	/**
	 * @return float
	 */
	public function getFreight() : float
	{
		return $this->freight;
	}

	/**
	 * @param float $freight
	 */
	public function setFreight( float $freight ) : void
	{
		$this->freight = $freight;
	}

	/**
	 * @return int
	 */
	public function getSaleTime() : int
	{
		return $this->saleTime;
	}

	/**
	 * @var \App\Model\Goods
	 */
	private $model;

	/**
	 * @return \App\Model\Goods
	 */
	public function getModel() : \App\Model\Goods
	{
		if( !$this->model instanceof \App\Model\Goods ){
			$this->model = model( 'Goods' );
		}
		return $this->model;
	}

	/**
	 * @param int $saleTime
	 */
	public function setSaleTime( int $saleTime ) : void
	{
		$this->saleTime = $saleTime;
	}

	public function __construct( $options = [] )
	{
		if( isset( $options['id'] ) ){
			$this->id = $options['id'];
		}
		if( isset( $options['title'] ) ){
			$this->title = $options['title'];
		}
		if( isset( $options['images'] ) ){
			$this->images = $options['images'];
			$this->img    = $options['images'][0];
		}
		if( isset( $options['category_ids'] ) ){
			$category_ids = [];
			// 临时处理 应从验证下手
			foreach( $options['category_ids'] as $category_id ){
				$category_ids[] = (int)$category_id;
			}
			$this->categoryIds = $category_ids;
		}
		if( isset( $options['is_on_sale'] ) ){
			$this->isOnSale = $options['is_on_sale'];
		}

		if( isset( $options['base_sale_num'] ) ){
			$this->baseSaleNum = $options['base_sale_num'];
		}

		if( isset( $options['freight_id'] ) ){
			$this->freightTemplateId = $options['freight_id'];
		}
		if( isset( $options['freight'] ) ){
			$this->freight = $options['freight'];
		}
		if( isset( $options['sale_time'] ) ){
			$this->saleTime = $options['sale_time'];
		}
		if( isset( $options['image_spec_id'] ) ){
			$this->imageSpecId = $options['image_spec_id'];
		}

		if( isset( $options['skus'] ) ){
			$_static_value_exist_ids = [];
			$this->skus              = $options['skus'];
			foreach( $this->skus as $_sku_key => $sku ){
				// 初始化每个sku的图片（下面需要处理：如果选择了图片规格，自动设置为图片规格封面）
				$this->skus[$_sku_key]['img'] = $options['images'][0];
				// 规格json
				$_sku = $sku;
				unset( $_sku['id'] );
				$skuList[] = $_sku;
				// 价格
				if( $_sku_key === 0 ){
					$this->price = $sku['price'];
				} elseif( $this->price > $sku['price'] ){
					$this->price = $sku['price'];
				}
				// 库存
				$this->stock += $sku['stock'];

				// 规格层级集合json 不要重复，如色彩下有:xx色 xx 色
				foreach( $sku['spec'] as $spec ){
					if( !in_array( $spec['value_id'], $_static_value_exist_ids ) ){
						// 存着防止 sku 规格循环被重复记录
						$_static_value_exist_ids[]      = $spec['value_id'];
						$spec_list[$spec['id']]['id']   = $spec['id'];
						$spec_list[$spec['id']]['name'] = $spec['name'];
						$spec_value                     = [
							'id'   => $spec['value_id'],
							'name' => $spec['value_name'],
						];
						// 规格图片,防止0或空进来 当默认没规格时是会为空
						if( $this->imageSpecId && $spec['id'] && $this->imageSpecId == $spec['id'] ){
							$image_spec_images[] = $this->sku[$_sku_key]['img'] = $spec['value_img'];
						}
						$spec_list[$spec['id']]['value_list'][] = $spec_value;
					}
				}
			}
			unset( $_static_value_exist_ids );
			if( $this->imageSpecId && $this->imageSpecId > 0 ){
				$this->imageSpecImages = $image_spec_images;
			}

			$this->skuList  = $skuList;
			$this->specList = array_values( $spec_list );
		}

		if( isset( $options['body'] ) ){
			$this->body = $options['body'];
		}
	}


	const requiredFields
		= [
			'title',
			'images',
			'category_ids',
			'body',
			'price',
			'stock',
			'skus',
		];

	public function getSpecList()
	{
		foreach( $this->skus as $sku ){
			foreach( $sku['spec'] as $key => $spec ){
				$spec_list[$spec['id']]['id']           = $spec['id'];
				$spec_list[$spec['id']]['name']         = $spec['name'];
				$spec_list[$spec['id']]['value_list'][] = ['id' => $spec['value_id'], 'name' => $spec['value_name']];
			}
		}
		return array_values( $spec_list );
	}

	public function add() : bool
	{
		$addData = [
			'title'        => $this->title,
			'images'       => $this->images,
			'img'          => $this->img,
			'category_ids' => $this->categoryIds,
			'body'         => $this->body,
			'price'        => $this->price,
			'stock'        => $this->stock,
			'is_on_sale'   => $this->isOnSale,
			'sku_list'     => $this->skuList,
			'spec_list'    => $this->specList,
		];

		if( $this->freightTemplateId ){
			$addData['freight_id'] = $this->freightTemplateId;
		} else{
			$addData['freight'] = $this->freight;
		}

		if( $this->freightTemplateId ){
			$addData['freight_id'] = $this->freightTemplateId;
		} else{
			$addData['freight'] = $this->freight;
		}

		$addData['base_sale_time'] = ($this->baseSaleNum > 0) ? $this->baseSaleNum : 0;

		$addData['sale_time'] = ($this->saleTime > 0) ? $this->saleTime : time();

		$goodsModel = $this->getModel();

		$goodsModel->startTrans();
		try{
			$this->id = $goodsModel->addGoods( $addData );

			GoodsSku::make( [
				'goods_id'    => $this->id,
				'goods_title' => $this->title,
				'skus'        => $this->getSkus(),
			] )->add();
			GoodsImage::make( ['goods_id' => $this->id, 'images' => $this->getImages()] )->add();
			$goodsModel->commit();
			return true;
		} catch( \Exception $e ){
			$this->exception = $e;
			$goodsModel->rollback();
			return false;
		}
	}

	public function edit() : bool
	{
		$data = [
			'title'        => $this->title,
			'images'       => $this->images,
			'img'          => $this->img,
			'category_ids' => $this->categoryIds,
			'body'         => $this->body,
			'price'        => $this->price,
			'stock'        => $this->stock,
			'is_on_sale'   => $this->isOnSale,
			'sku_list'     => $this->skuList,
			'spec_list'    => $this->specList,
		];

		if( $this->freightTemplateId ){
			$data['freight_id'] = $this->freightTemplateId;
		} else{
			$data['freight'] = $this->freight;
		}


		$data['sale_time'] = ($this->saleTime > 0) ? $this->saleTime : time();

		$goodsModel = model( "Goods" );
		$goodsModel->startTrans();
		try{
			$result = $goodsModel->editGoods( ['id' => $this->id], $data );

			GoodsSku::make( ['goods_id' => $this->id, 'skus' => $this->skus] )->edit();

			$GoodsImage = GoodsImage::make( ['goods_id' => $this->id, 'images' => $this->images] );
			$GoodsImage->getModel()->softDelGoodsImage();
			$GoodsImage->add();

			$goodsModel->commit();
			return true;
		} catch( \Exception $e ){
			$this->exception = $e;
			$goodsModel->rollback();
			return false;
		}
	}

	/**
	 * @return \Exception
	 */
	public function getException() : \Exception
	{
		return $this->exception;
	}

	/**
	 * 批量删除
	 * @author 韩文博
	 * @param array $ids 商品id集合
	 */
	public function del( $ids ) : bool
	{
		$condition['lock'] = 0;
		$condition['id']   = ['in', $ids];
		$goods_model       = model( 'Goods' );
		$goods_model->startTrans();
		try{
			$goods_model->softDelGoods( ['id' => ['in', $ids]] );
			model( 'GoodsSku' )->softDelGoodsSku( ['id' => ['in', $ids]] );
			$goods_model->commit();
			return true;
		} catch( \Exception $e ){
			// 回滚事务
			$goods_model->rollback();
			return false;
		}
	}

	/**
	 * 下架
	 * @author 韩文博
	 * @param array $ids 商品id集合
	 * @author 韩文博
	 */
	public function offSale( array $ids )
	{
		$goods_return = model( 'Goods' )->editGoods( ['id' => ['in', $ids,],], ['is_on_sale' => self::offSale] );
		if( $goods_return ){
			return true;
		} else{
			return false;
		}
	}

	/**
	 * 上架
	 * @param array $ids
	 * @return bool
	 * @author 韩文博
	 */
	public function onSale( array $ids )
	{
		$goods_return = model( 'Goods' )->editGoods( ['id' => ['in', $ids,],], ['is_on_sale' => self::onSale] );
		if( $goods_return ){
			return true;
		} else{
			return false;
		}
	}
}