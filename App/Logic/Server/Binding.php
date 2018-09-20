<?php
/**
 * 绑定业务逻辑处理
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

class Binding
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
     * @param string $type
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
     * 绑定
     * @method GET
     * @return array|null
     * @throws \App\Utils\Exception
     * @author 韩文博
     */
    public function binding() : ? array
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
            $this->setPhone( $this->options['phone'] );
            $this->setPassword( $this->options['password'] );

            $user_id          = $this->getUserId();
            $phone            = $this->getPhone();

            $user_model       = model('User');
            $user_open_model  = model('UserOpen');
            $user_alias_model = model('UserAlias');

            $user_model->startTrans();

            $phone_user_id    = $user_model->getUserValue(['phone'=>$phone], 'id');

            if($phone_user_id){
                //检查此手机号有没有绑定过其他第三方账号
                $open_id = $user_open_model->getUserOpenValue(['user_id'=>$phone_user_id], '', 'id');
                if($open_id){
                    throw new \App\Utils\Exception( "user account exist", Code::user_account_exist );
                }else{
                    //占位行被丢弃
                    $user_result = $user_model->editUser(['id'=>$user_id], ['state'=>0,'is_discard'=>1] );
                    if(!$user_result ){
                        $user_model->rollback();
                        return null;
                    }
                    //第三方被更改
                    $user_open_result  = $user_open_model->updateUserOpen(['user_id'=>$user_id], ['user_id'=>$phone_user_id,'state'=>1]);
                    if(!$user_open_result ){
                        $user_model->rollback();
                        return null;
                    }

                    //资产合并
                    $merger_result = $this->assetsMerge($user_id,$phone_user_id);
                    if(!$merger_result){
                        $user_model->rollback();
                        return null;
                    }
                    $user_id = $phone_user_id;
                }
            }else{
                $condition        = [];
                $condition['id']  = $user_id;

                $data['phone']    = $phone;
                $data['username'] = $phone;
                $data['password'] = UserLogic::encryptPassword($this->getPassword());
                $user_result      = $user_model->editUser($condition, $data );
                if(!$user_result ){
                    $user_model->rollback();
                    return null;
                }
            }

            $user_model->commit();
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
            $this->setWechatOpenid( $this->options['wechat_openid'] );
            $this->setUserId( $this->options['id'] );

            $user_id          = $this->getUserId();
            $wechat_openid    = $this->getWechatOpenid();

            $wechatApi   = new \App\Logic\Wechat\Factory();
            $wechat_user = $wechatApi->user->get( $wechat_openid );


            $user_model       = model('User');
            $user_open_model  = model('UserOpen');
            $user_alias_model = model('UserAlias');

            $user_model->startTrans();

            $user_phone       = $user_model->getUserValue(['id'=>$user_id], 'phone');
            $owner            = $user_phone ? 1 : 0;

            $open_data = $user_open_model->getUserOpenInfo(['openid'=>$wechat_openid], '', '*');
            if($open_data){

                //state 是否绑定主帐号 0否 1是
                if($open_data['state'] == 1){
                    throw new \App\Utils\Exception( "user account exist", Code::user_account_exist );
                }else{
                    $open_id = $user_open_model->getUserOpenValue(['id'=>['neq',$open_data['id']],'user_id'=>$open_data['user_id']], '', 'id');
                    if($open_id){
                        throw new \App\Utils\Exception( "user account exist", Code::user_account_exist );
                    }
                }

                //占位行被丢弃
                $user_result = $user_model->editUser(['id'=>$open_data['user_id']], ['state'=>0,'is_discard'=>1] );
                if(!$user_result ){
                    $user_model->rollback();
                    return null;
                }
                //第三方被更改
                $user_open_result  = $user_open_model->updateUserOpen(['id'=>$open_data['id']], ['user_id'=>$user_id,'state'=>$owner]);
                if(!$user_open_result ){
                    $user_model->rollback();
                    return null;
                }
                //资产合并
                $merger_result = $this->assetsMerge($open_data['user_id'],$user_id);
                if(!$merger_result){
                    $user_model->rollback();
                    return null;
                }

            }else{
                $open_data['user_id']        = $user_id;
                $open_data['genre']          = 1; //类型 1微信 2小程序 3QQ 4微博....
                $open_data['openid']         = $wechat_openid;
                $open_data['state']          = $owner; //是否绑定主帐号 默认0否 1是
                $open_data['unionid']        = isset($this->options['wechat']['unionid']) ? $this->options['wechat']['unionid'] : null;
                $open_data['nickname']       = $this->options['wechat']['nickname'];
                $open_data['avatar']         = $this->options['wechat']['headimgurl'];
                $open_data['sex']            = $this->options['wechat']['sex'] == 1 ? 1 : 0;
                $open_data['country']        = $this->options['wechat']['country'];
                $open_data['province']       = $this->options['wechat']['province'];
                $open_data['city']           = $this->options['wechat']['city'];
                $open_data['info_aggregate'] = [
                    'nickname' => $open_data['nickname'],
                    'avatar'   => $open_data['avatar'],
                    'sex'      => $open_data['sex'],
                    'province' => $open_data['province'],
                    'city'     => $open_data['city']
                ];
                $user_open_id = $user_open_model->insertUserOpen($open_data);
                if($user_open_id < 0){
                    $user_model->rollback();
                    return null;
                }
            }

            return $user_id;

        } catch( \Exception $e ){
            throw new $e;
        }
    }

    /**
     * 用户资产合并
     * @param user_id 附属用户id
     * @param master_user_id 主用户id
     * @throws \App\Utils\Exception
     * @author 韩文博
     */
    private function assetsMerge($user_id, $master_user_id)
    {
        try{
            $user_assets_model  = model('UserAssets');

            $user_assets_info = $user_assets_model->getUserAssetsInfo(['id'=>$user_id], '', '*');
            if(!$user_assets_info){
                $user_model->rollback();
                return null;
            }

            $master_user_assets_info = $user_assets_model->getUserAssetsInfo(['id'=>$master_user_id], '', '*');
            if(!$master_user_assets_info){
                $user_model->rollback();
                return null;
            }
            $user_assets_update                   = [];
            $user_assets_update['points']         = 0;
            $user_assets_update['balance']        = 0;

            $master_user_assets_update            = [];
            $master_user_assets_update['points']  = $master_user_assets_info['points'] + $user_assets_info['points'];
            $master_user_assets_update['balance'] = $master_user_assets_info['balance'] + $user_assets_info['balance'];

            $user_assets_result = $user_assets_model->updateUserAssets(['id'=>$user_id],$user_assets_update);
            if(!$user_assets_result){
                $user_model->rollback();
                return null;
            }

            $master_user_assets_result = $user_assets_model->updateUserAssets(['id'=>$master_user_id],$master_user_assets_update);
            if(!$master_user_assets_result){
                $user_model->rollback();
                return null;
            }

            $card_ids = model('Cart')->getCartColumn(['user_id'=>$user_id], '', 'id');
            if($card_ids){
                $cart_result =model('Cart')->editCart( ['id'=>['in', $card_ids]], ['user_id'=>$master_user_id] );
                if(!$cart_result){
                    $user_model->rollback();
                    return null;
                }
            }
            return true;

        } catch( \Exception $e ){
            $user_model->rollback();
            throw new $e;
        }
    }
}

?>
