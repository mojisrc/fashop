<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/1/10
 * Time: 下午9:14
 *
 */
namespace App\Logic\Pay\Notice;
interface NoticeInterface
{
	public function __construct(  array $config );
	// 检测是否可以执行
	public function check() : bool;
	// 处理通知的统一入口
	public function handle() : bool;
	// 设置通知的数据
	public function setData( $data );
	// 获得通知发来的数据
	public function getData();
	// 获得配置
	public function getConfig() : array ;
}