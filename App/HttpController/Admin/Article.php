<?php
/**
 * 文章管理
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 MoJiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */

namespace App\HttpController\Admin;
use App\Utils\Code;
class Article extends Admin
{
	/**
	 * 文章列表
	 * @method GET
	 */
	public function list()
	{
		$condition = [];
		$list = model( 'Article' )->getArticleList( $condition, '*', 'id asc', '1,1000000' );
		$this->send( Code::success, [
			'list'         => $list,
			'total_number' => 100,
		] );
	}
}

?>