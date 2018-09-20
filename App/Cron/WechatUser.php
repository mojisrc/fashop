<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/2
 * Time: 下午4:59
 *
 */

namespace App\Cron;

use App\Logic\Wechat\Factory as WechatFactory;

class WechatUser
{
	// 添加微信用户
	static function addUser()
	{
		$config = model( 'Wechat' )->getWechatInfo( ['id' => 1] );
		if( isset( $config['app_id'] ) && !empty( $config['app_id'] ) ){
			$wechat = new WechatFactory();
			// 获得最后一个openid
			$wechatUserModel  = model( 'WechatUser' );
			$last_user        = $wechatUserModel->getWechatUserInfo( ['app_id' => $config['app_id']], '*', 'id desc' );
			$user_openid_list = $wechat->user->list( $last_user['openid'] ? $last_user['openid'] : null );
			if(!empty($user_openid_list) && isset($user_openid_list['data']) && $user_openid_list['data']['openid']){
				$openids          = $user_openid_list['data']['openid'];
				$openids_chunks = array_chunk($openids,100);
				if( !empty( $openids )  ){
					$now_time = time();
					foreach($openids_chunks as $_openids){
						$_user_list = $wechat->user->select( $_openids );
						$user_list = $_user_list['user_info_list'];
						foreach( $user_list as $user ){
							$datas[] = [
								'app_id'         => $config['app_id'],
								'subscribe'      => $user['subscribe'],
								'openid'         => $user['openid'],
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
								'update_time'    => $now_time,
							];
						}
					}
					$wechatUserModel->addWechatUserAll( $datas );
				}
			}

		}
	}

	// 更新微信用户
	static function updateUserInfo()
	{
		// todo 批量异步执行，一步到位
		$config = model( 'Wechat' )->getWechatInfo( ['id' => 1] );
		$wechatUserModel  = model( 'WechatUser' );
		$user_list = $wechatUserModel->getWechatUserList(['app_id' => $config['app_id']],'id,openid','');
		// 获得
		if( !empty( $user_list ) && is_array( $user_list ) ){
			$now_time = time();
			foreach( $user_list as $key => $user ){
				$datas[] = [
					'app_id'         => $config['app_id'],
					'subscribe'      => $user['subscribe'],
					'openid'         => $user['openid'],
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
					'update_time'    => $now_time,
				];
			}
			model( 'User' )->addAllUser( $datas );
		}
	}
}