<?php
require APPPATH . 'libraries/REST_Controller.php';

class Cblog extends REST_Controller {
	  /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->database();
       $this->load->model('Blog_model','blog');
       date_default_timezone_set('Asia/Kolkata');
    }
    public function saveBlog_post(){
        $blogData = $this->_post_args['blogData'];
        $up=array();
        $up['blogTitle']=$blogData['blogTitle'];
        $up['blogSubTitle']=$blogData['blogSubTitle'];
        $up['description']=$blogData['description'];
        $up['aDate']=date('Y-m-d H:i:s');
        if($blogData['blogId'] == 0){
            $up['userId']=$this->user_id;
            $this->db->insert('blog',$up);
            $bId = $this->db->insert_id();
            $msg = 'Blog added successfully!';
        }else{
            $bId =$blogData['blogId'];
            $this->db->where('blogId',$blogData['blogId']);
            $this->db->update('blog',$up);
            $this->db->where('blogId',$blogData['blogId']);
            $this->db->delete('blog_tag');
            $msg = 'Blog updated successfully!';
        }
        $bulkIns = array();
        $tags = $blogData['tags'];$tagsArr = explode(',',$tags);
        if(count($tagsArr) > 0){
            foreach($tagsArr as $t){
                $arr=array();$arr['tagName']=$t;
                $res = $this->blog->getTag($arr);
                if(count($res) > 0){
                    $tagId = $res[0]['tagId'];
                }else{
                    $up=array();$up['tagName']=$t;
                    $this->db->insert('tag',$up);
                    $tagId =$this->db->insert_id();
                }
                $up=array();
                $up['blogId']=$bId; $up['tagId']=$tagId;$bulkIns[] = $up;
            }
        }
        if(count($bulkIns) > 0){
            $this->db->insert_batch('blog_tag',$bulkIns);
        }
        $responseData = $this->service->result_data('insert','200',NULL,$msg);
        $this->response($responseData, REST_Controller::HTTP_OK);
    }
    public function getBlog_post(){
        $arr=array();
        $arr['userId']=$this->user_id;
        $res = $this->blog->getBlog($arr);
        if(count($res) > 0){
            $responseData =  $this->service->result_data('fetch','200',$res);
            $this->response($responseData, REST_Controller::HTTP_OK);
        }else{
            $responseData =  $this->service->result_data('fetch','201',NULL,'No data found');
            $this->response($responseData, REST_Controller::HTTP_OK);
        }
    }
    public function getTag_post(){
        $arr=array();
        $res = $this->blog->getTag($arr);
        if(count($res) > 0){
            $responseData =  $this->service->result_data('fetch','200',$res);
            $this->response($responseData, REST_Controller::HTTP_OK);
        }else{
            $responseData =  $this->service->result_data('fetch','201',NULL,'No data found');
            $this->response($responseData, REST_Controller::HTTP_OK);
        }
    }
    public function getBlogById_post(){
        $blogId = $this->_post_args['blogId'];
        $arr=array();
        $arr['blogId']=$blogId;
        $res = $this->blog->getBlog($arr);
        if(count($res) > 0){
            $blogData = $res[0];
            $blogData['tags']=$this->blog->blogTag($blogId);
            $responseData =  $this->service->result_data('fetch','200',$blogData);
            $this->response($responseData, REST_Controller::HTTP_OK);
        }else{
            $responseData =  $this->service->result_data('fetch','201',NULL,'No data found');
            $this->response($responseData, REST_Controller::HTTP_OK);
        }
    }
    public function deleteById_post(){
        $blogId = $this->_post_args['blogId'];
        $this->db->where('blogId',$blogId);
        $this->db->delete('blog_tag');
        $this->db->where('blogId',$blogId);
        $this->db->delete('blog');
        $responseData =  $this->service->result_data('insert','200',NULL,'No data found');
        $this->response($responseData, REST_Controller::HTTP_OK);
    }
}