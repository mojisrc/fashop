<?php
/**
 * 版本控制接口
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\HttpController\Server;

class Version extends Server {
	/**
	 * 获得APP最新版本
	 * @method GET
	 * @author 韩文博
	 */
	public function appLatestVersion() {

		$list =  array(
			'ios'     => '1.0',
			'android' => '1.0',
		);

		$this->send( Code::success, [
			'list' => $list,
		] );

	}

	/**
	 * todo 版本对比
	 * app是否更新
	 * @method GET
	 * @param $platform 平台enum('ios','android')
	 * @param $version 你的版本号
	 * @return array(
	 *    update_state  enum('required必须更新','optional可选','noneed不要求')
	 *    version 版本号
	 *    download_url 下载地址
	 *    publish_time 发布时间
	 *    description 版本描述
	 * )
	 * @author 韩文博
	 */
	public function appUpdate() {
		$get      = $this->get;
		$platform = strtolower($get['platform']);
		$model    = model('Version');

		$find = $model->getVersionInfo([
			'platform' => $platform,
			'version'  => $get['version'],
		]);

		if (!$find) {
			$find = array(
				"update_state" => "optional",
			);
		}

		if ($platform == 'ios') {
			$find['download_url'] = config('db_setting.ios_upgrade_url');
		} else {
			$find['download_url'] = config('db_setting.android_upgrade_url');
		}

		$this->send( Code::success, ['info' => $find] );
	}


}
