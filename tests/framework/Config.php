<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/6
 * Time: 下午5:52
 *
 */

namespace FaShopTest\framework;


class Config
{
	static function get(){
		return [
			'temp_project_path' => 'TempProject',
			'test_result_path'=>'TestResult',
			'database'=>[
				'hostname'        => '47.93.124.60',
				// 数据库名
				'database'        => 'fashop',
				// 用户名
				'username'        => 'fashop',
				// 密码
				'password'        => 'Lf2!nkX0wAB$uu&HZw5hr$YMHCWS*C&5',
			],
            'client'=>[
                'base_uri'        => 'http://127.0.0.1:9510/',
                'timeout'         => 0,
            ],
		];
	}
}