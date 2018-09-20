<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/26
 * Time: 下午9:01
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use App\Logic\Wechat\Factory as WechatFactory;
use EasySwoole\Core\Utility\File;

/**
 * 微信管理
 * Class Wechat
 * @package App\HttpController\Admin
 * @property \App\Logic\Wechat\Factory $wechat
 */
class Wechat extends Admin
{
	protected $wechat;

	protected function _initialize()
	{
		$this->wechat = new WechatFactory();
	}

	/**
	 * 获得token
	 * @method GET
	 * @param bool $refresh
	 * @author 韩文博
	 */
	public function getToken()
	{
		if( isset( $this->get['refresh'] ) ){
			$token = $this->wechat->accessToken->getToken();
		} else{
			$token = $this->wechat->accessToken->getToken( true );
		}
		return $this->send( Code::success, $token );
	}

	/**
	 * 读取（查询）已设置菜单
	 * @method GET
	 * @author 邓凯
	 */
	public function menuList()
	{
		$list = $this->wechat->menu->list();
		return $this->send( Code::success, $list );
	}

	/**
	 * 获取当前菜单
	 * @method GET
	 * @author 邓凯
	 */
	public function menuCurrent()
	{
		$list = $this->wechat->menu->current();
		return $this->send( Code::success, $list );
	}

	/**
	 * 创建自定义菜单
	 * @method POST
	 * @param array $buttons
	 * @author 邓凯
	 */
	public function menuCreate()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Menu.create' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->menu->create( $this->post['buttons'] );
			return $this->send( Code::success, $result );
		}
	}

	/**
	 * 删除菜单
	 * @method POST
	 * @param int $menu_id
	 * 有两种删除方式，一种是全部删除，另外一种是根据菜单 ID 来删除(删除个性化菜单时用，ID 从查询接口获取)
	 * @author 韩文博
	 */
	public function menuDelete()
	{
		if( isset( $this->post['menu_id'] ) ){
			$this->wechat->menu->delete( $this->post['id'] );
		} else{
			$this->wechat->menu->delete();
		}
		return $this->send( Code::success );
	}

	/**
	 * 消息群发用户筛选
	 * @method POST
	 * @param string $condition_type 1全部粉丝  2按条件筛选 3手动选择粉丝
	 * @param int    $sex            性别，默认全部，1男2女，3保密
	 * @param array  $province       地区
	 * @param array  $cost_average_price
	 * @param array  $cost_times
	 * @param array  $resent_cost_time
	 * @param array  $resent_visit_time
	 * @param array  $register_time
	 * @param array user_tag
	 * @author 韩文博
	 */
	public function broadcastUserSearch()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Broadcast.userSearch' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$db = \ezswoole\Db::name( 'User' );
			$db->alias( 'user' );
			$db->join( "wechat_user wechat_user", 'wechat_user.openid = user.wechat_openid', 'LEFT' );
			$db->join( "user_temp user_temp", 'user.id = user_temp.user_id', 'LEFT' );


			if( $this->post['condition_type'] == 1 ){

			} elseif( $this->post['condition_type'] == 2 ){
				if( isset( $this->post['sex'] ) ){
					if( $this->post['sex'] == 3 ){
						$db->where( ['wechat_user.sex' => ['notin', [1, 2]]] );
					} else{
						$db->where( ['wechat_user.sex' => ['in', $this->post['sex']]] );
					}
				}
				if( isset( $this->post['area'] ) ){
					$db->where( ['wechat_user.province' => ['in', $this->post['province']]] );
				}

				if( isset( $this->post['user_tag'] ) ){
					$user_tag = $this->post['user_tag'];
					$db->where( function( $query ) use ( $user_tag ){
						foreach( $user_tag as $tagId ){
							$query->whereOr( ['wechat_user.tagid_list' => ['like', '%'.$tagId.'%']] );
						}
					} );
				}

				if( isset( $this->post['cost_average_price'] ) ){
					$cost_average_price = $this->post['cost_average_price'];
					$db->where( function( $query ) use ( $cost_average_price ){
						foreach( $cost_average_price as $fromTo ){
							$query->whereOr( ['user_temp.cost_average_price' => ['between', $fromTo]] );
						}
					} );
				}

				if( isset( $this->post['cost_times'] ) ){
					$cost_times = $this->post['cost_times'];
					$db->where( function( $query ) use ( $cost_times ){
						foreach( $cost_times as $fromTo ){
							$query->whereOr( ['user_temp.cost_times' => ['between', $fromTo]] );
						}
					} );
				}

				if( isset( $this->post['resent_cost_time'] ) ){
					$resent_cost_time = $this->post['resent_cost_time'];
					$db->where( function( $query ) use ( $resent_cost_time ){
						foreach( $resent_cost_time as $fromTo ){
							$query->whereOr( ['user_temp.resent_cost_time' => ['between', $fromTo]] );
						}
					} );
				}

				if( isset( $this->post['resent_visit_time'] ) ){
					$resent_visit_time = $this->post['resent_visit_time'];
					$db->where( function( $query ) use ( $resent_visit_time ){
						foreach( $resent_visit_time as $fromTo ){
							$query->whereOr( ['user_temp.resent_visit_time' => ['between', $fromTo]] );
						}
					} );
				}

				if( isset( $this->post['register_time'] ) ){
					$register_time = $this->post['register_time'];
					$db->where( function( $query ) use ( $register_time ){
						foreach( $register_time as $fromTo ){
							$query->whereOr( ['user_temp.register_time' => ['between', $fromTo]] );
						}
					} );
				}
			}

			$db->where( ["user.wechat_openid" => ['not null']] );
			$total_number = $db->count( 'DISTINCT wechat_user.openid' );
			$this->send( Code::success, ['total_number' => $total_number] );
		}
	}

	/**
	 * 群发当日可发送状态检查
	 * @method GET
	 * @param string $condition_type 1全部粉丝  2按条件筛选 3手动选择粉丝
	 * @param int $send_time
	 * @author 韩文博
	 */
	public function broadcastSurplus()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/Broadcast.surplus' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$conf = model( 'Wechat' )->getWechatInfo( ['id' => 1], 'app_key,app_secret,level' );
			if( $conf['app_key'] && $conf['app_secret'] && in_array( $conf['level'], [1, 2, 3, 4] ) ){
				$model = model( 'WechatBroadcast' );
				// 每月4次
				$send_time = $this->get['send_time'];
				if( in_array( $conf['level'], [2, 4] ) ){
					$beginThismonth         = mktime( 0, 0, 0, date( 'm', $send_time ), 1, date( 'Y', $send_time ) );
					$endThismonth           = mktime( 23, 59, 59, date( 'm', $send_time ), date( 't', $send_time ), date( 'Y', $send_time ) );
					$condition['send_time'] = ['between', [$beginThismonth, $endThismonth]];
					$total_number           = $model->where( $condition )->count();
					$can_send_state         = $total_number >= 4 ? 0 : 1;
				} else{
					$beginToday = strtotime( date( 'Y-m-d ', $send_time )."00:00:00" );
					$endToday   = strtotime( date( 'Y-m-d ', $send_time )."23:59:59" );;
					$condition['send_time'] = ['between', [$beginToday, $endToday]];
					$total_number           = $model->where( $condition )->count();
					$can_send_state         = $total_number > 0 ? 0 : 1;
				}
				$this->send( Code::success, [
					'send_number'    => $total_number,
					'can_send_state' => $can_send_state,
				] );
			} else{
				$this->send( Code::error, [], '请先配置微信众号秘钥及公类型' );
			}
		}

	}

	/**
	 * 群发创建
	 * @method POST
	 * @param string $condition_type 1全部粉丝  2按条件筛选 3手动选择粉丝
	 * @param array  $condition
	 * @param int    $send_time
	 * @param array  $send_content
	 * @author 韩文博
	 */
	public function broadcastCreate()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Broadcast.create' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$conf = model( 'Wechat' )->getWechatInfo( ['id' => 1], 'app_key,app_secret,level' );
			if( $conf['app_key'] && $conf['app_secret'] && in_array( $conf['level'], [1, 2, 3, 4] ) ){
				$model = model( 'WechatBroadcast' );
				// 每月4次
				$send_time = $this->post['send_time'];
				if( in_array( $conf['level'], [2, 4] ) ){
					$beginThismonth         = mktime( 0, 0, 0, date( 'm', $send_time ), 1, date( 'Y', $send_time ) );
					$endThismonth           = mktime( 23, 59, 59, date( 'm', $send_time ), date( 't' ), date( 'Y', $send_time ) );
					$condition['send_time'] = ['between', [$beginThismonth, $endThismonth]];
					$total_number           = $model->where( $condition )->count();
					$can_send_state         = $total_number >= 4 ? 0 : 1;
				} else{
					$beginToday = strtotime( date( 'Y-m-d ', $send_time )."00:00:00" );
					$endToday   = strtotime( date( 'Y-m-d ', $send_time )."23:59:59" );;
					$condition['send_time'] = ['between', [$beginToday, $endToday]];
					$total_number           = $model->where( $condition )->count();
					$can_send_state         = $total_number > 0 ? 0 : 1;
				}

				if( $can_send_state ){
					$data                      = $this->post;
					$data['send_content_type'] = $this->post['send_content']['type'];
					model( 'WechatBroadcast' )->addWechatBroadcast( $data );
					$this->send( Code::success );
				} else{
					$this->send( Code::error, [], '已达到发送当月或当日的最大发送频率' );
				}

			} else{
				$this->send( Code::error, [], '请先配置微信众号秘钥及公类型' );
			}
		}
	}

	/**
	 * 群发记录
	 * @method GET
	 * @author 韩文博
	 */
	public function broadcastRecords()
	{
		$condition = [];
		if( isset( $this->get['send_state'] ) ){
			$condition['send_state'] = $this->get['send_state'];
		}
		if( isset( $this->get['send_content_type'] ) ){
			$condition['send_content_type'] = $this->get['send_content_type'];
		}
		$model = model( 'WechatBroadcast' );
		$count = $model->where( $condition )->count();
		$list  = $model->getWechatBroadcastList( $condition, '*', 'create_time desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $count,
			'list'         => $list,
		] );
	}

	/**
	 * 群发记录删除
	 * @method POST
	 * @param int $id
	 * @author 韩文博
	 */
	public function broadcastRecordsDel()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Broadcast.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'WechatBroadcast' )->delWechatBroadcast( ['id' => $this->post['id']] );
			$this->send( Code::success );
		}
	}

	/**
	 * 获取单个用户信息
	 * @method GET
	 * @param string $openid
	 * @author 邓凯
	 */
	public function userGet()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/User.get' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$info = $this->wechat->user->get( $this->get['openid'] );
			$this->send( Code::success, $info );
		}
	}

	/**
	 * 获取多个用户信息
	 * @method POST
	 * @param array $openids
	 * @author 韩文博
	 */
	public function userSelect()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/User.select' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$list = $this->wechat->user->select( $this->post['openids'] );
			$this->send( Code::success, $list );
		}
	}

	/**
	 * 获取用户列表
	 * @method GET
	 * @param string $next_openid 非必填，不填默认为第一页
	 * @author 韩文博
	 */
	public function userList()
	{
		if( isset( $this->get['next_openid'] ) ){
			$list = $this->wechat->user->list( $this->get['next_openid'] );
		} else{
			$list = $this->wechat->user->list();
		}
		$this->send( Code::success, $list );
	}

	/**
	 * 修改用户备注
	 * @method POST
	 * @param string $openid
	 * @param string $remark
	 * @author 韩文博
	 */
	public function userRemark()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/User.remark' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->user->remark( $this->post['openid'], $this->post['remark'] );
			$this->send( Code::success, $result );
		}
	}

	/**
	 * 拉黑用户
	 * @method POST
	 * @author 韩文博
	 * @param array $openids
	 */
	public function userBlock()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/User.block' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->user->block( $this->post['openids'] );
			$this->send( Code::success, $result );
		}
	}

	/**
	 * 取消拉黑用户
	 * @method POST
	 * @param array $openids
	 * @author 韩文博
	 */
	public function userUnblock()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/User.unblock' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->user->unblock( $this->post['openids'] );
			$this->send( Code::success, $result );
		}
	}

	/**
	 * 黑名单列表
	 * @method GET
	 * @param string $begin_openid
	 * @author 韩文博
	 */
	public function userBlackList()
	{
		if( isset( $this->get['begin_openid'] ) ){
			$list = $this->wechat->user->blacklist( $this->get['begin_openid'] );
		} else{
			$list = $this->wechat->user->blacklist();
		}
		$this->send( Code::success, $list );

	}


	/**
	 * todo 2M，支持bmp/png/jpeg/jpg/gif格式
	 * 上传图片
	 * @method POST
	 * @param file $media
	 * @author 韩文博
	 */
	public function materialUploadImage()
	{
		if( $this->validate( $this->request->file(), 'Admin/Wechat/Material.uploadImage' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$media          = $this->request->file( 'media' );
			$timeRand       = time().rand( 100, 999 );
			File::createDir(TEMP_PATH."Wechat/Material");
			$targetPathName = TEMP_PATH."Wechat/Material/".$timeRand.$media['name'];
			$moveResult     = File::copyFile( $media['tmp_name'], $targetPathName );
			if( $moveResult !== true ){
				$this->send( Code::error, [], '创建文件失败' );
			} else{
				$result = $this->wechat->material->uploadImage( $targetPathName );
				if( !$result || isset($result['errcode'])){
					$this->send( Code::error, [], $result );
				} else{
					File::deleteFile( $targetPathName );
					File::deleteFile( $media['tmp_name'] );
					$this->send( Code::success ,$result);
				}
			}
		}
	}

	/**
	 * todo 2M，播放长度不超过60s，mp3/wma/wav/amr格式
	 * 上传声音
	 * @method POST
	 * @param file $media
	 * @author 韩文博
	 */
	public function materialUploadVoice()
	{
		if( $this->validate( $this->request->file(), 'Admin/Wechat/Material.uploadVoice' ) !== true ){
			 $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$media          = $this->request->file( 'media' );
			$timeRand       = time().rand( 100, 999 );
			File::createDir(TEMP_PATH."Wechat/Material");
			$targetPathName = TEMP_PATH."Wechat/Material/".$timeRand.$media['name'];
			$moveResult     = File::copyFile( $media['tmp_name'], $targetPathName );
			if( $moveResult !== true ){
				$this->send( Code::error, [], '创建文件失败' );
			} else{
				$result = $this->wechat->material->uploadImage( $targetPathName );
				if( !$result || isset($result['errcode'])){
					$this->send( Code::error, [], $result );
				} else{
					File::deleteFile( $targetPathName );
					File::deleteFile( $media['tmp_name'] );
					$this->send( Code::success ,$result);
				}
			}
		}
	}

	/**
	 * todo 限制 10MB，支持MP4格式
	 * 上传声音
	 * @method POST
	 * @param string $title
	 * @param string $description
	 * @param file   $media
	 * @author 韩文博
	 */
	public function materialUploadVideo()
	{
		$data = [
			'title'       => $this->post['title'],
			'description' => $this->post['description'],
			'media'       => $this->request->file( 'media' ),
		];
		if( $this->validate( $data, 'Admin/Wechat/Material.uploadVideo' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$media          = $data['media'];
			$timeRand       = time().rand( 100, 999 );
			File::createDir(TEMP_PATH."Wechat/Material");
			$targetPathName = TEMP_PATH."Wechat/Material/".$timeRand.$media['name'];
			$moveResult     = File::copyFile( $media['tmp_name'], $targetPathName );
			if( $moveResult !== true ){
				$this->send( Code::error, [], '创建文件失败' );
			} else{
				$result = $this->wechat->material->uploadVideo( $targetPathName, $data['title'], $data['description'] );
				if( !$result || isset($result['errcode'])){
					$this->send( Code::error, [], $result );
				} else{
					File::deleteFile( $targetPathName );
					File::deleteFile( $media['tmp_name'] );
					$this->send( Code::success,$result );
				}
			}
		}
	}

	/**
	 * todo 64KB，支持JPG格式
	 * 上传缩略图
	 * 用于视频封面或者音乐封面
	 * @method POST
	 * @param file $media
	 * @author 韩文博
	 */
	public function materialUploadThumb( )
	{
		if( $this->validate( $this->request->file(), 'Admin/Wechat/Material.uploadThumb' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$media          = $this->request->file( 'media' );
			$timeRand       = time().rand( 100, 999 );
			File::createDir(TEMP_PATH."Wechat/Material");
			$targetPathName = TEMP_PATH."Wechat/Material/".$timeRand.$media['name'];
			$moveResult     = File::copyFile( $media['tmp_name'], $targetPathName );
			if( $moveResult !== true ){
				$this->send( Code::error, [], '创建文件失败' );
			} else{
				$result = $this->wechat->material->uploadImage( $targetPathName );
				if( !$result || isset($result['errcode'])){
					$this->send( Code::error, [], $result );
				} else{
					File::deleteFile( $targetPathName );
					File::deleteFile( $media['tmp_name'] );
					$this->send( Code::success,$result );
				}
			}
		}
	}

	/**
	 * 微信永久素材图文消息创建
	 * @method POST
	 * @param array $media 多组图文
	 * @author 韩文博
	 */
	public function materialUploadArticle()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Material.uploadArticle' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->material->uploadArticle( $this->post['media'] );
			if( !$result || isset($result['errcode'])){
				$this->send( Code::error, [], $result );
			} else{
				$this->send( Code::success ,$result);
			}
		}
	}

	/**
	 * 微信永久素材图文消息修改
	 * @method POST
	 * @param string $media_id 要更新的文章的 mediaId
	 * @param array  $article  文章内容
	 * @param int    $index    要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义，单图片忽略此参数），第一篇为 0；
	 * @author 韩文博
	 */
	public function materialUpdateArticle()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Material.updateArticle' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->material->updateArticle( $this->post['media_id'] ,$this->post['article'],isset($this->post['index']) ? (int) $this->post['index'] : 0);
			if( !$result || isset($result['errcode'])){
				$this->send( Code::error, [], $result );
			} else{
				$this->send( Code::success ,$result);
			}
		}
	}

	/**
	 * todo 1MB以下，支持bmp/png/jpeg/jpg/gif格式
	 * 上传图片
	 * @method POST
	 * @param file $media
	 * @author 韩文博
	 */
	public function materialUploadArticleImage()
	{
		if( $this->validate( $this->request->file(), 'Admin/Wechat/Material.uploadArticleImage' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$media          = $this->request->file( 'media' );
			$timeRand       = time().rand( 100, 999 );
			File::createDir(TEMP_PATH."Wechat/Material");
			$targetPathName = TEMP_PATH."Wechat/Material/".$timeRand.$media['name'];
			$moveResult     = File::copyFile( $media['tmp_name'], $targetPathName );
			if( $moveResult !== true ){
				$this->send( Code::error, [], '创建文件失败' );
			} else{
				$result = $this->wechat->material->uploadImage( $targetPathName );
				if( !$result || isset($result['errcode'])){
					$this->send( Code::error, [], $result );
				} else{
					File::deleteFile( $targetPathName );
					File::deleteFile( $media['tmp_name'] );
					$this->send( Code::success,$result );
				}
			}
		}
	}

	/**
	 * 微信永久素材获取单条
	 * @method GET
	 * @param string $media_id 素材id
	 * @author 韩文博
	 */
	public function materialGet()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/Material.get' ) !== true ){
			 $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$info = $this->wechat->material->get( $this->get['media_id'] );
			 $this->send( Code::success, $info );
		}
	}

	/**
	 * 获取永久素材
	 * @param string $type
	 * @param int    $offset
	 * @param int    $count
	 * @method GET
	 * @author 韩文博
	 */
	public function materialList()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/Material.list' ) !== true ){
			 $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$list = $this->wechat->material->list( $this->get['type'], $this->get['offset'], $this->get['count'] );
			 $this->send( Code::success, $list );
		}
	}

	/**
	 * 获取素材计数
	 * @method GET
	 * @author 韩文博
	 */
	public function materialStats()
	{
		$stats = $this->wechat->material->stats();
		return $this->send( Code::success, $stats );
	}

	/**
	 * 删除永久素材
	 * @method POST
	 * @param string $media_id 素材id
	 * @author 韩文博
	 */
	public function materialDelete()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/Material.delete' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$this->wechat->material->delete( $this->post['media_id'] );
			return $this->send( Code::success );
		}
	}

	/**
	 * 本地图文添加
	 * @method POST
	 * @param array $media
	 * @author 韩文博
	 */
	public function localNewsAdd()
	{
		$this->post['type'] = 'news';
		if( $this->validate( $this->post, 'Admin/Wechat/LocalMaterial.add' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$mediaData = [];
			foreach( $this->post['media'] as $key => $item ){
				$mediaData[$key]['title'] = $item['title'];
				if( isset( $item['cover_pic'] ) ){
					$mediaData[$key]['cover_pic'] = $item['cover_pic'];
				}
				$mediaData[$key]['link']['action'] = $item['link']['action'];
				$mediaData[$key]['link']['param']  = $item['link']['param'] ? $item['link']['param'] : [];
			}
			model( 'Material' )->addMaterial( [
				'type'  => 'news',
				'media' => $mediaData,
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 本地图文修改
	 * @method POST
	 * @param int   $id
	 * @param array $media
	 * @author 韩文博
	 */
	public function localNewsEdit()
	{
		$this->post['type'] = 'news';
		if( $this->validate( $this->post, 'Admin/Wechat/LocalMaterial.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$mediaData = [];
			foreach( $this->post['media'] as $key => $item ){
				$mediaData[$key]['title'] = $item['title'];
				if( isset( $item['cover_pic'] ) ){
					$mediaData[$key]['cover_pic'] = $item['cover_pic'];
				}
				$mediaData[$key]['link']['action'] = $item['link']['action'];
				$mediaData[$key]['link']['param']  = $item['link']['param'] ? $item['link']['param'] : [];
			}
			model( 'Material' )->editMaterial( ['id' => $this->post['id']], [
				'type'  => 'news',
				'media' => $mediaData,
			] );
			$this->send( Code::success );
		}
	}

	/**
	 * 本地图文删除
	 * @method POST
	 * @author 韩文博
	 */
	public function localNewsDel()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/LocalMaterial.del' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Material' )->delMaterial( ['id' => $this->post['id'], 'type' => 'news'] );
			$this->send( Code::success );
		}
	}

	/**
	 * 本地图文列表
	 * @method GET
	 * @param int $page
	 * @param int $rows
	 * @author 韩文博
	 */
	public function localNews()
	{
		$condition['type'] = 'news';
		$model             = model( 'Material' );
		$total_number      = $model->where( $condition )->count();
		$list              = $model->getMaterialList( $condition, '*', 'create_time desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $total_number,
			'list'         => $list,
		] );
	}

	/**
	 * 本地图文详情
	 * @method GET
	 * @param int $id
	 * @author 韩文博
	 */
	public function localNewsInfo()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/LocalMaterial.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$condition['type'] = 'news';
			$condition['id']   = $this->get['id'];
			$model             = model( 'Material' );
			$info              = $model->getMaterialInfo( $condition, '*');
			$this->send( Code::success, [
				'info' => $info,
			] );
		}
	}


	/**
	 * 获取所有用户标签
	 * @method GET
	 * @author 邓凯
	 */
	public function userTagList()
	{
		$list = $this->wechat->userTag->list();
		$this->send( Code::success, $list );
	}


	/**
	 * 创建标签
	 * @method POST
	 * @param string $name 标签名字
	 * @author 邓凯
	 */
	public function userTagCreate()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.create' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->create( $this->post['name'] );
			$this->send( Code::success, $result );
		}
	}


	/**
	 * 修改标签信息
	 * @method POST
	 * @param int    $tagId 标签id
	 * @param string $name  标签名
	 * @author 邓凯
	 */
	public function userTagUpdate()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.edit' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->update( $this->post['id'], $this->post['name'] );
			$this->send( Code::success, $result );
		}
	}


	/**
	 * 删除标签
	 * @method POST
	 * @param int    $tagId 标签id
	 * @param string $name  标签名
	 * @author 邓凯
	 */
	public function userTagDelete()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.delete' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->delete( $this->post['id'] );
			$this->send( Code::success, $result );
		}
	}


	/**
	 * 获取指定 openid 用户所属的标签
	 * @method POST
	 * @param string $openid 用户openid
	 * @author 邓凯
	 */
	public function userTagsByOpenid()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.userTagsByOpenid' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->userTags( $this->post['openid'] );
			if( $result ){
				$wechatUserLogic = new \App\Logic\WechatUser( ['wechat' => $this->wechat] );
				$wechatUserLogic->updateWechatUsersInfo( [$this->post['openid']] );
			}
			$this->send( Code::success, $result );
		}
	}

	/**
	 * 获取标签下用户列表
	 * @method GET
	 * @param int    $id          标签id
	 * @param string $next_openid 从openid开始拉取，不填默认从开头拉取
	 * @author 邓凯
	 */
	public function userTagUsersOfTag()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/UserTag.userTagUsersOfTag' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			if( isset( $this->get['next_openid'] ) ){
				$list = $this->wechat->userTag->usersOfTag( $this->get['id'], $this->get['next_openid'] );
			} else{
				$list = $this->wechat->userTag->usersOfTag( $this->get['id'] );
			}
			$this->send( Code::success, $list );
		}
	}


	/**
	 * 批量为用户添加标签
	 * @method POST
	 * @param int   $id      标签id
	 * @param array $openids 用户openid数组
	 * @author 韩文博
	 */
	public function userTagTagUsers()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.userTagTagUsers' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->tagUsers( $this->post['openids'], $this->post['id'] );
			if( $result ){
				$wechatUserLogic = new \App\Logic\WechatUser( ['wechat' => $this->wechat] );
				$wechatUserLogic->updateWechatUsersInfo( $this->post['openids'] );
			}
			$this->send( Code::success, $result );
		}
	}

	/**
	 * 批量为用户移除标签
	 * @method POST
	 * @param int   $id      标签id
	 * @param array $openids 用户openid数组
	 * @author 邓凯
	 */
	public function userTagUntagUsers()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/UserTag.userTagTagUsers' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$result = $this->wechat->userTag->untagUsers( $this->post['openids'], $this->post['id'] );
			if( $result ){
				$wechatUserLogic = new \App\Logic\WechatUser( ['wechat' => $this->wechat] );
				$wechatUserLogic->updateWechatUsersInfo( $this->post['openids'] );
			}
			$this->send( Code::success, $result );
		}
	}

	/**
	 * @method GET
	 * @param string $name
	 * @param string $description
	 * @param string $account
	 * @param string $original
	 * @param int    $level
	 * @param string $app_key
	 * @param string $app_secret
	 * @param string $headimg
	 * @param string $qrcode
	 * @author 韩文博
	 */
	public function confSet()
	{
		if( $this->validate( $this->post, 'Admin/Wechat.confSet' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$data = [];
			if( isset( $this->post['name'] ) ){
				$data['name'] = $this->post['name'];
			}
			if( isset( $this->post['description'] ) ){
				$data['description'] = $this->post['description'];
			}
			if( isset( $this->post['account'] ) ){
				$data['account'] = $this->post['account'];
			}
			if( isset( $this->post['original'] ) ){
				$data['original'] = $this->post['original'];
			}
			if( isset( $this->post['level'] ) ){
				$data['level'] = $this->post['level'];
			}
			if( isset( $this->post['headimg'] ) ){
				$data['headimg'] = $this->post['headimg'];
			}
			if( isset( $this->post['qrcode'] ) ){
				$data['qrcode'] = $this->post['qrcode'];
			}
			if( isset( $this->post['app_id'] ) ){
				$data['app_id'] = $this->post['app_id'];
			}
			if( isset( $this->post['app_secret'] ) ){
				$data['app_secret'] = $this->post['app_secret'];
			}
			model( 'Wechat' )->editWechat( [
				'id' => 1,
			], $data );
			$this->send( Code::success );
		}
	}

	/**
	 * 绑定信息获取
	 * @method GET
	 * @author 韩文博
	 */
	public function getConf()
	{
		$info = model( 'Wechat' )->getWechatInfo( ['id' => 1], 'name,description,account,original,level,app_id,mch_id,app_key,app_secret,headimg,qrcode' );
		$this->send( Code::success, $info );
	}

	/**
	 * 查看接口状态
	 * @method GET
	 * @author 韩文博
	 */
	public function checkApiStatus()
	{
		try{
			$this->wechat->menu->current();
			$this->send( Code::success );
		} catch( \Exception $e ){
			$this->send( Code::wechat_api_error, [], $e->getMessage() );
		}
	}

	/**
	 * 被关注自动回复
	 * @method POST
	 * @param array $reply_ceontent
	 * @author 韩文博
	 */
	public function autoReplySubscribeSet()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/AutoReplySubscribe.set' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$data['auto_reply_subscribe_replay_content'] = $this->post['reply_content'];
			model( 'Wechat' )->editWechat( ['id' => 1], $data );
			$this->send( Code::success );
		}
	}

	/**
	 * 被关注回复设置获得
	 * @method POST
	 * @param array $reply_ceontent
	 * @author 韩文博
	 */
	public function autoReplySubscribeGet()
	{
		$info = model( 'Wechat' )->getWechatInfo( ['id' => 1], 'auto_reply_subscribe_replay_content' );
		$this->send( Code::success, ['reply_ceontent' => $info['auto_reply_subscribe_replay_content']] );
	}

	/**
	 * 自动回复开关获取
	 * @method GET
	 * @author 韩文博
	 */
	public function autoReplyStatusGet()
	{
		$info = model( 'Wechat' )->getWechatInfo( ['id' => 1], 'auto_reply_status as status' );
		$this->send( Code::success, $info );
	}

	/**
	 * 自动回复开关设置
	 * @method POST
	 * @param int status
	 * @author 韩文博
	 */
	public function autoReplyStatusSet()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/AutoReplyStatus.set' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			model( 'Wechat' )->editWechat( ['id' => 1], ['auto_reply_status' => $this->post['status'] ? 1 : 0] );
			$this->send( Code::success );
		}
	}

	/**
	 * 关键词规则列表
	 * @method GET
	 * @param string $keywords 搜索关键词/规则名称
	 * @author 韩文博
	 */
	public function replyKeywordsList()
	{
		$condition = [];
		if( isset( $this->get['keywords'] ) ){
			$condition['rule_name|keys'] = ['like', '%'.$this->get['keywords'].'%'];
		}
		$model        = model( 'WechatAutoReply' );
		$total_number = $model->where( $condition )->count();
		$list         = $model->getWechatAutoReplyList( $condition, '*', 'create_time desc', $this->getPageLimit() );
		$this->send( Code::success, [
			'total_number' => $total_number,
			'list'         => $list,
		] );
	}

	/**
	 * 关键词规则添加
	 * @method POST
	 * @param string $rule_name
	 * @param string $reply_mode
	 * @param array  $reply_content
	 * @param array  $keywords key最多10个,回复内容最多5条
	 * @author 韩文博
	 */
	public function autoReplyKeywordsAdd()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/AutoReplyKeywords.add' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			foreach( $this->post['keywords'] as $item ){
				$keys[] = $item['key'];
			}

			$autoReplyData = [
				'rule_name'     => $this->post['rule_name'],
				'reply_mode'    => $this->post['reply_mode'],
				'reply_content' => $this->post['reply_content'],
				'keys'          => $keys,
			];

			$autoReplyModel = model( 'WechatAutoReply' );

			$autoReplyModel->startTrans();

			$auto_reply_id = $autoReplyModel->addWechatAutoReply( $autoReplyData );

			if( $auto_reply_id ){
				try{
					$autoReplyKeywordsModel = model( 'WechatAutoReplyKeywords' );
					foreach( $this->post['keywords'] as $item ){
						$data[] = [
							'auto_reply_id' => $auto_reply_id,
							'key'           => $item['key'],
							'match_mode'    => $item['match_mode'],
						];
					}
					$state = $autoReplyKeywordsModel->addWechatAutoReplyKeywordsAll( $data );
					if( $state ){
						$autoReplyModel->commit();
						$this->send( Code::success );
					} else{
						$autoReplyModel->rollback();
						$this->send( Code::error, [], '创建失败' );
					}
				} catch( \Exception $e ){
					$autoReplyModel->rollback();
					$this->send( Code::error, [], $e->getMessage() );
				}

			} else{
				$autoReplyModel->rollback();
				$this->send( Code::error, [], '创建失败' );
			}

		}
	}

	/**
	 * 关键词规则修改
	 * @method POST
	 * @param int    $id
	 * @param string $rule_name
	 * @param string $reply_mode
	 * @param array  $reply_content
	 * @param array  $keywords key最多10个,回复内容最多5条
	 * @author 韩文博
	 */
	public function autoReplyKeywordsEdit()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/AutoReplyKeywords.edit' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{

			foreach( $this->post['keywords'] as $item ){
				$keys[] = $item['key'];
			}

			$autoReplyData = [
				'rule_name'     => $this->post['rule_name'],
				'reply_mode'    => $this->post['reply_mode'],
				'reply_content' => $this->post['reply_content'],
				'keys'          => $keys,
			];

			$autoReplyModel = model( 'WechatAutoReply' );

			$autoReplyModel->startTrans();

			$state = $autoReplyModel->editWechatAutoReply( ['id' => $this->post['id']], $autoReplyData );

			if( $state ){

				$auto_reply_id = $this->post['id'];

				try{
					$autoReplyKeywordsModel = model( 'WechatAutoReplyKeywords' );

					$autoReplyKeywordsModel->delWechatAutoReplyKeywords( ['auto_reply_id' => $auto_reply_id] );

					foreach( $this->post['keywords'] as $item ){
						$data[] = [
							'auto_reply_id' => $auto_reply_id,
							'key'           => $item['key'],
							'match_mode'    => $item['match_mode'],
						];
					}
					$state = $autoReplyKeywordsModel->addWechatAutoReplyKeywordsAll( $data );
					if( $state ){
						$autoReplyModel->commit();
						$this->send( Code::success );
					} else{
						$autoReplyModel->rollback();
						$this->send( Code::error, [], '修改关键词失败' );
					}
				} catch( \Exception $e ){
					$autoReplyModel->rollback();
					$this->send( Code::error, [], $e->getMessage() );
				}
			} else{
				$autoReplyModel->rollback();
				$this->send( Code::error, [], '修改规则失败' );
			}
		}
	}

	/**
	 * 关键词规则删除
	 * @method POST
	 * @param int $id
	 * @author 韩文博
	 */
	public function autoReplyKeywordsDel()
	{
		if( $this->validate( $this->post, 'Admin/Wechat/AutoReplyKeywords.del' ) !== true ){
			return $this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{

			$autoReplyModel = model( 'WechatAutoReply' );

			$autoReplyModel->startTrans();

			$state = $autoReplyModel->delWechatAutoReply( ['id' => $this->post['id']] );

			if( $state ){

				$auto_reply_id = $this->post['id'];

				try{
					$autoReplyKeywordsModel = model( 'WechatAutoReplyKeywords' );

					$autoReplyKeywordsModel->delWechatAutoReplyKeywords( ['auto_reply_id' => $auto_reply_id] );

					$autoReplyModel->commit();
					$this->send( Code::success );
				} catch( \Exception $e ){
					$autoReplyModel->rollback();
					$this->send( Code::error, [], $e->getMessage() );
				}

			} else{
				$autoReplyModel->rollback();
				$this->send( Code::error, [], '修改规则失败' );
			}
		}
	}

	/**
	 * 关键词规则详情
	 * @method GET
	 * @param int $id
	 * @author 韩文博
	 */
	public function autoReplyKeywordsInfo()
	{
		if( $this->validate( $this->get, 'Admin/Wechat/AutoReplyKeywords.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{

			$autoReplyModel = model( 'WechatAutoReply' );

			$info = $autoReplyModel->getWechatAutoReplyInfo( ['id' => $this->get['id']] );

			$autoReplyKeywordsModel = model( 'WechatAutoReplyKeywords' );

			$keywords         = $autoReplyKeywordsModel->getWechatAutoReplyKeywordsList( ['auto_reply_id' => $this->get['id']], 'key,match_mode', 'auto_reply_id desc', '1,10' );
			$info['keywords'] = $keywords;

			$this->send( Code::success, ['info' => $info] );

		}
	}


}