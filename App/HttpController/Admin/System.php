<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/2
 * Time: 下午12:48
 *
 */

namespace App\HttpController\Admin;

use App\Utils\Code;
use EasySwoole\Core\Component\Di;
use EasySwoole\Core\Component\SysConst;
use EasySwoole\Config;
use ezswoole\Log;

class System extends Admin
{
	/**
	 * 系统信息
	 * @method GET
	 * @author 韩文博
	 */
	public function info()
	{
		// 服务器操作系统
		$info['os'] = PHP_OS;
		// 文件上传限制
		$info['upload_max_filesize'] = ini_get( 'upload_max_filesize' );
		// 最大post
		$info['post_max_size'] = ini_get( 'post_max_size' );
		// 以秒为单位对通过POST/GET/PUT方式接受数据时间进行限制
		$info['max_input_time'] = ini_get( 'max_input_time' );
		// PHP允许定义内存使用限额
		$info['memory_limit'] = ini_get( 'memory_limit' );
		// 服务器域名／IP
		$info['domain'] = $this->request->domain();
		$info['ip']     = $this->request->ip();
		// PHP版本
		$info['php_version'] = PHP_VERSION;
		// ZEND 版本
		$info['zend_version'] = zend_version();
		// MYsql版本
		$mysql                 = db()->query( "SELECT VERSION() as mysql_version" );
		$info['mysql_version'] = $mysql[0]['mysql_version'];
		// 获得服务器系统时间
		$info['datetime'] = date( 'Y-m-d H:i:s' );
		// swoole 版本
		$info['swoole_version'] = SWOOLE_VERSION;
		// easyswoole 版本
		$info['easyswoole_version'] = Di::getInstance()->get( SysConst::VERSION );
		// 当前端口
		$info['port'] = Config::getInstance()->getConf( 'MAIN_SERVER.PORT' );
		// FaShop版本
		$info['version'] = FASHOP_VERSION;
		$this->send( Code::success, $info );
	}

	public function runCron()
	{
		\App\Cron\WechatUser::addUser();
		$this->send( Code::success );
	}

	/**
	 * 最新版本
	 * @method GET
	 * @author 韩文博
	 */
	public function lastVersion()
	{
		$system   = db( 'System' )->field( "version,app_key,app_secret" )->find();
		$provider = new \League\OAuth2\Client\Provider\GenericProvider( [
			'clientId'                => $system['app_key'],
			'clientSecret'            => $system['app_secret'],
			'urlAuthorize'            => 'https://api.fashop.cn/site/oauth/authorize',
			'urlAccessToken'          => 'https://api.fashop.cn/site/oauth/token',
			'urlResourceOwnerDetails' => 'https://api.fashop.cn/site/oauth/owner',
		] );
		try{
			$accessToken = $provider->getAccessToken( 'client_credentials' );
			$curl        = new \ezswoole\Curl();
			$response    = $curl->request( 'GET', 'https://api.fashop.cn/site/version/last', [
				'Access-Token' => $accessToken,
			] );
			$result      = json_decode( $response->getBody() );
			$this->send( Code::success, ['version' => $result['result']['version']] );
		} catch( \League\OAuth2\Client\Provider\Exception\IdentityProviderException $e ){
			Log::write( $e->getMessage() );
			$this->send( COde::server_error, [], $e->getMessage() );
		}
	}

	/**
	 * 下载更新包
	 * @method GET
	 * @author 韩文博
	 * @throws
	 */
	public function update()
	{
		$system   = db( 'System' )->field( "version,app_key,app_secret" )->find();
		$provider = new \League\OAuth2\Client\Provider\GenericProvider( [
			'clientId'                => $system['app_key'],
			'clientSecret'            => $system['app_secret'],
			'urlAuthorize'            => 'https://api.fashop.cn/site/oauth/authorize',
			'urlAccessToken'          => 'https://api.fashop.cn/site/oauth/token',
			'urlResourceOwnerDetails' => 'https://api.fashop.cn/site/oauth/owner',
		] );
		try{
			$accessToken = $provider->getAccessToken( 'client_credentials' );
			$curl        = new \ezswoole\Curl();
			// 判断版本是否需要更新
			$response = $curl->request( 'GET', 'https://api.fashop.cn/site/version/last', [
				'Access-Token' => $accessToken,
			] );
			$result   = json_decode( $response->getBody() );
			$version  = $result['result']['version'];
			if( version_compare( $system['version'], $version, "<" ) ){
				$response       = $curl->request( 'GET', 'https://api.fashop.cn/site/version/download', [
					'Access-Token' => $accessToken,
				] );
				$result         = json_decode( $response->getBody() );
				$header         = $curl->praseHeaderLine( $response->getHeaderLine() );
				$filename       = ROOT_PATH."App/Update/".$header['Content-Disposition']['filename'];
				$download_state = file_put_contents( $filename, $result );
				if( $download_state ){
					// 解压并覆盖
					$zip = new \ZipArchive;
					$res = $zip->open( $filename );
					if( $res === true ){
						// 解压缩到指定文件夹
						$extract_state = $zip->extractTo( ROOT_PATH."App/Update/Test" );
						$zip->close();
						// 覆盖成功，通知更新
						if( $extract_state === true ){
							$update_version_state = db( 'System' )->where( ['name' => 'version'] )->update( ['value' => $version] );
							if( $update_version_state ){
								// 查看是否有需要升级的数据库
								$db_update_class_name = "App/Update/Db/Update".str_replace( ".", "_", $version );
								$db_update_file_exist = file_exists( ROOT_PATH."{$db_update_class_name}.php" );
								if( $db_update_file_exist === true ){
									// 更新数据库
									$db_update_class = new $db_update_class_name();
									if( $db_update_class instanceof \App\Update\Db\UpdateAbstract ){
										$db_update_result = $db_update_class->run();
										if( $db_update_result === true ){
											$db_query_result = db( 'System' )->where( ['name' => 'db_version'] )->update( ['value' => $version] );
											if( !$db_query_result ){
												Log::write( "after {$db_update_class_name}->run update system db_version fail" );
												return $this->send( Code::update_db_version_fail );
											}
										} else{
											Log::write( "{$db_update_class_name}->run更新数据库失败" );
											return $this->send( Code::update_db_version_fail );
										}
									} else{
										Log::write( "Db Update Class must instanceof \App\Update\DB\UpdateAbstract" );
										return $this->send( Code::server_error, [], "Db Update Class must instanceof \App\Update\DB\UpdateAbstract" );
									}
								}

								$update_behavior = new \App\Update\Behavior();
								$update_behavior->onFilesCoverComplete();

								// 通知插件进行更新
								$plugin_names = $this->getPluginNames();
								if( !empty( $plugin_names ) ){
									foreach( $plugin_names as $pluginname ){
										try{
											$plugin_class_name = "\Plugin\{$pluginname}\Update";
											$pluginUpdateClass = new $plugin_class_name();
											if( $pluginUpdateClass instanceof \App\Plugin\AbstractInterface\BehaviorAbstract ){
												$state = $pluginUpdateClass->onFilesCoverComplete( $system['version'], $version );
												if( $state !== true ){
													Log::write( "{$plugin_class_name}->onFilesCoverComplete fail" );
												} else{
													Log::write( "{$plugin_class_name}->onFilesCoverComplete success" );
												}
											} else{
												Log::write( "{$plugin_class_name} must instanceof \App\Plugin\AbstractInterface\UpdateAbstract" );
											}
										} catch( \Exception $e ){
											Log::write( $e->getMessage() );
										}
									}
								}
							} else{
								Log::write( "系统版本更改失败" );
								$this->send( Code::update_version_fail );
							}
						} else{
							Log::write( "解压包覆盖失败" );
							$this->send( Code::update_extract_zip_fail );
						}
					} else{
						Log::write( "打开解压包失败" );
						$this->send( Code::update_open_zip_fail );
					}
				} else{
					Log::write( "下载升级包失败" );
					$this->send( Code::update_download_fail );
				}
				$this->send( Code::success );
			} else{
				$this->send( Code::update_no_need );
			}
		} catch( \League\OAuth2\Client\Provider\Exception\IdentityProviderException $e ){
			Log::write( $e->getMessage() );
			$this->send( COde::server_error, [], $e->getMessage() );
		}

	}

	private function getPluginNames()
	{
		$res     = [];
		$dirPath = ROOT_PATH."Plugin";
		if( is_dir( $dirPath ) ){
			try{
				$dirHandle = opendir( $dirPath );
				if( !$dirHandle ){
					return null;
				}
				while( false !== ($file = readdir( $dirHandle )) ){
					if( $file == '.' || $file == '..' ){
						continue;
					}
					if( is_dir( $dirPath."/".$file ) ){
						$res[] = $file;
					}
				}
				closedir( $dirHandle );
				return $res;
			} catch( \Exception $exception ){
				return null;
			}
		} else{
			return null;
		}
	}
}