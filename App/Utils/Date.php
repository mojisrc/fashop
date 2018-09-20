<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/11/29
 * Time: 下午2:30
 *
 */

namespace App\Utils;


class Date
{
	/**
	 * 最近的星期几日期，抛去开始日期
	 * @param string $start_date
	 * @param int    $week
	 * @author 韩文博
	 */
	public static function nearlyWeekDate( string $start_date, int $week )
	{
		if( $week == 7 ){
			$week = 0;
		}
		$_week = date( "w", $start_date );

		if( $_week > $week || $_week == $week ){
			$day = $week + 7 - $_week;
		} else{
			$day = $week - $_week;
		}
		return date( 'Y-m-d', strtotime( "{$start_date} + {$day} day" ) );
	}

	/**
	 * 求两个日期之间相差的天数
	 * (针对1970年1月1日之后，求之前可以采用泰勒公式)
	 * @param string $day1
	 * @param string $day2
	 * @return number
	 */
	public static function diffBetweenTwoDays( $day1, $day2 )
	{
		$second1 = strtotime( $day1 );
		$second2 = strtotime( $day2 );

		if( $second1 < $second2 ){
			$tmp     = $second2;
			$second2 = $second1;
			$second1 = $tmp;
		}
		return ($second1 - $second2) / 86400;
	}

	/**
	 * 求两个日期之间相差的天数的周几集合
	 * 说明：国外0代表周日，这里转成了7，方便理解
	 * @param string $start_date
	 * @param string $end_date
	 * @return array
	 */
	public static function betweenDatesWeeks( $start_date, $end_date )
	{
		$days  = self::diffBetweenTwoDays( $start_date, $end_date );
		$weeks = [];
		for( $i = 0 ; $i <= $days ; $i ++ ){
			$weeks[] = date( "w", strtotime( "{$start_date} + {$i} day" ) );
		}
		foreach( $weeks as $key => $week ){
			if( $week == 0 ){
				$weeks[$key] = 7;
			}
		}
		return $weeks;
	}

	/**
	 * 获得周
	 * @param mixed $day int|date
	 * @return false|int|string
	 * @author 韩文博
	 */
	public static function week($day){
		if(is_numeric($day)){
			$week = date('w',$day);
		}else{
			$week = date('w', strtotime($day));
		}
		return $week == 0 ? 7 : $week;
	}
}
