<?php
	include_once('./custom_func.php');

	header ( 'Content-type: application/json;charset=UTF-8' );


	$check_result = check_payment();

	if ($check_result['status'] == 1)
		echo json_encode(array('status'=>200,'message'=>'Success.'));
	elseif ($check_result['status'] == 0) 
		echo json_encode(array('status'=>0,'message'=>'Payment in progress.'));
	else
		echo json_encode(array('status'=>-1,'message'=>'Payment Failed.', 'error'=>$check_result['resp_msg']));

?>
