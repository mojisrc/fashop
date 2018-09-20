<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:37
 *
 */

namespace App\Logic\Wechat\Support;
use App\Logic\Wechat\AbstractInterface\BaseAbstract;

class Qrcode extends BaseAbstract
{


	/**
	 * 临时二维码创建
	 * 是有过期时间的，最长可以设置为在二维码生成后的 30天后过期，但能够生成较多数量。临时二维码主要用于帐号绑定等不要求二维码永久保存的业务场景
	 * @method GET
	 * @param  $
	 * @author 韩文博
	 */
	public function temporary()
	{
		$result = $this->app->qrcode->temporary( 'foo', 6 * 24 * 3600 );
		// Array
		// (
		//     [ticket] => gQFD8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyTmFjVTRWU3ViUE8xR1N4ajFwMWsAAgS2uItZAwQA6QcA
		//     [expire_seconds] => 518400
		//     [url] => http://weixin.qq.com/q/02NacU4VSubPO1GSxj1p1k
		// )
	}

	/**
	 * 永久二维码，是无过期时间的，但数量较少（目前为最多10万个）。永久二维码主要用于适用于帐号绑定、用户来源统计等场景。
	 * @method GET
	 * @author 韩文博
	 */
	public function forever()
	{
		$this->app->qrcode->forever( "foo" );
		// Array
		// (
		//     [ticket] => gQFD8TwAAAAAAAAAAS5odHRwOi8vd2VpeGluLnFxLmNvbS9xLzAyTmFjVTRWU3ViUE8xR1N4ajFwMWsAAgS2uItZAwQA6QcA
		//     [url] => http://weixin.qq.com/q/02NacU4VSubPO1GSxj1p1k
		// )
	}

	/**
	 * @method GET
	 * @param string $ticket
	 * @author 韩文博
	 */
	public function url()
	{
		$this->app->qrcode->url( $this->get['ticket'] );

	}


}