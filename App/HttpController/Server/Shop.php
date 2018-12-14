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
		$field = 'name,logo,contact_number,description,color_scheme,portal_template_id,wechat_platform_qr,goods_category_style,host,order_auto_close_expires,order_auto_confirm_expires,order_auto_close_refound_expires,top_desc,ads_img,ads_title,ads_title_sec,ads_body,ads_status';
		$info  = model( 'Shop' )->getShopInfo( ['id' => 1], $field );
		$this->send( Code::success, ['info' => $info] );
	}

	public function getNearShop()
    {
        $distance = 100000;
        $shop = null;
        $shopOrder = null;
        $qqLat = $this->post['lat'];
        $qqLng = $this->post['lng'];
        $coordinate         = new \App\Utils\Coordinate();
        $baiduCoord = $coordinate->coordinate_switchf($qqLat,$qqLng);
        $field = 'seller_address,seller_lat,seller_lng,seller_name,seller_phone,seller_area,seller_city';
        $shops = model( 'User' )->getUserList(['is_discard' => 0, 'is_seller' => ['in',[1,2]]],$field,'id desc','1,100');
        for( $i = 0 ; $i < count($shops) ; $i ++ ){
            $shopTmp = $shops[$i];
            $dis = $coordinate->getDistanceNew($baiduCoord['lat'],$baiduCoord['lng'],$shopTmp['seller_lat'],$shopTmp['seller_lng']);
            $shopLatLng = $coordinate->coordinate_switch($shopTmp['seller_lat'],$shopTmp['seller_lng']);
            if($dis < $distance){
                $distance = $dis;
                $shop = $shopTmp;
                $shop['dis'] = $distance;
                $shop['seller_lat'] = $shopLatLng['lat'];
                $shop['seller_lng'] = $shopLatLng['lng'];
            }
            $shops[$i]['dis'] = $dis;
            $shops[$i]['latitude'] = $shopLatLng['lat'];
            $shops[$i]['longitude'] = $shopLatLng['lng'];
            $shops[$i]['iconPath'] = '/themes/default/map/marker_red.png';
        }

        array_multisort(array_column($shops,'dis'),SORT_ASC,$shops);
        $this->send( Code::success, ['shop' => $shop,'shops' => $shops] );
    }


}
