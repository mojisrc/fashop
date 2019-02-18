<?php
/**
 * 分销员客户关系
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




class DistributorCustomer extends Model
{
    protected $softDelete = true;

    /**
     * 列表
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @param   $order
     * @param   $page
     * @param   $group
     * @return
     */
    public function getDistributorCustomerList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
    {
        if( $page == '' ){
            $data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

        } else{
            $data = $this->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();
        }
        return $data;
    }

    /**
     * 获得数量
     * @param   $condition
     * @param   $condition_str
     * @param   $distinct [去重]
     * @return
     */
    public function getDistributorCustomerCount( $condition = [], $condition_str = '', $distinct = '' )
    {
        if( $distinct == '' ){
            return $this->where( $condition )->where( $condition_str )->count();
        } else{
            return $this->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );

        }
    }

    /**
     * 列表更多
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @param   $order
     * @param   $page
     * @param   $group
     * @return
     */
    public function getDistributorCustomerMoreList( $condition = [], $condition_str = '', $field = '*', $order = 'id desc', $page = [1,20], $group = '' )
    {
        if( $page == '' ){
            return $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->group( $group )->select();

        } else{
            return $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order( $order )->field( $field )->page( $page )->group( $group )->select();

        }
    }

    /**
     * 获得数量
     * @param   $condition
     * @param   $condition_str
     * @param   $distinct [去重]
     * @return
     */
    public function getDistributorCustomerMoreCount( $condition = [], $condition_str = '', $distinct = '' )
    {
        if( $distinct == '' ){
            return $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count();

        } else{
            return $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->count( "DISTINCT ".$distinct );
        }
    }

    /**
     * 获得信息
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @return
     */
    public function getDistributorCustomerInfo( $condition = [], $condition_str = '', $field = '*' )
    {
        $data = $this->where( $condition )->where( $condition_str )->field( $field )->find();
        return $data;
    }

    /**
     * 获得信息更多
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @return
     */
    public function getDistributorCustomerMoreInfo( $condition = [], $condition_str = '', $field = '*' )
    {
        $data = $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->field( $field )->find();
        return $data;
    }

    /**
     * 获得信息更多
     * @param   $condition
     * @param   $condition_str
     * @param   $field
     * @return
     */
    public function getDistributorCustomerMoreSortInfo( $condition = [], $condition_str = '', $field = 'distributor_customer.*', $order = 'distributor_customer.create_time desc' )
    {
        $data = $this->join( 'user AS distributor_user', 'distributor_customer.distributor_user_id = distributor_user.id', 'LEFT' )->join( 'user', 'distributor_customer.user_id = user.id', 'LEFT' )->where( $condition )->where( $condition_str )->order($order)->field( $field )->find();
        return $data;
    }
    /**
     * 获取的id
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function getDistributorCustomerId( $condition = [], $condition_str = '' )
    {
        return $this->where( $condition )->where( $condition_str )->value( 'id' );
    }

    /**
     * 获取某个字段
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function getDistributorCustomerValue( $condition = [], $condition_str = '', $field = 'id' )
    {
        return $this->where( $condition )->where( $condition_str )->value( $field );
    }

    /**
     * 获取某个字段列
     * @param   $condition
     * @param   $condition_str
     * @return
     */
    public function getDistributorCustomerColumn( $condition = [], $condition_str = '', $field = 'id' )
    {
        return $this->where( $condition )->where( $condition_str )->column( $field );
    }

    /**
     * 添加单条数据
     * @param   $insert
     */
    public function insertDistributorCustomer( $insert = [] )
    {
        return $this->add( $insert );
    }

    /**
     * 添加多条数据
     * @param   $insert
     */
    public function insertAllDistributorCustomer( $insert = [] )
    {
        return $this->addMulti( $insert );
    }

    /**
     * 修改信息
     * @param   $update
     * @param   $condition
     * @return
     */
    public function updateDistributorCustomer( $condition = [], $update = [] )
    {
        return $this->where( $condition )->edit( $update );
    }

    /**
     * 修改多条数据
     * @param   $update
     */
    public function editMultiDistributorCustomer( $update = [] )
    {
        return $this->editMulti( $update );
    }

    /**
     * 删除
     * @param   $condition
     * @param   $condition_str
     */
    public function delDistributorCustomer( $condition = [], $condition_str = '' )
    {
        return $this->where( $condition )->where( $condition_str )->del();
    }

    /**
     * 软删除
     * @param   $condition
     */
    public function softDelDistributorCustomer( $condition = [] )
    {
        return $this->save( ['delete_time' => time()], $condition );
    }

}
