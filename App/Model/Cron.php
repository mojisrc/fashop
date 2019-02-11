<?php

namespace App\Model;

use ezswoole\Model;

class Cron extends Model
{
	protected $softDelete = true;

	/**
	 * @param array $condition
	 * @return array|bool
	 */
	public function getCronInfo( $condition = [] )
	{
		return $this->where( $condition )->find();
	}

	/**
	 * @param     $condition
	 * @param int $limit
	 * @return array|bool|false|null
	 */
	public function getCronList( $condition, $limit = 10 )
	{
		return $this->where( $condition )->limit( $limit )->select();
	}

	/**
	 * @param array $data
	 * @return bool|int
	 */
	public function addCron( array $data )
	{
		return $this->add( $data );
	}

	/**
	 * @param $condition
	 * @return bool|null
	 */
	public function delCron( $condition )
	{
		return $this->where( $condition )->del();
	}


}
