<?php
/**
 * 店铺
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class Shop extends Server
{
	public function info()
	{
		$field = 'name,logo,contact_number,description,color_scheme,portal_template_id,wechat_platform_qr,goods_category_style,host,order_auto_close_expires,order_auto_confirm_expires,order_auto_close_refound_expires';
		$info  = model( 'Shop' )->getShopInfo( ['id' => 1], $field );
		$this->send( Code::success, ['info' => $info] );
	}
}
