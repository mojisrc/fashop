<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/2/6
 * Time: 下午5:51
 *
 */

namespace FaShopTest\framework;

class Init
{
	private $config;
	function run(){
//		- 移动文件子目录，fashop-test
		$this->config = Config::get();
		$this->checkDbPermissions();

		$this->checkFilePermissions();

		$this->checkEvn();

//		- 登陆请求

//		- 测试完所有接口
//		- 清理临时文件夹、临时数据库、关闭启动的端口
//		- 请求完毕根据配置目录生成返回的Body
//		- 生成可以查看body结果的程序，方便测试人员看每个结果的返回数据
//		- 导出错误结果的excel和效率图

	}

	private function checkDbPermissions(){
		//		- 检测数据库是否可创建

		//		- 检测数据库增删改查权限是否存在
		//		- 如果数据库没清空请提示先去清空再执行
	}
	private function checkFilePermissions(){
		//		- 检测文件夹权限
		//		- 复制指定文件到fashop-test目录
	}

	private function checkEvn(){
		//		- 检测所处环境是否允许
	}
	private function init(){
		//		- 初始化项目
		//		- 导入初始化数据库
	}

}