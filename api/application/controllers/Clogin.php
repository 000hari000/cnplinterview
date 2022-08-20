<?php
require APPPATH . 'libraries/REST_Controller.php';

class Clogin extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Login_model','login');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
   public function doLogin_post(){
      $postData = $this->_post_args['loginData'];
      $arr=array();$arr['userEmail']=$postData['userEmail'];$arr['userPassword']=$postData['userPassword'];
      $res = $this->login->checkUser($arr);
      $err=0;$userData=array();
      if(count($res) == 1){
         $err++;
         $userData = $res[0];
         $userData['userId'] = $this->service->en_dy_crypt($userData['userId'],'encrypt');
      }
      if($err > 0){
         $responseData =  $this->service->result_data('auth',400,$userData,'Login Success!');
         $this->response($responseData, REST_Controller::HTTP_OK);
      }else{
         $responseData =  $this->service->result_data('auth',401,NULL,'Invalid Login!');
         $this->response($responseData, REST_Controller::HTTP_OK);
      }
   }
   public function validateEmail_post(){
      $email = $this->_post_args['email'];
      $arr=array();$arr['userEmail']=$email;
      $res = $this->login->checkUser($arr);
      $err=0;$userData=array();
      if(count($res) == 1){
         $err++;
         $userData = $res[0];
         $userData['userId'] = $this->service->en_dy_crypt($userData['userId'],'decrypt');
      }
      if($err == 0){
         $responseData =  $this->service->result_data('validate','200',NULL);
         $this->response($responseData, REST_Controller::HTTP_OK);
      }else{
         $responseData =  $this->service->result_data('validate','201',NULL,'Value already exist!');
         $this->response($responseData, REST_Controller::HTTP_OK); 
      }
   }
   public function registerUser_post(){
      $postData = $this->_post_args['registerData'];
      $email = $postData['userEmail'];
      $arr=array();$arr['userEmail']=$email;
      $res = $this->login->checkUser($arr);
      if(count($res) != 0){
         $responseData = $this->service->result_data('insert','201',NULL,'Email already exist!');
         $this->response($responseData, REST_Controller::HTTP_OK);
      }else{
         $arr=array();$arr['userEmail']=$postData['userEmail'];
         $arr['userName']=$postData['userName'];
         $arr['userPassword']=$postData['userPassword'];
         $this->db->insert('user',$arr);
         $userId = $this->db->insert_id();
         $arr['userId'] = $this->service->en_dy_crypt($userId,'encrypt');
         $responseData = $this->service->result_data('insert','200',$arr,'Thanks for registering with us!');
         $this->response($responseData, REST_Controller::HTTP_OK);
      }
   }
   
}