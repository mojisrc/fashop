<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/14
 * Time: 下午10:36
 *
 */

namespace App\Logic\Wechat\Support;
use App\Logic\Wechat\AbstractInterface\BaseAbstract;

use App\Utils\Code;

/**
 * Trait DataCube
 * @package App\Controller\Admin\appTrait
 *
 *
 * 通过数据接口，开发者可以获取与公众平台官网统计模块类似但更灵活的数据，还可根据需要进行高级处理。
 * 接口侧的公众号数据的数据库中仅存储了 2014年12月1日之后的数据，将查询不到在此之前的日期，即使有查到，也是不可信的脏数据；
 * 请开发者在调用接口获取数据后，将数据保存在自身数据库中，即加快下次用户的访问速度，也降低了微信侧接口调用的不必要损耗。
 * 额外注意，获取图文群发每日数据接口的结果中，只有中间页阅读人数+原文页阅读人数+分享转发人数+分享转发次数+收藏次数 >=3 的结果才会得到统计，过小的阅读量的图文消息无法统计。
 * `$from` 和 `$to` 的差值需小于 “最大时间跨度”（比如最大时间跨度为 1 时，`$from` 和 `$to` 的差值只能为 0，才能小于 1 ），否则会报错
 * 示例：$userSummary = $app->data_cube->userSummary('2014-12-07', '2014-12-08');
 */
class DataCube extends BaseAbstract
{

	/**
	 * 获取用户增减数据, 最大时间跨度：7;
	 * @method GET
	 * @author 韩文博
	 */
	public function userSummary(string $from , string  $to)
	{
		return $this->app->data_cube->userSummary( $from, $to );
	}

	/**
	 * 获取图文群发每日数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function articleSummary()
	{
		return $this->app->data_cube->articleSummary( $this->get['from'], $this->get['to'] );
	}

	/**
	 * 获取图文群发总数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function articleTotal()
	{
		return $this->app->data_cube->articleTotal( $this->get['from'], $this->get['to'] );
	}

	/**
	 * 获取图文统计数据, 最大时间跨度：3;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function userReadSummary()
	{
		return $this->app->data_cube->userReadSummary( $this->get['from'], $this->get['to'] );
	}

	/**
	 *  获取图文统计分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function userReadHourly()
	{
		$result = $this->app->data_cube->userReadHourly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取图文分享转发数据, 最大时间跨度：7;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function userShareSummary()
	{
		$result = $this->app->data_cube->userShareSummary( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取图文分享转发分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function userShareHourly()
	{
		$result = $this->app->data_cube->userShareHourly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送概况数据, 最大时间跨度：7;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageSummary()
	{
		$result = $this->app->data_cube->upstreamMessageSummary( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageHourly()
	{
		$result = $this->app->data_cube->upstreamMessageHourly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送周数据, 最大时间跨度：30;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageWeekly()
	{
		$result = $this->app->data_cube->upstreamMessageWeekly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送月数据, 最大时间跨度：30;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageMonthly()
	{
		$result = $this->app->data_cube->upstreamMessageMonthly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送分布数据, 最大时间跨度：15;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageDistSummary()
	{
		$result = $this->app->data_cube->upstreamMessageDistSummary( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送分布周数据, 最大时间跨度：30;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageDistWeekly()
	{
		$result = $this->app->data_cube->upstreamMessageDistWeekly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取消息发送分布月数据, 最大时间跨度：30;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function upstreamMessageDistMonthly()
	{
		$result = $this->app->data_cube->upstreamMessageDistMonthly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取接口分析数据, 最大时间跨度：30;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function interfaceSummary()
	{
		$result = $this->app->data_cube->interfaceSummary( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取接口分析分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @author 韩文博
	 */
	public function interfaceSummaryHourly()
	{
		$result = $this->app->data_cube->interfaceSummaryHourly( $this->get['from'], $this->get['to'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取普通卡券分析分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @param int    $cond_source
	 * @author 韩文博
	 */
	public function cardSummary()
	{
		isset( $this->get['cond_source'] ) ?: $this->get['cond_source'] = 0;
		$result = $this->app->cardSummary( $this->get['from'], $this->get['to'], $this->get['cond_source'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取免费券分析分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @param int    $cond_source
	 * @param string $card_id
	 * @author 韩文博
	 */
	public function freeCardSummary()
	{
		isset( $this->get['cond_source'] ) ?: $this->get['cond_source'] = 0;
		isset( $this->get['card_id'] ) ?: $this->get['card_id'] = '';
		$result = $this->app->freeCardSummary( $this->get['from'], $this->get['to'], $this->get['cond_source'], $this->get['card_id'] );
		return $this->send( Code::success, $result );
	}

	/**
	 * 获取会员卡分析分时数据, 最大时间跨度：1;
	 * @method GET
	 * @param string $from
	 * @param string $to
	 * @param int    $cond_source
	 * @author 韩文博
	 */
	public function memberCardSummary( string $from, string $to, int $condSource = 0 )
	{
		isset( $this->get['cond_source'] ) ?: $this->get['cond_source'] = 0;
		$result = $this->app->memberCardSummary( $this->get['from'], $this->get['to'], $this->get['cond_source'] );
		return $this->send( Code::success, $result );
	}
}