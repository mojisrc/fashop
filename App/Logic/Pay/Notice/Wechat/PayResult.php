<?php
/**
 *
 * Copyright  FaShop
 * License    http://www.fashop.cn
 * link       http://www.fashop.cn
 * Created by FaShop.
 * User: hanwenbo
 * Date: 2018/4/7
 * Time: 下午12:31
 *
 */

namespace App\Logic\Pay\Notice\Wechat;


class PayResult
{
//	private $returnCode;
//	private $return_msg;
//	private $appid;
//	private $mchId;
//	private $deviceInfo;
//	private $nonceStr;
//	private $sign;
//	private $resultCode;
//	private $errCode;
//	private $errCodeDes;
//	private $openid;
//	private $isSubscribe;
//	private
//	应用ID	appid	是	String(32)	wx8888888888888888	微信开放平台审核通过的应用APPID
//	商户号	mch_id	是	String(32)	1900000109	微信支付分配的商户号
//	设备号	device_info	否	String(32)	013467007045764	微信支付分配的终端设备号，
//	随机字符串	nonce_str	是	String(32)	5K8264ILTKCH16CQ2502SI8ZNMTM67VS	随机字符串，不长于32位
//	签名	sign	是	String(32)	C380BEC2BFD727A4B6845133519F3AD6	签名，详见签名算法
//	业务结果	result_code	是	String(16)	SUCCESS	SUCCESS/FAIL
//	错误代码	err_code	否	String(32)	SYSTEMERROR	错误返回的信息描述
//	错误代码描述	err_code_des	否	String(128)	系统错误	错误返回的信息描述
//	用户标识	openid	是	String(128)	wxd930ea5d5a258f4f	用户在商户appid下的唯一标识
//	是否关注公众账号	is_subscribe	否	String(1)	Y	用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
//	交易类型	trade_type	是	String(16)	APP	APP
//	付款银行	bank_type	是	String(16)	CMC	银行类型，采用字符串类型的银行标识，银行类型见银行列表
//	总金额	total_fee	是	Int	100	订单总金额，单位为分
//	货币种类	fee_type	否	String(8)	CNY	货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
//	现金支付金额	cash_fee	是	Int	100	现金支付金额订单现金支付金额，详见支付金额
//	现金支付货币类型	cash_fee_type	否	String(16)	CNY	货币类型，符合ISO4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
//	代金券金额	coupon_fee	否	Int	10	代金券或立减优惠金额<=订单总金额，订单总金额-代金券或立减优惠金额=现金支付金额，详见支付金额
//	代金券使用数量	coupon_count	否	Int	1	代金券或立减优惠使用数量
//	代金券ID	coupon_id_$n	否	String(20)	10000	代金券或立减优惠ID,$n为下标，从0开始编号
//	单个代金券支付金额	coupon_fee_$n	否	Int	100	单个代金券或立减优惠支付金额,$n为下标，从0开始编号
//	微信支付订单号	transaction_id	是	String(32)	1217752501201407033233368018	微信支付订单号
//	商户订单号	out_trade_no	是	String(32)	1212321211201407033568112322	商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
//	商家数据包	attach	否	String(128)	123456	商家数据包，原样返回
//	支付完成时间	time_end	是	String(14)	20141030133525	支付完成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
}