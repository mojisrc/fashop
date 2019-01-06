<?php
/*/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2017/12/5
 * Time: 下午11:46
 *
 */

namespace App\Utils;


class WebSocketCode
{
	const success      = 0;
	const error        = - 1;
	const param_error  = - 2;
	const server_error = 500;

	const must_request_post   = - 1;
	const must_request_get    = - 1;
	const must_request_put    = - 1;
	const must_request_delete = - 1;


	/* 用户相关 10000 */
	const user_access_token_error         = 10005; // 令牌错误
	const user_access_token_create_fail   = 10007; // 创建token失败

	/** 后台部分 */
	const admin_user_no_auth = 90001; // 没有权限

}

