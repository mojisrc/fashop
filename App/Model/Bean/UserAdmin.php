<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2019-02-22
 * Time: 15:38
 *
 */

namespace App\Model\Bean;


use EasySwoole\Spl\SplBean;

class UserAdmin extends SplBean
{
	/**
	 * @var int
	 */
	protected $id;
	/**
	 * @var int
	 */
	protected $user_id;
	/**
	 * @var int
	 */
	protected $status;
	/**
	 * @var string
	 */
	protected $name;
	/**
	 * @var string
	 */
	protected $avatar;

	/**
	 * @return int
	 */
	public function getUserId() : int
	{
		return $this->user_id;
	}

	/**
	 * @param int $user_id
	 */
	public function setUserId( int $user_id ) : void
	{
		$this->user_id = $user_id;
	}

	/**
	 * @return int
	 */
	public function getStatus() : int
	{
		return $this->status;
	}

	/**
	 * @param int $status
	 */
	public function setStatus( int $status ) : void
	{
		$this->status = $status;
	}

	/**
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName( string $name ) : void
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getAvatar() : string
	{
		return $this->avatar;
	}

	/**
	 * @param string $avatar
	 */
	public function setAvatar( string $avatar ) : void
	{
		$this->avatar = $avatar;
	}

	/**
	 * @return int
	 */
	public function getId() : int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 */
	public function setId( int $id ) : void
	{
		$this->id = $id;
	}


}
