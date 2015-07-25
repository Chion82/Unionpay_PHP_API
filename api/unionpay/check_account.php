<?php
header ( 'Content-type: application/json;charset=UTF-8' );
include_once './func/common.php';
include_once './func/SDKConfig.php';
include_once './func/secureUtil.php';
include_once './func/encryptParams.php';
include_once './func/httpClient.php';

if (!isset($_POST['card_info']))
	die(json_encode(array(
			'status'=>400,
			'message'=>'Invalid input: card_info is required.'
		)));

$decrypted_post_data = decrypt_post_data($_POST['card_info']);

try{
	$card_info = json_decode($decrypted_post_data, True);
} catch (Exception $e) {
	die(json_encode(array(
			'status'=>400,
			'message'=>'Error parsing post data.'
		)));
}

$params = array(
		//�̶���д
		'version'=> '5.0.0',//�汾��--M
		//Ĭ��ȡֵ��UTF-8
		'encoding'=> 'UTF-8',//���뷽ʽ--M
		//ͨ��MPI�����ȡ
		'certId'=> getSignCertId (),//֤��ID--M
		//01RSA02 MD5 (�ݲ�֧��)
		'signMethod'=> '01',//ǩ������--M
		//�������� 00
		'txnType'=> '78',//��������--M
		//Ĭ��00
		'txnSubType'=> '00',//��������--M
		//Ĭ��:000000
		'bizType'=> '000301',//��Ʒ����--M
		//0����ͨ�̻�ֱ������2��ƽ̨���̻�����
		'accessType'=> '0',//��������--M
		//��
		'merId'=> $SDK_MER_ID,//�̻�����--M
		//����ѯ���׵Ľ���ʱ��
		'txnTime'=> date('YmdHis'),//��������ʱ��--M
		//����ѯ���׵Ķ�����
		'orderId'=> date('YmdHis'),//�̻�������--M
		//����ѯ���׵���ˮ��
		//'queryId'=> '',//���ײ�ѯ��ˮ��--C
		//��ʽ���£�{������1=ֵ&������2=ֵ&������3=ֵ} ���� origTxnType N2ԭ������������ѯʱ����
		//'reserved'=> '',//������--O

		'accType'=>$card_info['acc_type'],

		'accNo'=>$card_info['acc_no'],

		'channelType'=>'07',

	);

// ����ֶ��Ƿ���Ҫ����
encrypt_params ( $params );

// ǩ��
sign ( $params );

// ������Ϣ����̨
$result = sendHttpRequest ( $params, $SDK_BACK_TRANS_URL );
$result_array = coverStringToArray($result);

if ($result_array['respCode'] != '00' && $result_array['respCode'] != '77') {
	die(json_encode(array(
			'status'=>-1,
			'message'=>'Error querying Unionpay API.',
			'error_resp_code'=>$result_array['respCode'],
			'error_resp'=>$result
		)));
}

echo json_encode(array(
	'status'=>200,
	'message'=>'Success',
	'activate_status'=>$result_array['activateStatus']
));
