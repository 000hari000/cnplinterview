<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blog_model extends CI_Model {
     function __construct() {
        parent::__construct();
    }
    public function blogTag($blogId){
        $col = 't.tagName,bt.bTagId,bt.tagId';
        $tbl="blog_tag bt";
        $joinArr=array(
            array(
                'tbl'=>'tag t',
                'con'=>'t.tagId = bt.tagId',
                'join'=>'LEFT'
            )
        );
        $where = "bt.blogId='".$blogId."'";
        $roleData = $this->mapi->get_data($col,$tbl,$joinArr,$where,'bt.bTagId');
        return $roleData;
    }
    public function getTag($arr){
        $col = 't.tagName,t.tagId,"00" as status';
        $tbl="tag t";
        $where = "t.tagId IS NOT NULL";
        if(isset($arr['tagName']) && $arr['tagName'] !=''){
            $where .=" AND tagName = '".$arr['tagName']."'";
        }
        $roleData = $this->mapi->get_data($col,$tbl,NULL,$where);
        return $roleData;
    }
    public function getBlog($searchData){
        $col = 'b.blogId,b.blogTitle,b.blogSubTitle,b.description,b.aDate,u.userName,GROUP_CONCAT(t.tagName ORDER BY bTagId) as tags';
        $tbl = 'blog b';
        $joinArr=array(
            array(
                'tbl'=>'user u',
                'con'=>'u.userId = b.userId',
                'join'=>'LEFT'
            ),
            array(
                'tbl'=>'blog_tag bt',
                'con'=>'bt.blogId = b.blogId',
                'join'=>'LEFT'
            ),
            array(
                'tbl'=>'tag t',
                'con'=>'t.tagId = bt.tagId',
                'join'=>'LEFT'
            )
        );
        $where = "b.status='0'";
        if(isset($searchData['blogId']) && $searchData['blogId'] !=''){
            $where .=" AND b.blogId = '".$searchData['blogId']."'";
        }
        if(isset($searchData['userId']) && $searchData['userId'] !=''){
            $where .=" AND b.userId = '".$searchData['userId']."'";
        }
        if(isset($searchData['tagsIds']) && count($searchData['tagsIds']) > 0){
            $searchData['tagsIds'] = implode(',',$searchData['tagsIds']);
            $where .=" AND bt.tagId IN ('".$searchData['tagsIds']."')";
        }
        
		$roleData = $this->mapi->get_data($col,$tbl,$joinArr,$where,'b.blogId','b.blogId','DESC');
        return $roleData;
    }
}
?>