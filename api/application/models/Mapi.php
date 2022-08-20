<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mapi extends CI_Model {
    public function custom_get_data($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function get_data_back($col = NULL,$table,$joinArr = NULL,$where = NULL,$group_by = NULL,$orderCol = NULL,$orderBy = NULL,$limitLength = NULL,$limitStart = NULL){
       
        if($col == NULL){  $col = '*';  } if($table == ''){  return array('error'=>'Table Name is must'); }
        $this->db->select($col); $this->db->from($table);
        if($joinArr != NULL){
            foreach($joinArr as $j){
                $this->db->join($j['tbl'],$j['con'],$j['join']);
            }
        }
       
        if($where != NULL){  
           // $this->db->protect_identifiers=false;
            $this->db->where($where); 
        } if($group_by != NULL){ $this->db->group_by($group_by); }
        if($orderCol != NULL){
            if($orderBy == NULL){
                $orderBy = 'desc';
            }
            $this->db->order_by($orderCol,$orderBy);
        }
       if($limitLength != NULL){
            $this->db->limit($limitLength,$limitStart);
        }
       
        $result = $this->db->get()->result_array();
        if(count($result) > 0){  return $result;  }else{  return array();  }
    }
    public function get_data($col = NULL,$table,$joinArr = NULL,$where = NULL,$group_by = NULL,$orderCol = NULL,$orderBy = NULL,$limitLength = NULL,$limitStart = NULL){
        if($col == NULL){  $col = '*';  } if($table == ''){  return array('error'=>'Table Name is must'); }
        $this->db->select($col); $this->db->from($table);
        if($joinArr != NULL){
            foreach($joinArr as $j){
                $this->db->join($j['tbl'],$j['con'],$j['join']);
            }
        }
        if($where != NULL){  $this->db->where($where); } if($group_by != NULL){ $this->db->group_by($group_by); }
        if($orderCol != NULL){
            if($orderBy == NULL){
                $orderBy = 'desc';
            }
            $this->db->order_by($orderCol,$orderBy);
        }
       if($limitLength != NULL){
            $this->db->limit($limitLength,$limitStart);
        }
        $result = $this->db->get()->result_array();
        if(count($result) > 0){  return $result;  }else{  return array();  }
    }
    public function delete_record($tbl,$col,$id){
        $data =array();$data['status']='2';
        $this->db->where($col,$id);
        $this->db->update($tbl,$data);
        return true;
    }
    public function delete_in_record($tbl,$col,$id){
        $data =array();$data['status']='2';
        $this->db->where_in($col,$id);
        $this->db->update($tbl,$data);
        return true;
    }
    public function insert_record($tbl,$data,$insertId=NULL){
        $this->db->insert($tbl,$data);
        if($insertId != NULL){
            return $this->db->insert_id();
        }else{
            return true;
        }
    }
    public function update_record($tbl,$where,$data){
        $this->db->where($where);
        $this->db->update($tbl,$data);
        return true;
    }
    public function store_message($title,$message,$time){
        $data = array();
        $data['title'] = $title;
        $data['message'] = $message;
        $data['notificationTime'] = $time;
        $this->db->insert('notification_message',$data);
    }
    public function validate_tbl($col,$tbl,$where){
        $res = $this->get_data($col,$tbl,NULL,$where);
        if(count($res) > 0){
            return true;
        }else{
            return false;
        }
    }
    public function validate_tbl_new($col,$tbl,$where){
        $res = $this->get_data($col,$tbl,NULL,$where);
        return $res;
    }
    public function get_ticket_id($branchId,$planId){
        $col="planCode,planId";$tbl="chit_plan";
        $where="planId='".$planId."'";
        $planData = $this->mapi->get_data($col,$tbl,NULL,$where);
        $t=0;
        if(count($planData) > 0){ $t++;
            $planCode = $planData[0]['planCode'];$planId = $planData[0]['planId'];
            $col="count(ticketId) as totTicket";$tbl="ticket";
            $where="branchId='".$branchId."' AND planId='".$planId."'";
            $tempCode = $this->mapi->get_data($col,$tbl,NULL,$where);
            $col="branchCode";$tbl="branch";
            $where="branchId='".$branchId."'";
            $branchData = $this->mapi->get_data($col,$tbl,NULL,$where)[0];
            //$brancCode = str_pad($branchId, 3, '0', STR_PAD_LEFT);
            $brancCode = $branchData['branchCode'];
            $brancCode =  preg_replace('/[^0-9]/', '', $brancCode);  
            $code = $planCode.'-'.$brancCode;
            if($tempCode[0]['totTicket'] == NULL || $tempCode[0]['totTicket'] == 0){
                $code .='-00001';
            }else{
                $cc = str_pad(($tempCode[0]['totTicket']+1), 4, '0', STR_PAD_LEFT);
                $code .='-'.$cc;
            }
            return array($code);
        }else{
            return array();
        }
       
    }
    public function get_pass_book_number($branchId){
        $col="count(ticketId) as totTick";$tbl="ticket";
        $where="ticketId IS NOT NULL"; $passData = $this->mapi->get_data($col,$tbl,NULL,$where);
        if($passData[0]['totTick'] == NULL || $passData[0]['totTick'] == '0'){
            $passsNo='00001';
        }else{
            $passsNo= str_pad(($passData[0]['totTick']+1), 4, '0', STR_PAD_LEFT);
        }
        return $passsNo;
    }
}
?>