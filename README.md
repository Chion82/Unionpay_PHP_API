#Unionpay PHP API

##Introduction

Unionpay PHP API is a simple and easy-to-use interface to implement web-based Unionpay online payment modules written in PHP. This project includes PHP logics and front-end JavaScript API.

Author: Chion82 <sdspeedonion@gmail.com>

##Feature

* Say good-bye to the fucking super-complex Unionpay documentation which also contains errors.

* Many bugs in the official Unionpay online payment SDK have been fixed.

* All sensitive data from the client such as bank card number and password will be RSA-encrypted by JS API in case http packages are captured by hackers.

##Usage

* Follow the comments and implement functions at ```api/unionpay/custom_func.php``` .

* Configurate the Unionpay online payment parameters by modifying the constants located at ```api/unionpay/func/SDKConfig.php``` .

* Upload all files to the root directory of your web project and test your configurations by browsing ```/test.php``` .

* Checkout the commented out JavaScript demo code at ```/test.php``` and test those demo API calls using your browser console. The callback data of each JS API will be alerted.

* By now you have knowledges of how the callback data of the JS APIs located at ```js/unionpay_lib.js``` looks like, just import this JS lib and write your own front-end payment code. All input parameters of those JS APIs can be found at ```js/unionpay_lib.js``` as comments.

##Changelog

* Change all constants at ```api/unionpay/func/SDKConfig.php``` to global variables in case the PHP version on the server is too low.
