<?php
	session_start();

	//TODO: 请实现以下函数
	//TODO: Please implement functions below

	//付款成功时会调用该函数，传入银联服务器端上送的POST数据
	//传入的POST数据已转换为数组，如可通过$callback_data['respCode']获取银联服务器端返回的应答号
	//注意：该函数由银联回调页调用，用户端的任何传入数据（SESSIONID、COOKIES等）均不可用，请将支付结果写入数据库
	//银联服务器端上送的POST数据格式请参考$CALLBACK_TEST_FILE（位于api/unionpay/func/SDKConfig.php）指向的文件（需完成一次测试支付生成该文件）
	
	//This function will be called when a payment succeeds. The passed $callback_data is the callback POST data from the Unionpay server.
	//The $callback_data is already encoded as PHP arrays. You can var_dump() this array to a file to see its structure.
	//Please be advised that this function is called within the Unionpay server callback session, where you cannot access any user-side data, such as $COOKIE or $SESSION.
	//You can save the callback result to the database.
	function pay_succeeded($callback_data) {
		$fp = fopen('../../../myfolder/files/last_succeeded_payment.txt', 'w+');
		fwrite($fp, json_encode($callback_data));
		fclose($fp);
	}

	//付款失败时会调用该函数，传入银联服务器端上送的POST数据
	//传入的POST数据已转换为数组，如可通过$callback_data['respCode']获取银联服务器端返回的应答号
	//注意：该函数由银联回调页调用，用户端的任何传入数据（SESSIONID、COOKIES等）均不可用，请将支付结果写入数据库
	
	//This function will be called when a payment fails. Parameters and notes are the same as pay_succeeded().
	function pay_failed($callback_data) {

	}

	//生成并返回订单号

	//Generate and return an order ID for each transaction.
	function gen_order_id() {
		$_SESSION['order_id'] = date('YmdHis').rand(100000,999999);
		return $_SESSION['order_id'];
	}

	//获取订单号

	//Get and return the order ID for the current transaction.
	function get_order_id() {
		return $_SESSION['order_id'];
	}

	//生成并返回交易时间, 格式为date('YmdHis')

	//Generate and return the current transaction time. Must follow this pattern: date('YmdHis')
	function gen_order_time() {
		$_SESSION['order_time'] = date('YmdHis');
		return $_SESSION['order_time'];
	}

	//获取交易时间

	//Get and return the current transaction time. Must be same as the generated one in gen_order_time() in the current transaction.
	function get_order_time() {
		return $_SESSION['order_time'];
	}

	//获取交易金额，以“分”为单位

	//Get and return the transaction amount in "Fen".
	function get_payment_amount() {
		return 100;
	}

	//生成并返回银联回调验证字符串
	//本机调用银联API时会传入该字符串，稍后银联服务端调用本机的支付结果回调页时会原样提交该字符串，通过验证两者是否相等，判断回调页调用者是否合法
	//银联SDK中签名验证功能尚有错误，故暂时不验签

	//Generate and return the validation string to validate the callback request sent by Unionpay server. Can be any string whatever you like.
	function gen_callback_reserved_string() {
		return 'hello';
	}

	//获取银联回调验证字符串
	//注意：该函数由银联回调页调用，用户端的任何传入数据（SESSIONID、COOKIES等）均不可用

	//Get the generated validation string. Should be same as the generated one in gen_callback_reserved_string().
	function get_callback_reserved_string() {
		return 'hello';
	}

	//获取支付结果
	//该函数应返回一个数组，数组包含以下字段：
	//'status' => 整数，支付结果。1:成功，0：支付尚未完成，-1：支付失败
	//'resp_msg' => 字符串，当支付失败时该字符串会返回到用户浏览器端JS

	//Get the transaction result.
	//Return an array in the following pattern:
	//'status' => integer. 1 for succeeded, 0 for unfinished, -1 for failed.
	//'resp_msg' => string. Will be passed to frontend JavaScript.
	function check_payment() {
		return array('status'=>1, 'resp_msg'=>'Success');
	}

?>
