<?php

$SDK_CVN2_ENC = 0;
// ��Ч�ڼ��� 1:���� 0:������
$SDK_DATE_ENC = 0;
// ���ż��� 1������ 0:������
$SDK_PAN_ENC = 0;
 

 //TODO : ��༭���³���

// ǩ��֤��·��
$SDK_SIGN_CERT_PATH = '../../../myfolder/cer/700000000000001_acp.pfx';

// ǩ��֤������
$SDK_SIGN_CERT_PWD = '000000';
 
// ��ǩ֤��
$SDK_VERIFY_CERT_PATH = '../../../myfolder/cer/verify_sign_acp.cer';

// �������֤��
$SDK_ENCRYPT_CERT_PATH = '../../../myfolder/cer/verify_sign_acp.cer';

// ��ǩ֤��·��
$SDK_VERIFY_CERT_DIR = '../../../myfolder/cer';

// ǰ̨�����ַ
$SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';

// ��̨�����ַ
$SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do ';

// ��������
$SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do ';

//��������״̬��ѯ
$SDK_BATCH_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do ';
//http://146.240.25.27:11000/ACP/api/queryTrans.do

//���ʲ�ѯ�����ַ
$SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';

//�ļ����������ַ
$SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/ ';

// ǰ̨֪ͨ��ַ
$SDK_FRONT_NOTIFY_URL = 'http://127.0.0.1/response.php';
// ��̨֪ͨ��ַ
$SDK_BACK_NOTIFY_URL = 'http://chiontang.zyns.com:81/api/unionpay/callback.php';

//�ļ�����Ŀ¼ 
$SDK_FILE_DOWN_PATH = '../../../myfolder/files';

//��־ Ŀ¼ 
$SDK_LOG_FILE_PATH = '../../../myfolder/files/logs';

//��־����
$SDK_LOG_LEVEL = 'INFO';

//�п����׵�ַ
$SDK_Card_Request_Url = '';

//App���׵�ַ
$SDK_App_Request_Url = 'https://101.231.204.80:5000/gateway/api/appTransReq.do ';

//�̻�����
$SDK_MER_ID = '305510170111001';

//RSA˽Կ��ַ�����ڽ���JS����ļ������ݣ�
$PRIVATE_KEY_PATH = '../../../myfolder/key/rsa_4096_priv.pem';

//RSA��Կ��ַ������JS�������п�������Ϣ��
$PUBLIC_KEY_PATH = '../../../myfolder/key/rsa_4096_pub.pem';

//�ص������ļ�
$CALLBACK_TEST_FILE = '../../../myfolder/files/last_callback_data.txt';

?>