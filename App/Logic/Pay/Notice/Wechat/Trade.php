<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/6
 * Time: 下午8:40
 *
 */

namespace App\Logic\Pay\Notice\Wechat;

use Yansongda\Pay\Log;

class Trade extends Notice
{
	final public function __construct( array $config )
	{
		parent::__construct( $config );
	}

	final public function check() : bool
	{
		try{
			$content = request()->getEsRequest()->getSwooleRequest()->rawContent();
			trace(['raw_content'=>$content],'debug');
			$data = $this->pay->verify($content);
			trace( 'verify---------------','debug' );
			trace( $data,'debug' );

			$this->setData( $data );
			trace( "wechat check data trade_status SUCCESS" );
			if( $this->data->result_code === 'SUCCESS' ){
				return true;
			} else{
				trace( "wechat check data trade_status fail" );
				return false;
			}
		} catch( \Exception $e ){
			trace( $e->getMessage(), 'debug' );
			return false;
		}

	}

	/**
	 * @method GET
	 * @return array|null
	 * @author 韩文博
	 */
	final public function handle() : bool
	{
		if( $this->check() === true ){
			return true;
//			return (array)$this->data;
		} else{
			// 从外面可以用$this-><
			Log::debug( 'Wechat notify', $this->data->all() );
			trace( "验证 失败", 'debug' );
			return false;
		}
	}
}

