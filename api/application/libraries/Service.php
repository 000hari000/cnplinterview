<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service {
	private $_CI;
    public function __construct(){
        $this->_CI = & get_instance();
    }
    public function en_dy_crypt($value,$action){
		//Encryption        
		$encrypt_method = "AES-256-CBC";
		$secret_key = 'hari';
		$secret_iv = 'h@r!';
		// hash
		$key = hash('sha256', $secret_key);     
		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);
		if ( $action == 'encrypt' ) {
			$output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		} else if( $action == 'decrypt' ) {
			$output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);
		}
		return $output;
	}
	function result_data($type,$code,$data=NULL,$message=NULL){
		$res = array();
		$res['response'] = array();
		$res['response']['code'] = $code;
		if($data != NULL){
		   $res['response']['data'] = $data;
		}
		if($message != NULL){
		   $res['response']['message'] = $message;
		}
		return $res;
	 }	
}