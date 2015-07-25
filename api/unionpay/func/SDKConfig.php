<?php

$SDK_CVN2_ENC = 0;
// 有效期加密 1:加密 0:不加密
$SDK_DATE_ENC = 0;
// 卡号加密 1：加密 0:不加密
$SDK_PAN_ENC = 0;
 

 //TODO : 请编辑以下常量

// 签名证书路径
$SDK_SIGN_CERT_PATH = '../../../myfolder/cer/700000000000001_acp.pfx';

// 签名证书密码
$SDK_SIGN_CERT_PWD = '000000';
 
// 验签证书
$SDK_VERIFY_CERT_PATH = '../../../myfolder/cer/verify_sign_acp.cer';

// 密码加密证书
$SDK_ENCRYPT_CERT_PATH = '../../../myfolder/cer/verify_sign_acp.cer';

// 验签证书路径
$SDK_VERIFY_CERT_DIR = '../../../myfolder/cer';

// 前台请求地址
$SDK_FRONT_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/frontTransReq.do';

// 后台请求地址
$SDK_BACK_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/backTransReq.do ';

// 批量交易
$SDK_BATCH_TRANS_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do ';

//批量交易状态查询
$SDK_BATCH_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/batchTrans.do ';
//http://146.240.25.27:11000/ACP/api/queryTrans.do

//单笔查询请求地址
$SDK_SINGLE_QUERY_URL = 'https://101.231.204.80:5000/gateway/api/queryTrans.do';

//文件传输请求地址
$SDK_FILE_QUERY_URL = 'https://101.231.204.80:9080/ ';

// 前台通知地址
$SDK_FRONT_NOTIFY_URL = 'http://127.0.0.1/response.php';
// 后台通知地址
$SDK_BACK_NOTIFY_URL = 'http://chiontang.zyns.com:81/api/unionpay/callback.php';

//文件下载目录 
$SDK_FILE_DOWN_PATH = '../../../myfolder/files';

//日志 目录 
$SDK_LOG_FILE_PATH = '../../../myfolder/files/logs';

//日志级别
$SDK_LOG_LEVEL = 'INFO';

//有卡交易地址
$SDK_Card_Request_Url = '';

//App交易地址
$SDK_App_Request_Url = 'https://101.231.204.80:5000/gateway/api/appTransReq.do ';

//商户代码
$SDK_MER_ID = '305510170111001';

//RSA私钥地址（用于解密JS传入的加密数据）
$PRIVATE_KEY_PATH = '../../../myfolder/key/rsa_4096_priv.pem';

//RSA公钥地址（用于JS加密银行卡敏感信息）
$PUBLIC_KEY_PATH = '../../../myfolder/key/rsa_4096_pub.pem';

//回调测试文件
$CALLBACK_TEST_FILE = '../../../myfolder/files/last_callback_data.txt';

?>