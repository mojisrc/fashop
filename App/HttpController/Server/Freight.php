<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/3
 * Time: 上午11:47
 *
 */

namespace App\HttpController\Server;

use App\Utils\Code;

class Freight extends Server
{
	/**
	 * 运费模板详情
	 * @method GET
	 * @param int $id
	 * @author 韩文博
	 */
	public function info()
	{
		if( $this->validate( $this->get, 'Server/Freight.info' ) !== true ){
			$this->send( Code::param_error, [], $this->getValidate()->getError() );
		} else{
			$info = model( 'Freight' )->getFreightInfo( ['id' => $this->get['id']] );
			$this->send( Code::success, ['info' => $info] );
		}
	}
}