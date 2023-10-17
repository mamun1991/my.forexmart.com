<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Accountverification_model extends CI_Model
{	
	function __construct(){
		parent::__construct();

	}
        

    function show1st1w3($table,$field0="",$id0="",$field1="",$id1="",$field2="",$id2="",$select="",$order_by=""){
        $this->db->from($table);
        $this->db->where($field0, $id0);
        $this->db->where($field1, $id1);
        $this->db->where($field2, $id2);
        $data = $this->db->get();
        if($data->num_rows() > 0) {
            return $data->row_array();
        }else{
            return false;
        }
    }
    function checkUserDocs($user_id, $doc_type){
        $this->db->select('file_name');
        $this->db->from('user_documents');
        $passArray = array(
            'user_id' => $user_id,
            'doc_type' => $doc_type
        );
        $this->db->where($passArray);
        $this->db->limit(1);
        $this->db->order_by("date_uploaded", "desc");
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->row_array();
        }else{
            return false;
        }
    }



    function checkAdditionalDocs($user_id){
        $this->db->select(' doc_type, user_id');

        $this->db->select('SUBSTRING_INDEX(GROUP_CONCAT(file_name),TRIM(" , "),-1)AS file_name',FALSE);
        $this->db->from('user_documents');
        $passArray = array(
            'user_id' => $user_id
        );
        $this->db->where($passArray);
        $this->db->where('user_documents.doc_type >', 3);
        $this->db->group_by('doc_type');
        $this->db->order_by("doc_type", "asc");
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return $query->result_array();
        }else{
            return false;
        }
    }

 
    
   public function getUserDocDocumentsRow($user_id,$doc_type,$level){
       
       $sql="select * from user_documents where doc_type=? and `level`=? and user_id=? ORDER BY id DESC limit 1";       
        
        $query = $this->db->query($sql, array($doc_type,$level,$user_id));
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
       
   }
   
   
   
      public function getUserDocDocumentsDocTypeListLevel($user_id,$level){
       
       $sql="select DISTINCT(doc_type) doc_type from user_documents where user_id=? and level=? and doc_type not in(0,1) ORDER BY doc_type ASC";       
        
        $query = $this->db->query($sql, array($user_id,$level));
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
       
   }
   
    
   

    public function getUserDocumentsData($user_id){

       $level_one_doc_old_first= $this->getUserDocDocumentsRow($user_id,0,1);
       $level_one_doc_new_first= $this->getUserDocDocumentsRow($user_id,1,1);
               
       $level_one_first_documents="";
       
       
       
       if($level_one_doc_old_first) 
       { 
          $level_one_first_documents= $level_one_doc_old_first;
       }else{
            $level_one_first_documents= $level_one_doc_new_first; 
       }
       

       

      
       $level_one_doc_old_second= $this->getUserDocDocumentsRow($user_id,1,1);
       $level_one_doc_new_second= $this->getUserDocDocumentsRow($user_id,2,1);
               
       $level_one_second_documents="";
       if($level_one_doc_old_second) 
       {           
                if($level_one_first_documents->id==$level_one_doc_old_second->id)
                {
                    $level_one_second_documents= $level_one_doc_new_second; 
                }else{
                     $level_one_second_documents= $level_one_doc_old_second; 
                }
       }else{
           
                if($level_one_first_documents->id==$level_one_doc_new_second->id)
                {
                    $level_one_second_documents= $level_one_doc_old_second; 
                }else{
                     $level_one_second_documents= $level_one_doc_new_second; 
                }
           
       }
       
       
       
       

     
 
 
     $level_one_additional_documents=array();   
     
     $doc_distinct_data=$this->getUserDocDocumentsDocTypeListLevel($user_id,1);
    
     
     if($doc_distinct_data) 
     {
         foreach($doc_distinct_data as $key=>$val)
         {
           $ad_data= $this->getUserDocDocumentsRow($user_id,$val->doc_type,1);
           if($ad_data)
           {    
               $not_is_exist=true;
               
               if($level_one_first_documents)
               {
                   if($level_one_first_documents->id==$ad_data->id)
                   {
                      $not_is_exist=false; 
                   }    
               }
               
               if($level_one_second_documents)
               {
                   if($level_one_second_documents->id==$ad_data->id)
                   {
                      $not_is_exist=false; 
                   }    
               }
               
               if($not_is_exist)
               {
                  array_push($level_one_additional_documents,$ad_data); 
               }
            
            
            
           }
           
         }
     }
     
     
     
     

       
   /*---------------------------------------------($user_id,$doc_type,$level)----------------------------*/
       
     
     
               
//echo "<pre>";      
//print_r($level_one_first_documents);
//echo "2nd==============================================>";
//print_r($level_one_second_documents);
//exit;     
  
     
     
     
       $level_two_doc_old_first= $this->getUserDocDocumentsRow($user_id,2,2);
       $level_two_doc_new_first= $this->getUserDocDocumentsRow($user_id,1,2);
               
       $level_two_first_documents="";
       
       if($level_two_doc_new_first)
       {
            $level_two_first_documents= $level_two_doc_new_first; 
       }else{
            $level_two_first_documents= $level_two_doc_old_first;
       }
       
       
       
       
       
       
       
       
     $level_two_additional_documents=array();   
     
     $doc_distinct_data=$this->getUserDocDocumentsDocTypeListLevel($user_id,2);
     if($doc_distinct_data) 
     {
         foreach($doc_distinct_data as $key=>$val)
         {
           $ad_data= $this->getUserDocDocumentsRow($user_id,$val->doc_type,2);
           if($ad_data)
           {    
               
                $not_is_exist=true;
               
               if($level_two_first_documents)
               {
                   if($level_two_first_documents->id==$ad_data->id)
                   {
                      $not_is_exist=false; 
                   }    
               }
               
          
               if($not_is_exist)
               {
                  array_push($level_two_additional_documents,$ad_data);
               }
               
        
            
           }
           
         }
     }

     
     
     

$return_data=array(
    "level_one_first"=>$level_one_first_documents,
    "level_one_second"=>$level_one_second_documents,
    "level_one_additional"=>$level_one_additional_documents,
    "level_two_first"=>$level_two_first_documents, 
    "level_two_additional"=>$level_two_additional_documents,
    
);
     
 

 
return $return_data;

    }    


  


 

    


}