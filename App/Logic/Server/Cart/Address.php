<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/6
 * Time: 上午12:33
 *
 */

namespace App\Logic\Server\Cart;


class Address
{
	/**
	 * @var int
	 */
	private $userId;
	/**
	 * @var string
	 */
	private $truename;
	/**
	 * @var string
	 */
	private $address;
	/**
	 * @var string
	 */
	private $mobilePhone;
	/**
	 * @var string
	 */
	private $combineDetail;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var int
	 */
	private $cityId;
	/**
	 * @var int
	 */
	private $provinceId;
	/**
	 * @var int
	 */
	private $areaId;

	/**
	 * @return int
	 */
	public function getCityId() : int
	{
		return $this->cityId;
	}

	/**
	 * @param int $cityId
	 */
	public function setCityId( int $cityId ) : void
	{
		$this->cityId = $cityId;
	}

	/**
	 * @return int
	 */
	public function getProvinceId() : int
	{
		return $this->provinceId;
	}

	/**
	 * @param int $provinceId
	 */
	public function setProvinceId( int $provinceId ) : void
	{
		$this->provinceId = $provinceId;
	}

	/**
	 * @return int
	 */
	public function getAreaId() : int
	{
		return $this->areaId;
	}

	/**
	 * @param int $areaId
	 */
	public function setAreaId( int $areaId ) : void
	{
		$this->areaId = $areaId;
	}

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
	public function getTruename() : string
	{
		return $this->truename;
	}

	/**
	 * @param string $truename
	 */
	public function setTruename( string $truename ) : void
	{
		$this->truename = $truename;
	}

	/**
	 * @return string
	 */
	public function getAddress() : string
	{
		return $this->address;
	}

	/**
	 * @param string $address
	 */
	public function setAddress( string $address ) : void
	{
		$this->address = $address;
	}

	/**
	 * @return string
	 */
	public function getMobilePhone() : string
	{
		return $this->mobilePhone;
	}

	/**
	 * @param string $mobilePhone
	 */
	public function setMobilePhone( string $mobilePhone ) : void
	{
		$this->mobilePhone = $mobilePhone;
	}

	/**
	 * @return string
	 */
	public function getCombineDetail() : string
	{
		return $this->combineDetail;
	}

	/**
	 * @param string $combineDetail
	 */
	public function setCombineDetail( string $combineDetail ) : void
	{
		$this->combineDetail = $combineDetail;
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



	public function __construct( $options )
	{
		$this->setAreaId( $options['area_id'] );
		$this->setCityId( $options['city_id'] );
		$this->setProvinceId( $options['province_id'] );
		$this->setUserId( $options['user_id'] );
		$this->setCombineDetail( $options['combine_detail'] );
		$this->setMobilePhone( $options['mobile_phone'] );
		$this->setTruename( $options['truename'] );
		$this->setAddress( $options['address'] );
		$this->setType( $options['type'] );

	}
}