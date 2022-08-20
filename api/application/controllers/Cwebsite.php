<?php
require APPPATH . 'libraries/REST_Controller.php';

class Cwebsite extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->model('Blog_model','blog');
       date_default_timezone_set('Asia/Kolkata');
    }
   public function getBlog_post(){
      $search = $this->_post_args['search'];
      $arr=array();$arr['tagsIds']=$search['selectedTag'];
      $res = $this->blog->getBlog($arr);
      
     
      if(count($res) > 0){
         $responseData =  $this->service->result_data('fetch','200',$res);
         $this->response($responseData, REST_Controller::HTTP_OK);
      }else{
         $responseData =  $this->service->result_data('fetch','201',NULL,'No data found');
         $this->response($responseData, REST_Controller::HTTP_OK);
      }
   }
}