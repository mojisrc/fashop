<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/5
 * Time: 下午7:13
 *
 */

namespace App\Cron;

use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\Image;
use EasyWeChat\Kernel\Messages\Voice;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Video;
use EasyWeChat\Kernel\Messages\Media;
use App\Logic\Wechat\Factory as WechatFactory;

/**
 * 微信群发
 * Class Broadcast
 */
class Broadcast
{

	public function __construct()
	{
		$this->wechat = new WechatFactory();
	}
	static function checkSend()
	{
		$wechat = new WechatFactory();
		$model  = model( 'WechatBroadcast' );
		$list   = $model->getWechatBroadcastList( [
			'send_state'     => 0,
			'send_time'      => ['elt', time()],
			'condition_type' => 1,
		] );
		if( !empty( $list ) ){
			foreach( $list as $item ){
				// `text`文本、`image`图片、`news`图文 、`voice`音频、 `video`视频
				if( $item['send_content']['type'] == 'text' ){
					$message = new Text( $item['send_content']['content'] );
				} elseif( $item['send_content']['type'] == 'image' ){
					$message = new Image( $item['send_content']['media_id'] );
				} elseif( $item['send_content']['type'] == 'news' ){
					// todo 接口还提供其他
					$message = new Media( $item['send_content']['media_id'], 'mpnews' );
				} elseif( $item['send_content']['type'] == 'voice' ){
					$message = new Voice( $item['send_content']['media_id'] );
				} elseif( $item['send_content']['type'] == 'video' ){
					$message = new Video( $item['send_content']['media_id'] );
				}
				// todo 测试返回的是个啥
				$result = $wechat->broadcast->sendMessage( $message, null );
				if( $result ){
					$model->editWechatBroadcast( ['id' => $item['id']], ['send_state' => 1] );
				} else{
					$model->editWechatBroadcast( ['id' => $item['id']], ['send_state' => 2] );
				}
			}
		}
	}

	// todo 封装到logic
	private function getOpenids( array $condition )
	{
		$db = \ezswoole\Db::name( 'User' );
		$db->alias( 'user' );
		$db->join( "wechat_user wechat_user", 'wechat_user.openid = user.wechat_openid', 'LEFT' );
		$db->join( "user_temp user_temp", 'user.id = user_temp.user_id', 'LEFT' );
		if( isset( $condition['sex'] ) ){
			if( $condition['sex'] == 3 ){
				$db->where( ['wechat_user.sex' => ['notin', [1, 2]]] );
			} else{
				$db->where( ['wechat_user.sex' => ['in', $condition['sex']]] );
			}
		}
		if( isset( $condition['area'] ) ){
			$db->where( ['wechat_user.province' => ['in', $condition['province']]] );
		}

		if( isset( $condition['user_tag'] ) ){
			$user_tag = $condition['user_tag'];
			$db->where( function( $query ) use ( $user_tag ){
				foreach( $user_tag as $tagId ){
					$query->whereOr( ['wechat_user.tagid_list' => ['like', '%'.$tagId.'%']] );
				}
			} );
		}

		if( isset( $condition['cost_average_price'] ) ){
			$cost_average_price = $condition['cost_average_price'];
			$db->where( function( $query ) use ( $cost_average_price ){
				foreach( $cost_average_price as $fromTo ){
					$query->whereOr( ['user_temp.cost_average_price' => ['between', $fromTo]] );
				}
			} );
		}

		if( isset( $condition['cost_times'] ) ){
			$cost_times = $condition['cost_times'];
			$db->where( function( $query ) use ( $cost_times ){
				foreach( $cost_times as $fromTo ){
					$query->whereOr( ['user_temp.cost_times' => ['between', $fromTo]] );
				}
			} );
		}

		if( isset( $condition['resent_cost_time'] ) ){
			$resent_cost_time = $condition['resent_cost_time'];
			$db->where( function( $query ) use ( $resent_cost_time ){
				foreach( $resent_cost_time as $fromTo ){
					$query->whereOr( ['user_temp.resent_cost_time' => ['between', $fromTo]] );
				}
			} );
		}

		if( isset( $condition['resent_visit_time'] ) ){
			$resent_visit_time = $condition['resent_visit_time'];
			$db->where( function( $query ) use ( $resent_visit_time ){
				foreach( $resent_visit_time as $fromTo ){
					$query->whereOr( ['user_temp.resent_visit_time' => ['between', $fromTo]] );
				}
			} );
		}

		if( isset( $condition['register_time'] ) ){
			$register_time = $condition['register_time'];
			$db->where( function( $query ) use ( $register_time ){
				foreach( $register_time as $fromTo ){
					$query->whereOr( ['user_temp.register_time' => ['between', $fromTo]] );
				}
			} );
		}
		$db->where( ["user.wechat_openid" => ['not null']] );
		$list = $db->field( 'wechat_user.openid' )->group( 'user.id' )->select();
		if( !empty( $list ) ){
			return array_column( $list, 'openid' );
		} else{
			return null;
		}
	}

}