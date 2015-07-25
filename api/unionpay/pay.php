<?php
header ( 'Content-type: application/json;charset=UTF-8' );
include_once './func/common.php';
include_once './func/SDKConfig.php';
include_once './func/secureUtil.php';
include_once './func/encryptParams.php';
include_once './func/httpClient.php';
include_once './custom_func.php';

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
		'encoding'=> 'GBK',//���뷽ʽ--M
		//ͨ��MPI�����ȡ
		'certId'=> getSignCertId (),//֤��ID--M
		//01RSA02 MD5 (�ݲ�֧��)
		'signMethod'=> '01',//ǩ������--M
		//ȡֵ��01 
		'txnType'=> '01',//��������--M
		//01���������ѣ�ͨ����ַ�ķ�ʽ����ǰ̨���Ѻͺ�̨���ѣ�������ת֧����03�����ڸ���
		'txnSubType'=> '01',//��������--M
		// 
		'bizType'=> '000301',//��Ʒ����--M
		'channelType'=> '07',//��������--M
		//ǰ̨�����̻����ʱʹ�ã�ǰ̨�ཻ��������
		//'frontUrl'=> '',//ǰ̨֪ͨ��ַ--C
		//��̨�����̻����ʱʹ�ã������ͣ������̻���̨���׽��֪ͨ
		'backUrl'=> $SDK_BACK_NOTIFY_URL,//��̨֪ͨ��ַ--M
		//0����ͨ�̻�ֱ������2��ƽ̨���̻�����
		'accessType'=> '0',//��������--M
		//��
		'merId'=> $SDK_MER_ID,//�̻�����--M
		//�̻�����Ϊƽ̨���̻�����ʱ��������
		//'subMerId'=> '',//�����̻�����--C
		//�̻�����Ϊƽ̨���̻�����ʱ��������
		//'subMerName'=> '',//�����̻�ȫ��--C
		//�̻�����Ϊƽ̨���̻�����ʱ��������
		//'subMerAbbr'=> '',//�����̻����--C
		//�̻�������
		'orderId'=> get_order_id(),//�̻�������--M
		//�̻����ͽ���ʱ��
		'txnTime'=> get_order_time(),//��������ʱ��--M
		//��̨�ཻ���ҿ������ͣ������յ����յ������ռ����п���Ϣʱ����01�����п�02������03��C��Ĭ��ȡֵ��01ȡֵ��03����ʾ��IC�ն˷����IC�����ף�IC��Ϊ��ͨ���п�����֧��ʱ��������дΪ��01��
		'accType'=> $card_info['acc_type'],//�˺�����--C
		//1��  ��̨�����ѽ���ʱ����ȫ���Ż򿨺ź�4λ 2��  �����յ����յ������ռ����п���Ϣʱ���͡�  3��ǰ̨�ཻ�׿�ͨ�����ú󷵻أ����ſ�ѡ����
		'accNo'=> $card_info['acc_no'],//�˺�--C
		//���׵�λΪ��
		'txnAmt'=> get_payment_amount(),//���׽��--M	//TODO
		//Ĭ��Ϊ156���� �ο�����
		'currencyCode'=> '156',//���ױ���--M
		//1����̨�����ѽ���ʱ����2�������յ����յ������ռ����п���Ϣʱ����3����֤֧��2.0����̨����ʱ��ѡKey=value��ʽ��������д�ο�����Ԫ˵����
		'customerInfo'=> customerInfo($card_info['acc_no'], $card_info['certif_tp'], $card_info['certif_id'], iconv( "UTF-8", "gb2312" , $card_info['customer_name']), $card_info['phone_no'], $card_info['sms_code'], $card_info['pin'], $card_info['cvn2'], $card_info['expired']),//���п���֤��Ϣ�������Ϣ--C
		//'customerInfo'=> customerInfo(),//���п���֤��Ϣ�������Ϣ--C
		
		//PC1��ǰ̨�����ѽ���ʱ����2����֤֧��2.0����̨����ʱ��ѡ
		//'orderTimeout'=> '',//�������ճ�ʱʱ�䣨������ʹ�ã�--O
		//��
		//'termId'=> '',//�ն˺�--O
		//�̻��Զ��屣���򣬽���Ӧ��ʱ��ԭ������
		'reqReserved'=> gen_callback_reserved_string(),//���󷽱�����--O
		//�������� ��� marketId  �ƶ�֧����������ʱ���ض��̻�����ͨ���������͸ö���֧���μӵĻ��
		//'reserved'=> '',//������--O
		//��ʽ���£�{������1=ֵ&������2=ֵ&������3=ֵ}
		//'riskRateInfo'=> '',//������Ϣ��--O
		//��ʹ��������Կ�����������Ϣʱ�������ͼ���֤���CertID��˵��һ�£�Ŀǰ�̻���������ҳ��ͳһ��
		'encryptCertId'=> getEncryptCertId(),//����֤��ID--C
		//ǰ̨���ѽ������̻����ʹ��ֶΣ�����֧��ʧ��ʱ��ҳ����ת���̻���URL������������Ϣ������ת��
		//'frontFailUrl'=> '',//ʧ�ܽ���ǰ̨��ת��ַ--O
		//���ڸ���ף��̻���ѡ�������Ϣʱ�������� ������������Ԫ˵��
		//'instalTransInfo'=> '',//���ڸ�����Ϣ��--C
		//C���˺�����Ϊ02-����ʱ����д��ǰ̨�ཻ��ʱ��дĬ�����д��룬֧��ֱ����ת�������̻��������п���ϵͳӦ�𷵻�
		//'issInsCode'=> '',//������������--O
		//�ƶ�֧��ҵ����Ҫ����
		//'userMac'=> '',//�ն���Ϣ��--O
		//ǰ̨���ף���IP������Ҫ����̻�����
		//'customerIp'=> '',//�ֿ���IP--C
		//������ ������ʱ��д ����Ψһ��ʶ�󶨹�ϵ
		//'bindId'=> '',//�󶨱�ʶ��--O
		//�����������̻����׿����ã��������룩
		'payCardType'=> $card_info['card_type'],//֧��������--C
		//�п����ױ����п�������Ϣ��
		//'cardTransData'=> '',//�п�������Ϣ��--C
		//��������Ϊ����֧��ʱʹ��
		//'vpcTransData'=> '',//VPC������Ϣ��--C
		//�ƶ�֧������
		//'orderDesc'=> '',//��������--C

		//'tokenPayData'=> '',

	);



// ����ֶ��Ƿ���Ҫ����
encrypt_params ( $params );

// ǩ��
sign ( $params );

// ������Ϣ����̨
$result = sendHttpRequest ( $params, $SDK_BACK_TRANS_URL );

$result_array = coverStringToArray($result);

if ($result_array['respCode'] != '00') {
	die(json_encode(array(
			'status'=>-1,
			'message'=>'Error.',
			'error_resp_code'=>$result_array['respCode'],
			'error_resp_msg'=>iconv('gb2312', 'UTF-8', $result_array['respMsg'])
		)));
}

echo json_encode(array(
	'status'=>200,
	'message'=>'Success'
));


