<?php
	include_once('./func/SDKConfig.php');
	include_once('./func/common.php');
	include_once('./custom_func.php');

	$f = fopen($CALLBACK_TEST_FILE,'w+');
	fwrite($f, file_get_contents('php://input'));
	fclose($f);

	$post_data = coverStringToArray(file_get_contents('php://input'));

	if ($post_data['reqReserved'] != get_callback_reserved_string()) {
		die('Authentication failed!');
	}

	if ($post_data['txnType'] == '01' && $post_data['txnSubType'] == '01') {
		if ($post_data['respCode'] == '00') {
			pay_succeeded($post_data);
		} else {
			pay_failed($post_data);
		}
	}

	echo file_get_contents('php://input');
?>