<?php
//header ( 'Content-type:text/html;charset=GBK' );
include_once 'SDKConfig.php';
include_once 'secureUtil.php';
include_once 'log.class.php';

// ��ʼ����־
$log = new PhpLog ( $SDK_LOG_FILE_PATH, "PRC", $SDK_LOG_LEVEL );
/**
 * �Կ��� | cvn2 | ���� | cvn2��Ч�ڽ��д���
 *
 * @param array $params        	
 */
function encrypt_params(&$params) {
	global $log, $SDK_PAN_ENC, $SDK_CVN2_ENC, $SDK_DATE_ENC;
	$log->LogInfo ( '------{�Կ��� | cvn2 | ���� | cvn2��Ч�ڽ��д���}��ʼ-----' );
	// ����
	$pan = isset ( $params ['accNo'] ) ? $params ['accNo'] : '';
	if (! empty ( $pan )) {
		if (1 == $SDK_PAN_ENC) {
			$cryptPan = encryptPan ( $pan );
			$params ['accNo'] = $cryptPan;
			$log->LogInfo ( "���ܺ󿨺�: {$cryptPan}" );
		}
	}
	
	// ֤������
	$customerInfo01 = isset ( $params ['customerInfo01'] ) ? $params ['customerInfo01'] : '';
	// ֤������
	$customerInfo02 = isset ( $params ['customerInfo02'] ) ? $params ['customerInfo02'] : '';
	// ����
	$customerInfo03 = isset ( $params ['customerInfo03'] ) ? $params ['customerInfo03'] : '';
	// �ֻ���
	$customerInfo04 = isset ( $params ['customerInfo04'] ) ? $params ['customerInfo04'] : '';
	// ������֤��
	$customerInfo05 = isset ( $params ['customerInfo05'] ) ? $params ['customerInfo05'] : '';
	// �ֿ�������
	$customerInfo06 = isset ( $params ['customerInfo06'] ) ? $params ['customerInfo06'] : '';
	// cvn2
	$customerInfo07 = isset ( $params ['customerInfo07'] ) ? $params ['customerInfo07'] : '';
	// ��Ч��
	$customerInfo08 = isset ( $params ['customerInfo08'] ) ? $params ['customerInfo08'] : '';
	
	// ȥ�������Ϣ��
	for($i = 1; $i <= 8; $i ++) {
		if (isset ( $params ['customerInfo0' . $i] )) {
			unset ( $params ['customerInfo0' . $i] );
		}
	}
	
	// ��������ǿ����˳�
	if (empty ( $customerInfo01 ) && empty ( $customerInfo02 ) && empty ( $customerInfo03 ) && empty ( $customerInfo04 ) && empty ( $customerInfo05 ) && empty ( $customerInfo06 ) && empty ( $customerInfo07 ) && isset ( $customerInfo08 )) {
		$log->LogInfo ( "---------�����Ϣ������ȫΪ���˳�-------" );
		return (- 1);
	}
	
	// �ֿ��������Ϣ --֤������|֤������|����|�ֻ���|������֤��|�ֿ�������|CVN2|��Ч��
	$customer_info = '{';
	$customer_info .= $customerInfo01 . '&';
	$customer_info .= $customerInfo02 . '&';
	$customer_info .= $customerInfo03 . '&';
	$customer_info .= $customerInfo04 . '&';
	$customer_info .= $customerInfo05 . '&';
	
	if (! empty ( $customerInfo06 )) {
		if (! empty ( $pan )) {
			$encrypt_pin = encryptPin ( $pan, $customerInfo06 );
			$customer_info .= $encrypt_pin . '&';
		} else {
			$customer_info .= $customerInfo06 . '&';
		}
	} else {
		$customer_info .= '&';
	}
	
	if (! empty ( $customerInfo07 )) {
		if (1 == $SDK_CVN2_ENC) {
			$cvn2 = encryptCvn2 ( $customerInfo07 );
			$customer_info .= $cvn2 . '&';
		} else {
			$customer_info .= $customerInfo07 . '&';
		}
	} else {
		$customer_info .= '&';
	}
	
	if (! empty ( $customerInfo08 )) {
		if (1 == $SDK_DATE_ENC) {
			$certDate = encryptDate ( $customerInfo08 );
			$customer_info .= $cvn2;
		} else {
			$customer_info .= $customerInfo08;
		}
	}
	
	$customer_info .= '}';
	
	$log->LogInfo ( 'customerInfo ����Ϣ :>' . $customer_info );
	
	$customerInfoBase64 = base64_encode ( $customer_info );
	$params ['customerInfo'] = $customerInfoBase64;
	$log->LogInfo ( 
			'---------{�Կ��� & cvn2 & ���� & cvn2��Ч�ڽ��д���}����--------' . $customerInfoBase64 );
}

function customerInfo($pan, $certifTp, $certifId, $customerNm, $phoneNo, $smsCode, $pin, $cvn2, $expired)
{
	$customer_info = '{';
	$customer_info = $customer_info.'certifTp='.$certifTp. '&';
	$customer_info = $customer_info.'certifId='.$certifId. '&';
	$customer_info = $customer_info.'customerNm='.$customerNm. '&';
	$customer_info = $customer_info.'phoneNo='.$phoneNo. '&';
	$customer_info = $customer_info.'smsCode='.$smsCode. '&';

	$encrypted_cvn = encryptCvn2($cvn2);
	$encrypted_expired = encryptDate($expired);
	$encrypted_pin = encryptPin($pan, $pin);
	$customer_info .= 'pin='.$encrypted_pin;

	if ($cvn2 != '')
		$customer_info .= '&cvn2='.$cvn2;

	if ($expired != '')
		$customer_info .= '&expired='.$expired;

	$customer_info .= '}';
	
	$customerInfoBase64 = base64_encode ( $customer_info );

	return $customerInfoBase64;


}

function customerInfo_sms($pan, $certifTp, $certifId, $customerNm, $phoneNo, $pin, $cvn2, $expired)
{
	$customer_info = '{';
	$customer_info = $customer_info.'certifTp='.$certifTp. '&';
	$customer_info = $customer_info.'certifId='.$certifId. '&';
	$customer_info = $customer_info.'customerNm='.$customerNm. '&';
	$customer_info = $customer_info.'phoneNo='.$phoneNo. '&';
	//$customer_info = $customer_info.'smsCode='.$smsCode. '&';

	$encrypted_cvn = encryptCvn2($cvn2);
	$encrypted_expired = encryptDate($expired);
	$encrypted_pin = encryptPin($pan, $pin);
	$customer_info .= 'pin='.$encrypted_pin;

	if ($cvn2 != '')
		$customer_info .= '&cvn2='.$cvn2;

	if ($expired != '')
		$customer_info .= '&expired='.$expired;

	$customer_info .= '}';
	
	$customerInfoBase64 = base64_encode ( $customer_info );

	return $customerInfoBase64;
}

?>