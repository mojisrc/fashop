<?php
return [
	'open'      => true,
	'loop_time' => 1,// 秒
	'task_list' => [
		// 待付款订单自动关闭
		'AutoCloseUnpayOrder' => [
			"interval_time" => 60 * 60,
			"script"        => "\App\Cron\Order::autoCloseUnpay",
		],
		// 已发货订单自动收货
		'AutoReceiveOrder'    => [
			"interval_time" => 60 * 60,
			"script"        => "\App\Cron\Order::autoReceive",
		],
	],

];