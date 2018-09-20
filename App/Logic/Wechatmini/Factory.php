<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/1
 * Time: 下午4:51
 *
 */

namespace App\Logic\Wechatmini;

use EasyWeChat\Factory as EasyWeChatFactory;

/**
 * Class Factory
 */
class Factory
{

	protected $app;

	public function __construct()
	{
		$config    = \EasySwoole\Config::getInstance()->getConf( 'wechatmini' );
		$this->app = EasyWeChatFactory::miniProgram($config);

	}

	public function getApp(){
		return $this->app;
	}

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Exception
	 * @author 韩文博
	 */
	public function checkUser( array $data )
	{
		$result = null;

		try{
            $mini_result = $this->app->auth->session(strval($data['code']));
            if(array_key_exists('session_key',$mini_result)){
                //微信小程序消息解密 比如获取电话等功能，信息是加密的，需要解密。
                $decryptedData = $this->app->encryptor->decryptData($mini_result['session_key'], $data['iv'], $data['encryptedData']); //array
                $result = $decryptedData;
            }else{
                $result = $mini_result['errmsg'];
            }

        } catch( \Exception $e ){
            return $e->getMessage();
        }

	    return $result;
	}


}