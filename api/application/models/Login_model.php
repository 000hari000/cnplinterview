<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    public function checkUser($searchData){
        $col = 'userId,userEmail,userName,userPassword';
        $tbl = 'user';
        if(isset($searchData['userId']) && $searchData['userId'] !=''){
            $where =" userId = '".$searchData['userId']."'";
        }
        if(isset($searchData['userEmail']) && $searchData['userEmail'] !='' && isset($searchData['userPassword']) && $searchData['userPassword'] !=''){
            $where =" userEmail = '".$searchData['userEmail']."' AND userPassword='".$searchData['userPassword']."'";
        }else{
            if(isset($searchData['userEmail']) && $searchData['userEmail'] !=''){
                $where =" userEmail = '".$searchData['userEmail']."'";
            }
        }

		$roleData = $this->mapi->get_data($col,$tbl,NULL,$where);
        return $roleData;
    }
}
?>