<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/9/2
 * Time: 下午3:51
 *
 */
namespace App\Utils;
class Price
{
	/**
	 * 价格格式化
	 *
	 * @param int    $price
	 * @return string    $price_format
	 */
	function format($price) {
		$price_format = number_format($price, 2, '.', '');
		return $price_format;
	}

	/**
	 * 价格格式化
	 *
	 * @param int    $price
	 * @return string    $price_format
	 */
	function formatForList($price) {
		if ($price >= 10000) {
			return number_format(floor($price / 100) / 100, 2, '.', '') . lang('ten_thousand');
		} else {
			return lang('currency') . $price;
		}
	}
}