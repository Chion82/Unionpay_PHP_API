var rsa_cer_url = '/api/unionpay/pubkey/rsa_4096_pub.pem';


var Unionpay = {

	/*
		Check if the Unionpay account supports online payment.

		acc_type: 01
		acc_no: card number
		callback: callback function to which the result object will be passed
	*/
	check_account : function(acc_type, acc_no, callback) {
		var card_info = {
			acc_type : acc_type,
			acc_no : acc_no
		};
		Unionpay.__encrypt_post_data(JSON.stringify(card_info), function(encrypted_card_info){
			var post_fields = {
				card_info : encrypted_card_info
			};
			$.post('/api/unionpay/check_account.php', post_fields, function(data){
				callback(data);
			});
		});
	},

	/*
		Activate Unionpay online payment.

		acc_type: 01
		acc_no: card number
		certif_tp : 01：身份证
					02：军官证
					03：护照
					04：回乡证
					05：台胞证
					06：警官证
					07：士兵证
					99：其它证件
		certif_id : 证件号码
		customer_name : 持卡人姓名
		phone_no : 手机号
		pin : 持卡人密码
		cvn2 : CVN2 借记卡则为空字符串
		expired : 有效期 借记卡则为空字符串
		redirect_url : 开通在线支付后，浏览器的跳转地址
	*/
	activate : function(acc_type, acc_no, certif_tp, certif_id, customer_name, phone_no, pin, cvn2, expired, redirect_url) {
		var card_info = {
			acc_type : acc_type,
			acc_no : acc_no,
			certif_tp : certif_tp,
			certif_id : certif_id,
			customer_name : customer_name,
			phone_no : phone_no,
			pin : pin,
			cvn2 : cvn2,
			expired : expired
		};
		Unionpay.__encrypt_post_data(JSON.stringify(card_info), function(encrypted_card_info){
			window.location.href = '/api/unionpay/activate.php?redirect_url=' + encodeURIComponent(redirect_url) + '&card_info=' + encodeURIComponent(encrypted_card_info);
			
		});		
	},

	/*
		Send payment sms to customer.

		acc_type: 01
		acc_no: card number
		certif_tp : 01：身份证
					02：军官证
					03：护照
					04：回乡证
					05：台胞证
					06：警官证
					07：士兵证
					99：其它证件
		certif_id : 证件号码
		customer_name : 持卡人姓名
		phone_no : 手机号
		pin : 持卡人密码
		cvn2 : CVN2 借记卡则为空字符串
		expired : 有效期 借记卡则为空字符串
		callback: callback function to which the result object will be passed
	*/
	send_payment_sms : function(acc_type, acc_no, certif_tp, certif_id, customer_name, phone_no, pin, cvn2, expired, callback) {
		var card_info = {
			acc_type : acc_type,
			acc_no : acc_no,
			certif_tp : certif_tp,
			certif_id : certif_id,
			customer_name : customer_name,
			phone_no : phone_no,
			pin : pin,
			cvn2 : cvn2,
			expired : expired
		};
		Unionpay.__encrypt_post_data(JSON.stringify(card_info), function(encrypted_card_info){
			var post_fields = {
				card_info : encrypted_card_info
			};
			$.post('/api/unionpay/send_sms.php', post_fields, function(data){
				callback(data);
			});
		});
	},

	/*
		Initiate a payment.

		acc_type: 01
		acc_no: card number
		card_type : 01(Debit card), 02(credit card)
		certif_tp : 01：身份证
					02：军官证
					03：护照
					04：回乡证
					05：台胞证
					06：警官证
					07：士兵证
					99：其它证件
		certif_id : 证件号码
		customer_name : 持卡人姓名
		phone_no : 手机号
		sms_code : 短信验证码
		pin : 持卡人密码
		cvn2 : CVN2 借记卡则为空字符串
		expired : 有效期 借记卡则为空字符串
		callback: callback function to which the result object will be passed
	*/
	pay : function(acc_type, acc_no, card_type, certif_tp, certif_id, customer_name, phone_no, sms_code, pin, cvn2, expired, callback) {
		var card_info = {
			acc_type : acc_type,
			acc_no : acc_no,
			card_type : card_type,
			certif_tp : certif_tp,
			certif_id : certif_id,
			customer_name : customer_name,
			phone_no : phone_no,
			sms_code : sms_code,
			pin : pin,
			cvn2 : cvn2,
			expired : expired
		};
		Unionpay.__encrypt_post_data(JSON.stringify(card_info), function(encrypted_card_info){
			var post_fields = {
				card_info : encrypted_card_info
			};
			$.post('/api/unionpay/pay.php', post_fields, function(data){
				callback(data);
			});
		});
	},

	/*
		Check if order succeeded.

		callback: callback function to which the result object will be passed
	*/
	check_order : function(callback) {
		$.get('/api/unionpay/check_order.php', function(data){
			callback(data);
		});
	},

	__encrypt_post_data : function(post_data, callback) {
		$.get(rsa_cer_url, function(public_key) {
			var encrypt = new JSEncrypt();
			encrypt.setPublicKey(public_key);
			var encrypted = encrypt.encrypt(post_data);
			callback(encrypted);
		});
	},

};
