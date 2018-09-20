<?php
/**
 *
 *
 * api接口测试样本
 * 批量付款到支付宝账户有密接口
 * 支付宝即时到账有密退款接口
 * 微信退款接口
 *
 *
 * @copyright  Copyright (c) 2016-2016 WenShuaiKeJi Inc. (http://www.wenshuai.cn)
 * @license    http://www.wenshuai.cn
 * @link       http://www.wenshuai.cn
 * @since      File available since Release v1.1
 */
namespace App\HttpController\Server;
use ezswoole\Controller;

class Refundoperation extends Server {
	/**
	 * 构造函数
	 * @author 孙泉
	 */
	public function __construct() {

	}

	/* *
		 * 功能：即时到账批量退款有密接口接入页
		 * 版本：3.4
		 * 修改日期：2016-03-08
		 * 说明：
		 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
		 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

		 *************************注意*************************
		 * 如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
		 * 1、开发文档中心（https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.oxen1k&treeId=66&articleId=103600&docType=1）
		 * 2、商户帮助中心（https://cshall.alipay.com/enterprise/help_detail.htm?help_id=473888）
		 * 3、支持中心（https://support.open.alipay.com/alipay/support/index.htm）
		 * 如果不想使用扩展功能请把扩展功能参数赋空值。
		 * https://docs.open.alipay.com/62/104744/
	*/
	public function alipayRefund($data) {
		header("Content-type:text/html;charset=utf-8");
		//取得阿里配置信息
		$alipay_config = config('ALIPAY_CONFIG');

		/**************************请求参数**************************/

		//批次号，必填，格式：当天日期[8位]+序列号[3至24位]，如：201603081000001
		// $batch_no = date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		$batch_no = $data['batch_no'];

		//退款笔数，必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）(值为您退款的笔数,取值1~1000间的整数)
		$batch_num = 1;

		/*
			        退款详细数据，必填，格式（支付宝交易号^退款金额^备注），多笔请用#隔开
			        detail_data中的退款笔数总和要等于参数batch_num的值；
					“退款理由”长度不能大于256字节，“退款理由”中不能有“^”、“|”、“$”、“#”等影响detail_data格式的特殊字符；
					detail_data中退款总金额不能大于交易总金额；
					一笔交易可以多次退款，退款次数最多不能超过99次，需要遵守多次退款的总金额不超过该笔交易付款金额的原则。
					格式案例：2014040311001004370000361525^5.00^协商退款
		*/

		$transaction_number = $data['trade_no']; //支付宝交易号
		$refund_amount      = $data['refund_amount']; //退款金额
		$remarks            = '支付宝退款备注'; //备注，必不可少，否则会报错
		$detail_data .= $transaction_number . '^' . $refund_amount . '^' . $remarks . '#';

		$detail_data = substr($detail_data, 0, -1);

		//服务器异步通知页面路径
		$notify_url = 'http://www.caoxiansheng.com/Api/Refundoperation/alipayRefundNotify.html';

		/**************************请求参数**************************/

		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service"        => 'refund_fastpay_by_platform_pwd',
			"partner"        => trim($alipay_config['partner']),
			"notify_url"     => $notify_url,
			"seller_email"   => $alipay_config['seller_email'],
			"refund_date"    => date('Y-m-d H:i:s', time()),
			"batch_no"       => $batch_no,
			"batch_num"      => $batch_num,
			"detail_data"    => $detail_data,
			"_input_charset" => trim(strtolower('utf-8')),

		);

		//建立请求
		$alipaySubmit = new \App\extend\Alipay\lib\AlipaySubmit($alipay_config);

		$html_text = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
		echo $html_text;
	}
	/**
	 * 支付宝即时到账有密退款接口回调
	 * @return [type] [description]
	 */
	public function alipayRefundNotify() {
		$post = $this->post;
		trace($post, 'debug');

		$alipay_config = config('ALIPAY_CONFIG');
		//计算得出通知验证结果
		$alipayNotify = new \App\extend\Alipay\lib\AlipayNotify($alipay_config);

		$verify_result = $alipayNotify->verifyNotify();

		trace($verify_result, 'debug');

		if ($verify_result) {
//验证成功
			//支付宝返回的数据
			// "sign": "d7385e257dea3270890a1a20ea949fae",
			// "result_details": "2017072021001004960274238724^0.01^SUCCESS",
			// "notify_time": "2017-07-20 15:40:16",
			// "sign_type": "MD5",
			// "notify_type": "batch_refund_notify",
			// "notify_id": "5013fab5c2867fad23832f753eab151mem",
			// "batch_no": "2017072097515455",
			// "success_num": "1

			//请在这里加上商户的业务逻辑程序代
			$batch_no = $_POST['batch_no'];

			//批量退款数据中转账成功的笔数
			$success_num = $_POST['success_num'];

			//批量退款数据中的详细信息
			$result_details = $_POST['result_details'];

			$refund_model = model('OrderRefundReturn');

			$condition             = array();
			$condition['batch_no'] = $batch_no;

			$data                 = array();
			$data['handle_state'] = 30; //平台处理状态 默认0处理中(未处理) 10拒绝(驳回) 20同意 30成功(已完成)
			$data['success_time'] = time(); //退款回调完成时间
			$res                  = $refund_model->editOrderRefundReturn($condition, $data);
			if (!$res) {
				trace('回到执行失败', 'debug');
				return $this->faJson(array('errmsg' => '操作失败'), -1);
			}
			// echo "success";		//请不要修改或删除
			return $this->faJson(array('errmsg' => '操作成功'), 0);
		} else {
			//验证失败
			// echo "fail";
			return $this->faJson(array('errmsg' => '操作失败'), -1);
		}
	}
	/**
	 * 微信支付退款
	 * https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_4
	 * refund_fee 退款总金额,单位为分,可以做部分退款
	 * @return [type] [description]
	 */
	public function wxpayRefund($data) {
		//计算得出通知验证结果

		//微信app付款方式 所以选择微信app退款
		if ($data['payment_code'] == 'wxpayapp') {
			$wxrefund = new \App\extend\payment\wxpayapp\wxrefund();
		}

		//微信web付款方式 所以选择微信web退款
		if ($data['payment_code'] == 'wxpayapp') {
			$wxrefund = new \App\extend\payment\wxpayweb\wxrefund();

		}

		$refund_data['transaction_id'] = $data['trade_no'];
		$refund_data['total_fee']      = (int) $data['refund_amount'] * 100; //必须为整数 而且微信的是分为单位的 所以得*100
		$refund_data['refund_fee']     = (int) $data['refund_amount'] * 100; //必须为整数 而且微信的是分为单位的 所以得*100

		trace(array('data' => $refund_data), 'refund_data');

		$data = $wxrefund->index($post = $refund_data);
		// 调试日志
		trace($data, 'debug');

		if ($data) {
			if ($data['result_code'] == 'SUCCESS' && $data['return_code'] == 'SUCCESS') {
				trace('退款成功', 'debug');
				// return $this->faJson(array('refund_id' => $refund_id), 0);
			} else {
				trace('退款失败', 'debug');
				// return $this->faJson(array(), -1);
			}

		} else {
			trace('退款失败', 'debug');

		}
	}
	/**
	 * 批量付款到支付宝账户有密接口
	 * @return [type] [description]
	 */
	public function batchpayment() {
		header("Content-type:text/html;charset=utf-8");
		$get       = I('get.');
		$condition = array();

		$condition['account_type'] = 1;
		$condition['_string']      = 'alipay_account is not null and alipay_account <> ' . '\'\'' . ' and alipay_name is not null and alipay_name <> ' . '\'\'';

		$order_bill_model = D('AgentOrderBill');
		$count            = $order_bill_model->where($condition)->count();
		$total            = $order_bill_model->where($condition)->sum('result_totals');
		$list             = $order_bill_model->where($condition)->order('id desc')->select();

		foreach ($list as $key => $value) {
			if ($value['alipay_payment_state'] == 1) {
				return $this->send('支付账单存在已付款条目');
			}
		}

		foreach ($list as $key => $value) {
			$serial_number       = $value['id'] . $value['agent_id']; //流水号
			$beneficiary_account = $value['alipay_account']; //收款方账号
			$beneficiary_name    = $value['alipay_name']; //收款方账号真实姓名
			$payment_amount      = $value['result_totals']; //付款金额
			$remarks             = '代理商账单结算'; //备注，必不可少，否则会报错
			$detail_data .= $serial_number . '^' . $beneficiary_account . '^' . $beneficiary_name . '^' . $payment_amount . '^' . $remarks . '|';
		}
		$detail_data = substr($detail_data, 0, -1);

		//取得阿里配置信息
		$alipay_config = config('ALIPAY_CONFIG');

		/**************************请求参数**************************/
		//服务器异步通知页面路径
		$notify_url = 'http://www.mingpinsong.com/Api/Agentorderbill/batchpaymentnotify.html';

		//需http://格式的完整路径，不允许加?id=123这类自定义参数

		//付款账号
		$email = $alipay_config['seller_email'];
		//必填

		//付款账户名
		$account_name = $alipay_config['WIDaccount_name'];
		//必填，个人支付宝账号是真实姓名公司支付宝账号是公司名称

		//付款当天日期
		$pay_date = date('Ymd', time());
		//必填，格式：年[4位]月[2位]日[2位]，如：20100801

		//批次号
		$batch_no = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		//必填，格式：当天日期[8位]+序列号[3至16位]，如：201008010000001

		//付款总金额
		$batch_fee = $total;
		//必填，即参数detail_data的值中所有金额的总和

		//付款笔数
		$batch_num = $count;
		//必填，即参数detail_data的值中，“|”字符出现的数量加1，最大支持1000笔（即“|”字符出现的数量999个）
		// $detail_data=$detail_data.'^hello';//测试
		// dump($detail_data);exit;
		//付款详细数据
		$detail_data = $detail_data;
		//必填，格式：流水号1^收款方帐号1^真实姓名^付款金额1^备注说明1|流水号2^收款方帐号2^真实姓名^付款金额2^备注说明2....
		$res_one = $order_bill_model->where($condition)->setField('batch_no', $batch_no);
		if (!$res_one) {
			$this->send('操作失败');
		}

		//构造要请求的参数数组，无需改动
		$parameter = array(
			"service"        => "batch_trans_notify",
			"partner"        => trim($alipay_config['partner']),
			"notify_url"     => $notify_url,
			"email"          => $email,
			"account_name"   => $account_name,
			"pay_date"       => $pay_date,
			"batch_no"       => $batch_no,
			"batch_fee"      => $batch_fee,
			"batch_num"      => $batch_num,
			"detail_data"    => $detail_data,
			"_input_charset" => trim(strtolower($alipay_config['input_charset'])),
		);
		//建立请求
		vendor('Alipay.lib.AlipaySubmit', '', '.class.php');
		$alipaySubmit = new \AlipaySubmit($alipay_config);
		$html_text    = $alipaySubmit->buildRequestForm($parameter, "get", "确认");
		echo $html_text;

	}

}
