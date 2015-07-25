<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="js/jsencrypt.min.js"></script>
<script type="text/javascript" src="js/unionpay_lib.js"></script>

<script>
	Unionpay.check_account('01','6216261000000000018', function(data){
		alert(JSON.stringify(data));
	});
	
	/*
	Unionpay.activate('01', '6221558812340000', '01', '341126197709218366', '互联网', '13552535506', '123456', '123', '1711', 'http://www.baidu.com');

	Unionpay.send_payment_sms('01', '6221558812340000', '01', '341126197709218366', '互联网', '13552535506', '123456', '123', '1711', function(data){
		alert(JSON.stringify(data));
	});

	Unionpay.pay('01', '6221558812340000', '02', '01', '341126197709218366', '互联网', '13552535506', '111111', '123456', '123', '1711', function(data){
		alert(JSON.stringify(data));
	});	

	Unionpay.check_order(function(data){
		alert(JSON.stringify(data));
	});*/


</script>
