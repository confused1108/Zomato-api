<?php
/**
 * Created by PhpStorm.
 * User: Hitesh
 * Date: 24-Sep-18
 * Time: 1:09 AM
 */

Class ZomModel extends CI_Model
{
    Public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public function check_login($data)
    { 
        $email = $data['email']; 
        $password = $data['password'];
        $result = array();
        $sql = "SELECT user_id,name from user where email='$email' AND password='$password'";
        //print_r($sql);
        //exit(1);
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$query->result_array();
            $result['user_id']=$data[0]['user_id'];
            $result['name']=$data[0]['name'];
            $result['status'] = true;
        }
        else{
            $result['status']=false;
        }
        return $result;
    }

    public function restaurant($id)
    { 
        $result = array();
        $sql = "SELECT * from reviews,user where restaurant_id='$id' AND reviews.user_id=user.user_id";
        $query = $this->db->query($sql);
        $result['reviewdata']=$query->result_array();
        return $result;
    }

    public function check_signup($data){
        $email=$data['email'];
        $result=array();
        $result['flag']=0;
        $sql = "SELECT user_id from user where email='$email'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
          $result['flag']=1;
          $result['status'] = true;
          return $result;  
        }
        $query=$this->db->insert('user',$data);
        //print_r($query);
        //exit(1);
        if($query){
            $result['status'] = true;
            $sql = "SELECT user_id,name from user where email='$email'";
        //print_r($sql);
        //exit(1);
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $data=$query->result_array();
            $result['user_id']=$data[0]['user_id'];
            $result['name']=$data[0]['name'];
        }
        else{
            $result['status']=false;
        }
        }
        else{
            $result['status'] = false;
        }
        return $result;
    }

    public function post_review($data){
        $query=$this->db->insert('reviews',$data);
        //print_r($query);
        //exit(1);
        $result=array();
        if($query){
            $result['status'] = true;
        }
        else{
            $result['status'] = false;
        }
        return $result;
    }
}
?>