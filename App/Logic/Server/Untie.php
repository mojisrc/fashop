<?php
/**
 * 解绑业务逻辑处理
 * 没有做邮箱的相关处理 目前只把phone当做主
 *
 *
 *
 *
 * @copyright  Copyright (c) 2016-2017 WenShuaiKeJi Inc. (http://www.fashop.cn)
 * @license    http://www.fashop.cn
 * @link       http://www.fashop.cn
 * @since      File available since Release v1.1
 */
namespace App\Logic\Server;

use App\Logic\User as UserLogic;
use ezswoole\Validate;
use ezswoole\Db;
use App\Utils\Code;
use App\Utils\Exception;
use ezswoole\utils\RandomKey;

class Untie
{
    /**
     * @var string
     */
    private $phone;
    /**
     * @var string
     */
    private $password;
    /**
     * @var string
     */
    private $wechatOpenid;
    /**
     * @var array
     */
    private $options;
    /**
     * @var int
     */
    private $userId;


    /**
     * @return string
     */
    public function getPhone() : string
    {
        return $this->phone;
    }

    /**
     * @param string $username
     */
    public function setPhone( string $phone ) : void
    {
        $this->phone = phone;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword( string $password ) : void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getWechatOpenid() : string
    {
        return $this->wechatOpenid;
    }

    /**
     * @param string $wechatOpenid
     */
    public function setWechatOpenid( string $wechatOpenid ) : void
    {
        $this->wechatOpenid = $wechatOpenid;
    }

    /**
     * @return array
     */
    public function getOptions() : array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions( array $options ) : void
    {
        $this->options = $options;
    }

    public function __construct( array $options )
    {
        $this->setOptions( $options );
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $Type
     */
    public function setType( string $type ) : void
    {
        $this->type = $type;
    }
    /**
     * @return string
     */
    public function getUserId() : string
    {
        return $this->userId;
    }

    /**
     * @param string $userId
     */
    public function setUserId( string $userId ) : void
    {
        $this->userId = $userId;
    }


    /**
     * 解绑
     * @method GET
     * @return array|null
     * @throws \App\Utils\Exception
     * @author 韩文博
     */
    public function untie() : ? array
    {
        $this->setType( $this->options['type'] );

        if( isset( $this->options['wechat'] ) ){
            return $this->wechat();

        } elseif( isset( $this->options['phone'] ) ){
            return $this->phone();

        } else{
            throw new \App\Utils\Exception( Code::param_error );
        }

    }

    /**
     * @return mixed
     * @throws \App\Utils\Exception
     * @author 韩文博
     */
    private function phone()
    {
        try{
            $this->setUserId( $this->options['id'] );
            $user_id          = $this->getUserId();

            $user_model       = model('User');
            $user_open_model  = model('UserOpen');

            $open_list       = $user_open_model->getUserOpenList(['user_id'=>$user_id,'state'=>1], '', '*', 'id desc', '', '');
            if(!$open_list){
                throw new \App\Utils\Exception( "param error", Code::param_error );
            }

            $user_phone       = $user_model->getUserValue(['id' => $user_id], 'phone');
            if(!$user_phone){
                throw new \App\Utils\Exception( "param error", Code::param_error );
            }

            $open_batch_updata = [];

            foreach ($open_list as $key => $value) {
                $open_batch_updata['id']         = $value['id'];
                $open_batch_updata['state']      = 0;
            }

            $user_result = $user_open_model->editUser(['id'=>$user_id], ['phone'=>null] );
            if(!$user_result ){
                $user_model->rollback();
                return null;
            }

            //第三方被更改
            $open_batch_result = $user_open_model->updateAllUserOpen($open_batch_updata);
            if(!$open_batch_result ){
                $user_model->rollback();
                return null;
            }

            return $user_id;

        } catch( \Exception $e ){
            throw new $e;
        }
    }

    /**
     * @throws \App\Utils\Exception
     * @author 韩文博
     */
    private function wechat()
    {

        try{
            $this->setUserId( $this->options['id'] );
            $user_id          = $this->getUserId();

            $user_model       = model('User');
            $user_open_model  = model('UserOpen');

            $open_info        = $user_open_model->getUserOpenInfo(['user_id'=>$user_id,'genre'=>1], '', '*');
            if(!$open_info){
                throw new \App\Utils\Exception( "param error", Code::param_error );
            }

            $user_phone       = $user_model->getUserValue(['id' => $user_id], 'phone');
            $other_open_info  = $user_open_model->getUserOpenInfo(['user_id' => $user_id, 'id' => ['neq', $open_info['id']]], '', '*');
            if(!$user_phone && !$other_open_info){
                throw new \App\Utils\Exception( "param error", Code::param_error );
            }

            //占位行被恢复
            $user_result = $user_model->editUser(['id'=>$open_info['origin_user_id']], ['state'=>1,'is_discard'=>0] );
            if(!$user_result ){
                $user_model->rollback();
                return null;
            }
            //第三方被更改
            $user_open_result  = $user_open_model->updateUserOpen(['id'=>$open_info['id']], ['user_id'=>$open_info['origin_user_id'],'state'=>0]);
            if(!$user_open_result ){
                $user_model->rollback();
                return null;
            }

            return $user_id;

        } catch( \Exception $e ){
            throw new $e;
        }
    }

}

?>
