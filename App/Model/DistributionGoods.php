<?php
/**
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

namespace App\Model;




class DistributionGoods extends Model
{
	protected $softDelete = true;
	protected $createTime = true;

	/**
	 * 列表
	 * @param   $condition
	 * @param   $field
	 * @param   $order
	 * @param   $page
	 * @param   $group
	 * @return
	 */
	public function getDistributionGoodsList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
	{
		if( $page == '' ){
			$data = $this->where( $condition )->order( $order )->field( $field )->group( $group )->select();

		} else{
			$data = $this->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();
		}
		return $data;
	}

	/**
	 * 获得数量
	 * @param   $condition
	 * @param   $distinct [去重]
	 * @return
	 */
	public function getDistributionGoodsCount( $condition = [], $distinct = '' )
	{
		if( $distinct == '' ){
			return $this->where( $condition )->count();

		} else{
			return $this->where( $condition )->count( "DISTINCT ".$distinct );

		}
	}

    /**
     * 列表更多
     * @param   $condition
     * @param   $field
     * @param   $order
     * @param   $page
     * @param   $group
     * @return
     */
    public function getDistributionGoodsMoreList( $condition = [], $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
    {
        if( $page == '' ){
            return $this->join( 'goods', 'distribution_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->group( $group )->select();

        } else{
            return $this->join( 'goods', 'distribution_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->order( $order )->field( $field )->page( $page )->group( $group )->select();

        }
    }

    /**
     * 获得数量
     * @param   $condition
     * @param   $distinct [去重]
     * @return
     */
    public function getDistributionGoodsMoreCount( $condition = [], $distinct = '' )
    {
        if( $distinct == '' ){
            return $this->join( 'goods', 'distribution_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->count();

        } else{
            return $this->join( 'goods', 'distribution_goods.goods_id = goods.id', 'LEFT' )->where( $condition )->count( "DISTINCT ".$distinct );
        }
    }
	/**
	 * 获得信息
	 * @param   $condition
	 * @param   $field
	 * @return
	 */
	public function getDistributionGoodsInfo( $condition = [], $field = '*' )
	{
		$data = $this->where( $condition )->field( $field )->find();
		return $data;
	}


	/**
	 * 获取的id
	 * @param   $condition
	 * @return
	 */
	public function getDistributionGoodsId( $condition = [] )
	{
		return $this->where( $condition )->value( 'id' );
	}

	/**
	 * 获取某个字段
	 * @param   $condition
	 * @return
	 */
	public function getDistributionGoodsValue( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->value( $field );
	}

	/**
	 * 获取某个字段列
	 * @param   $condition

	 * @return
	 */
	public function getDistributionGoodsColumn( $condition = [], $field = 'id' )
	{
		return $this->where( $condition )->column( $field );
	}

	/**
	 * 某个字段+1
	 * @param   $condition

	 * @return
	 */
	public function setIncDistributionGoods( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setInc( $field, $num );
	}

	/**
	 * 某个字段-1
	 * @param   $condition
	 * @return
	 */
	public function setDecDistributionGoods( $condition = [], $field, $num = 1 )
	{
		return $this->where( $condition )->setDec( $field, $num );
	}

	/**
	 * 添加单条数据
	 * @param   $insert
	 */
	public function insertDistributionGoods( $insert = [] )
	{
		return $this->add( $insert ) ;
	}

	/**
	 * 添加多条数据
	 * @param   $insert
	 */
	public function insertAllDistributionGoods( $insert = [] )
	{
		return $this->addMulti( $insert );
	}

	/**
	 * 修改信息
	 * @param   $update [不需要包含id]
	 * @param   $condition
	 * @return
	 */
	public function updateDistributionGoods( $condition = [], $update = [] )
	{
		return $this->where( $condition )->edit( $update );
	}

	/**
	 * 修改多条数据
	 * @param   $update
	 */
	public function editMultiDistributionGoods( $update = [] )
	{
		return $this->editMulti( $update );
	}

	/**
	 * 删除
	 * @param   $condition
	 */
	public function delDistributionGoods( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

}
