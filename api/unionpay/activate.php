<?php
//header ( 'Content-type: application/json;charset=UTF-8' );
include_once './func/common.php';
include_once './func/SDKConfig.php';
include_once './func/secureUtil.php';
include_once './func/encryptParams.php';
include_once './func/httpClient.php';


if (!isset($_GET['card_info']) || !isset($_GET['redirect_url']))
	die(json_encode(array(
			'status'=>400,
			'message'=>'Invalid input: card_info, redirect_url are required.'
		)));

$decrypted_post_data = decrypt_post_data($_GET['card_info']);

try{
	$card_info = json_decode($decrypted_post_data, True);
} catch (Exception $e) {
	die(json_encode(array(
			'status'=>400,
			'message'=>'Error parsing post data.'
		)));
}

$params = array(
		//固定填写
		'version'=> '5.0.0',//版本号--M
		//默认取值：UTF-8
		'encoding'=> 'UTF-8',//编码方式--M
		//通过MPI插件获取
		'certId'=> getSignCertId (),//证书ID--M
		//01RSA02 MD5 (暂不支持)
		'signMethod'=> '01',//签名方法--M
		//交易类型 00
		'txnType'=> '79',//交易类型--M
		//默认00
		'txnSubType'=> '00',//交易子类--M
		//默认:000000
		'bizType'=> '000301',//产品类型--M
		//0：普通商户直连接入2：平台类商户接入
		'accessType'=> '0',//接入类型--M
		//　
		'merId'=> $SDK_MER_ID,//商户代码--M
		//被查询交易的交易时间
		'txnTime'=> date('YmdHis'),//订单发送时间--M
		//被查询交易的订单号
		'orderId'=> date('YmdHis'),//商户订单号--M
		//待查询交易的流水号
		//'queryId'=> '',//交易查询流水号--C
		//格式如下：{子域名1=值&子域名2=值&子域名3=值} 子域： origTxnType N2原交易类型余额查询时必送
		//'reserved'=> '',//保留域--O

		'accType'=>$card_info['acc_type'],

		'accNo'=>$card_info['acc_no'],

		'customerInfo'=>customerInfo_sms($card_info['acc_no'], $card_info['certif_tp'], $card_info['certif_id'], $card_info['customer_name'], $card_info['phone_no'], $card_info['pin'], $card_info['cvn2'], $card_info['expired']),

		'encryptCertId'=> getEncryptCertId(),

		'channelType'=>'07',

		'backUrl'=>$SDK_BACK_NOTIFY_URL,

		'frontUrl'=>$_GET['redirect_url'],

	);

// 检查字段是否需要加密
encrypt_params ( $params );

// 签名
sign ( $params );

// 发送信息到后台
$result = sendHttpRequest ( $params, $SDK_FRONT_TRANS_URL );

/*$result_array = coverStringToArray($result);

if ($result_array['respCode'] != '00') {
	die(json_encode(array(
			'status'=>'-1',
			'message'=>'Error querying Unionpay API.',
			'error_resp_code'=>$result_array['respCode']
		)));
}

echo json_encode(array(
	'status'=>200,
	'message'=>'Success',
	'activate_status'=>$result_array['activateStatus']
));*/

echo $result;
