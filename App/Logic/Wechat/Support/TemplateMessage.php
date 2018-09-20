<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/15
 * Time: 上午10:52
 *
 */

namespace App\Logic\Wechat\Support;

use App\Logic\Wechat\AbstractInterface\BaseAbstract;
/**
 * 模板消息仅用于公众号向用户发送重要的服务通知，只能用于符合其要求的服务场景中，如信用卡刷卡通知，商品购买成功通知等。不支持广告等营销类消息以及其它所有可能对用户造成骚扰的消息。
 */
class TemplateMessage extends BaseAbstract
{
	/**
	 * 修改账号所属行业
	 * @author 韩文博
	 */
	public function setIndustry()
	{
		return $this->app->template_message->setIndustry( $industryId1, $industryId2 );
	}


	/**
	 * 获取支持的行业列表
	 */
	public function getIndustry()
	{
		return $this->app->template_message->getIndustry();

	}

	/**
	 * 添加模板
	 * 在公众号后台获取 $shortId 并添加到账户。
	 * @method GET
	 * @author 韩文博
	 */
	public function addTemplate()
	{
		return $this->app->template_message->addTemplate( $shortId );
	}

	/**
	 * 获取所有模板列表
	 * @method GET
	 * @author 韩文博
	 */
	public function getPrivateTemplates()
	{
		return $this->app->template_message->getPrivateTemplates();

	}

	/**
	 * 删除模板
	 * @method GET
	 * @author 韩文博
	 */
	public function deletePrivateTemplate()
	{
		return $this->app->template_message->deletePrivateTemplate( $templateId );

	}

	/**
	 * 发送模板消息
	 * @method GET
	 * @author 韩文博
	 */
	public function send()
	{
		return $this->app->template_message->send( [
			'touser'      => 'user-openid',
			'template_id' => 'template-id',
			'url'         => 'https://easyapp.org',
			'data'        => [
				'key1' => 'VALUE',
				'key2' => 'VALUE2',
			],
		] );
	}

	/**
	 * 发送一次性订阅消息
	 * @method GET
	 * @author 韩文博
	 */
	public function sendSubscription()
	{
		return $this->app->template_message->sendSubscription( [
			'touser'      => 'user-openid',
			'template_id' => 'template-id',
			'url'         => 'https://easyapp.org',
			'scene'       => 1000,
			'data'        => [
				'key1' => 'VALUE',
				'key2' => 'VALUE2',
			],
		] );
	}

	//
	//如果你想为发送的内容字段指定颜色，你可以将 "data" 部分写成下面 4 种不同的样式，不写 color 将会是默认黑色：
	//'data' => [
	//'foo' => '你好',  // 不需要指定颜色
	//'bar' => ['你好', '#F00'], // 指定为红色
	//'baz' => ['value' => '你好', 'color' => '#550038'], // 与第二种一样
	//'zoo' => ['value' => '你好'], // 与第一种一样
	//]
}