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


class Code
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
	const user_password_old_same          = 10001; // 老密码与新密码不能相同
	const user_password_short             = 10002; // 密码短了
	const user_password_long              = 10003; // 密码长了
	const user_not_login                  = 10004; // 未登陆
	const user_access_token_error         = 10005; // 令牌错误
	const user_login_type_error           = 10006; // 登陆方式错误
	const user_access_token_create_fail   = 10007; // 创建token失败
	const user_username_require           = 10008; // 用户名必填
	const user_password_require           = 10009; // 密码必填
	const user_username_or_email_error    = 10010;//手机或邮箱格式不正确
	const user_account_not_exist          = 10011;// 账号不存在
	const user_phone_format_error         = 10012;// 手机格式错误
	const user_username_or_password_error = 10013;//账号或密码错误
	const user_wechat_openid_not_exist    = 10014;// 微信openid不存在
	const user_wechat_openid_exist        = 10015;// 微信openid已存在
	const user_register_type_error        = 10016;// 注册方式错误
	const user_account_exist              = 10017;// 账号存在（用户名|手机号|邮箱）
	/** 验证码 */
	const verify_code_length                   = 11000; // 验证码长度错误
	const verify_code_number                   = 11001; // 验证码个是不对
	const verify_code_expire                   = 11002; //验证码已失效
	const verify_code_not_exist                = 11003;//验证码不存在
	const verify_code_check_channel_type_error = 11004;//渠道错误

	/* 订单相关 20000 */

	/* 商品相关 30000 */
	const goods_offline  = 30001; // 已下架
	const goods_stockout = 30002; // 缺货

	/* 购物车相关 31000 */
	const cart_goods_not_exist = 31001; // 购物车商品不存在


	/* 升级 80000 */
	const update_packing          = 80000; // 正在打包中
	const update_packed           = 80001; // 打包完成
	const update_pack_fail        = 80002; // 打包失败
	const update_no_need          = 80002; // 不需要升级
	const update_download_fail    = 80003; // 下载失败
	const update_open_zip_fail    = 80004; // 解压包打开失败
	const update_extract_zip_fail = 80005; // 解压失败
	const update_version_fail     = 80006; // 更新系统版本失败
	const update_db_version_fail  = 80007; // 更新系统数据库版本失败
	/* 微信 40000 */
	const wechat_qr_expired = 40000;  // 过期
	const wechat_qr_unscan  = 40001; // 未扫描
	const wechat_qr_unexsit = 40002; // 不存在
	const wechat_api_error  = 40003; //微信接口请求失败

	/* 微信小程序 41000*/
	const wechat_mini_param_error = 41001;  // 小程序参数错误

	/** 后台部分 */
	const admin_user_no_auth = 90001; // 没有权限

}

