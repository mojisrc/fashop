<?php
/**
 * 优惠券
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

use ezswoole\Model;

class Voucher extends Model
{
	protected $softDelete = true;
	private $templatestate_arr = ['usable' => [1, '有效'], 'disabled' => [2, '失效']];

	/**
	 * 获得用户可用的优惠券
	 * @param int   $coupon_id   用户的优惠券id
	 * @param int   $user_id     会员ID
	 * @param array $goods_total 商品总金额
	 * @return string
	 */
	public function getUserAvailableVoucherInfo( $coupon_id, $user_id, $goods_total = 0 )
	{
		$condition['start_date'] = ['lt', time()];
		$condition['end_date']   = ['gt', time()];
		$condition['state']      = 1;
		$condition['limit']      = ['elt', $goods_total];
		$condition['owner_id']   = $user_id;
		$info                    = $this->getVoucherInfo( $condition );
		return $info;
	}

	/**
	 * 返回当前可用的优惠券列表
	 * @param int   $user_id     会员ID
	 * @param array $goods_total 商品总金额
	 * @return string
	 */
	public function getCurrentAvailableVoucherList( $user_id = 0, $goods_total = 0 )
	{
		$this->checkExpired();
		$condition               = [];
		$condition['owner_id']   = $user_id;
		$condition['start_date'] = ['lt', time()];
		$condition['end_date']   = ['gt', time()];
		$condition['state']      = 1;
		$condition['limit']      = ['elt', $goods_total];
		$list                    = $this->getVoucherList( $condition, '*', 'id desc', '1,100' );
		foreach( $list as $key => $coupon ){
			$list[$key]['desc'] = sprintf( '面额%s元 有效期至 %s', $coupon['price'], date( 'Y-m-d', $coupon['end_date'] ) );
		}
		return $list;
	}

	/**
	 * 领取优惠券
	 * @param int $template_id
	 * @param int $user_id
	 * @return bool
	 */
	public function receiveVoucher( $data )
	{
		$result = $this->insertGetId( $data );
		if( $result ){
			$result = VoucherTemplate::where( ['id' => $data['template_id']] )->setInc( 'giveout' );
		}
		return $result;
	}

	/**
	 * 设置过期优惠券
	 */
	public function checkExpired()
	{
		return $this->where( ['end_date' => ['lt', time()], 'state' => ['neq', 2]] )->edit( ['state' => 3] );
	}

	/**
	 * todo 给后台用的
	 * 获得某个模板的信息，包括领取的次数
	 * @param $template_id 模板id
	 * @param $user_id     用户id
	 * @return array
	 */
	public function getUserTemplateVoucher( $template_id, $user_id )
	{
		$result = [];
		$result = Db::table( '__VOUCHER_TEMPLATE__ template' )->field( 'template.*,(SELECT count(*) FROM '.config( 'database.prefix' ).'coupon WHERE owner_id = '.$user_id.' AND template_id = '.$template_id.') as receive_times' )->where( ['template.id' => $template_id, 'state' => 1, 'end_date' => ['gt', time()]] )->find();
		return $result;
	}

	/**
	 *
	 * todo 给后台用的
	 *
	 * 查询可用的优惠券详细信息
	 */
	public function getUsableTemplateInfo( $vid )
	{
		if( empty( $vid ) ){
			return [];
		}

		$info = $this->table( '__VOUCHER_TEMPLATE__ template' )->field( 'template.*' )->where( ['id' => $vid, 'state' => $this->templatestate_arr['usable'][0], 'end_date' => ['gt', time()]] )->find();

		if( empty( $info ) || $info['total'] <= $info['giveout'] ){
			$info = [];
		}
		return $info;
	}

	/**
	 * 获取优惠券编码
	 */
	public function getCode( $user_id = 0 )
	{
		return mt_rand( 10, 99 ).sprintf( '%010d', time() - 946656000 ).sprintf( '%03d', (float)microtime() * 1000 ).sprintf( '%03d', (int)$user_id % 1000 );
	}

	/**
	 * 添加
	 * @datetime 2017-05-25 19:07:07
	 * @param  array $data
	 * @return int pk
	 */
	public function addVoucher( $data = [] )
	{
		$data['code']        = $this->getCode();
		$data['create_time'] = time();
		return $this->add( $data );
	}

	/**
	 * 添加多条
	 * @datetime 2017-05-25 19:07:07
	 * @param array $data
	 * @return boolean
	 */
	public function addVoucherAll( $data )
	{
		return $this->insertAll( $data );
	}

	/**
	 * 修改
	 * @datetime 2017-05-25 19:07:07
	 * @param    array $condition
	 * @param    array $data
	 * @return   boolean
	 */
	public function editVoucher( $condition = [], $data = [] )
	{
		return $this->where($condition)->edit($data);
	}

	/**
	 * 删除
	 * @datetime 2017-05-25 19:07:07
	 * @param    array $condition
	 * @return   boolean
	 */
	public function delVoucher( $condition = [] )
	{
		return $this->where( $condition )->del();
	}

	/**
	 * 计算数量
	 * @datetime 2017-05-25 19:07:07
	 * @param array $condition 条件
	 * @return int
	 */
	public function getVoucherCount( $condition )
	{
		return $this->where( $condition )->count();
	}

	/**
	 * 获取优惠券单条数据
	 * @datetime 2017-05-25 19:07:07
	 * @param array  $condition 条件
	 * @param string $field     字段
	 * @return array | false
	 */
	public function getVoucherInfo( $condition = [], $field = '*' )
	{
		$info = $this->where( $condition )->field( $field )->find();
		return $info;
	}

	/**
	 * 获得优惠券列表
	 * @datetime 2017-05-25 19:07:07
	 * @param    array  $condition
	 * @param    string $field
	 * @param    string $order
	 * @param    string $page
	 * @return   array | false
	 */
	public function getVoucherList( $condition = [], $field = '*', $order = '', $page = '1,10' )
	{
		$list = $this->where( $condition )->order( $order )->field( $field )->page( $page )->select();
		return $list;
	}
}

?>