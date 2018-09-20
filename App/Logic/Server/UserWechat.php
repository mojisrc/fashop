<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/3/29
 * Time: 下午2:52
 *
 */

namespace App\Logic\Server;


class UserWechat
{
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var string
	 */
	private $openId;
	/**
	 * @var int
	 */
	private $sex;
	/**
	 * @var string
	 */
	private $nickname;
	/**
	 * @var string
	 */
	private $language;
	/**
	 * @var string
	 */
	private $city;
	/**
	 * @var string
	 */
	private $province;
	/**
	 * @var string
	 */
	private $country;
	/**
	 * @var string
	 */
	private $headimgurl;
	/**
	 * @var string
	 */
	private $unionid;
	/**
	 * @var string
	 */
	private $remark;
	/**
	 * @var string
	 */
	private $groupid;
	/**
	 * @var array
	 */
	private $tagidList;
	/**
	 * @var int
	 */
	private $subscribe;
	/**
	 * @var int
	 */
	private $subscribeTime;
	/**
	 * @var array
	 */
	private $options;
	/**
	 * @return int
	 */
	public function getUserId() : int
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId( int $userId ) : void
	{
		$this->userId = $userId;
	}

	/**
	 * @return string
	 */
	public function getOpenId() : string
	{
		return $this->openId;
	}

	/**
	 * @param string $openId
	 */
	public function setOpenId( string $openId ) : void
	{
		$this->openId = $openId;
	}

	/**
	 * @return int
	 */
	public function getSex() : int
	{
		return $this->sex;
	}

	/**
	 * @param int $sex
	 */
	public function setSex( int $sex ) : void
	{
		$this->sex = $sex;
	}

	/**
	 * @return string
	 */
	public function getNickname() : string
	{
		return $this->nickname;
	}

	/**
	 * @param string $nickname
	 */
	public function setNickname( string $nickname ) : void
	{
		$this->nickname = $nickname;
	}

	/**
	 * @return string
	 */
	public function getLanguage() : string
	{
		return $this->language;
	}

	/**
	 * @param string $language
	 */
	public function setLanguage( string $language ) : void
	{
		$this->language = $language;
	}

	/**
	 * @return string
	 */
	public function getCity() : string
	{
		return $this->city;
	}

	/**
	 * @param string $city
	 */
	public function setCity( string $city ) : void
	{
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getProvince() : string
	{
		return $this->province;
	}

	/**
	 * @param string $province
	 */
	public function setProvince( string $province ) : void
	{
		$this->province = $province;
	}

	/**
	 * @return string
	 */
	public function getCountry() : string
	{
		return $this->country;
	}

	/**
	 * @param string $country
	 */
	public function setCountry( string $country ) : void
	{
		$this->country = $country;
	}

	/**
	 * @return string
	 */
	public function getHeadimgurl() : string
	{
		return $this->headimgurl;
	}

	/**
	 * @param string $headimgurl
	 */
	public function setHeadimgurl( string $headimgurl ) : void
	{
		$this->headimgurl = $headimgurl;
	}

	/**
	 * @return string
	 */
	public function getUnionid() : string
	{
		return $this->unionid;
	}

	/**
	 * @param string $unionid
	 */
	public function setUnionid( string $unionid ) : void
	{
		$this->unionid = $unionid;
	}

	/**
	 * @return string
	 */
	public function getRemark() : string
	{
		return $this->remark;
	}

	/**
	 * @param string $remark
	 */
	public function setRemark( string $remark ) : void
	{
		$this->remark = $remark;
	}

	/**
	 * @return string
	 */
	public function getGroupid() : string
	{
		return $this->groupid;
	}

	/**
	 * @param string $groupid
	 */
	public function setGroupid( string $groupid ) : void
	{
		$this->groupid = $groupid;
	}

	/**
	 * @return array
	 */
	public function getTagidList() : array
	{
		return $this->tagidList;
	}

	/**
	 * @param array $tagidList
	 */
	public function setTagidList( array $tagidList ) : void
	{
		$this->tagidList = $tagidList;
	}

	/**
	 * @return int
	 */
	public function getSubscribe() : int
	{
		return $this->subscribe;
	}

	/**
	 * @param int $subscribe
	 */
	public function setSubscribe( int $subscribe ) : void
	{
		$this->subscribe = $subscribe;
	}

	/**
	 * @return int
	 */
	public function getSubscribeTime() : int
	{
		return $this->subscribeTime;
	}

	/**
	 * @param int $subscribeTime
	 */
	public function setSubscribeTime( int $subscribeTime ) : void
	{
		$this->subscribeTime = $subscribeTime;
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
		$this->setOptions($options);
	}


}