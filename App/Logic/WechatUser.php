<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/6
 * Time: 上午10:12
 *
 */

namespace App\Logic;

use App\Logic\Wechat\Factory as WechatFactory;


/**
 * 微信管理
 * Class Wechat
 * @property \App\Logic\Wechat\Factory $wechat
 */
class WechatUser
{
	protected $wechat;

	public function __construct( array $options = null )
	{
		if( isset( $options['wechat'] ) ){
			$this->wechat = $options['wechat'];
		} else{
			$this->wechat = new WechatFactory();
		}
	}

	/**
	 * 根据openid集合批量更新微信用户信息
	 * @param array $openids
	 * @return bool
	 * @author 韩文博
	 */
	public function updateWechatUsersInfo( array $openids )
	{
		$_user_list       = $this->wechat->user->select( $openids );
		$wechatUserModel  = model( 'WechatUser' );
		$wechat_user_list = $wechatUserModel->getWechatUserList( [
			'openid' => [
				'in',
				$openids,
			],
		], 'id,openid', 'id desc', '1,100000' );
		$wechat_user_list = array_column( $wechat_user_list, null, 'openid' );
		foreach( $_user_list['user_info_list'] as $user ){
			$datas[] = [
				'id'             => $wechat_user_list[$user['openid']]['id'],
				'subscribe'      => $user['subscribe'],
				'nickname'       => $user['nickname'],
				'sex'            => $user['sex'],
				'language'       => $user['language'],
				'city'           => $user['city'],
				'province'       => $user['province'],
				'country'        => $user['country'],
				'headimgurl'     => $user['headimgurl'],
				'subscribe_time' => $user['subscribe_time'],
				'unionid'        => $user['unionid'],
				'remark'         => $user['remark'],
				'groupid'        => $user['groupid'],
				'tagid_list'     => json_encode( $user['tagid_list'] ),
			];
		}
		return $wechatUserModel->updateAll( $datas );
	}
}