<?php
/**
 * Created by PhpStorm.
 * User: Hitesh
 */ 
defined('BASEPATH') OR exit('No direct script access allowed');

class Zom extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->helper('string');
    }
    public function restaurants(){
      $secretKey = "0d00f11b7ba52f5817ef50477cf7a025";

      $url = "https://developers.zomato.com/api/v2.1/search?entity_id=4&entity_type=city";

      // append the header putting the secret key and hash

      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //print_r($request_headers);
      //exit(1);
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        }
        else
        {
        // Show me the result

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        print_r($transaction);
        exit(1);
        //var_dump($transaction['data']);
        }
    }
    public function login_view()
    {
        $this->load->view('zom/login_view');
    }
    public function signup_view()
    {
        $this->load->view('zom/signup_view');
    }
    public function check_login(){
        $data=array();
        $data['email']=$_POST['email'];
        $data['password']=sha1($_POST['password']);
        $this->load->Model('ZomModel');
        $sheet = $this->ZomModel->check_login($data);

        if($sheet['status']==TRUE){
            $user_id=$sheet['user_id'];
            $name=$sheet['name'];
            $this->session->set_userdata('user_id',$user_id);
            $this->session->set_userdata('name',$name);
            $this->session->set_userdata('cuisine',0);
            $this->session->set_userdata('type',0);
            $this->session->set_userdata('category',0);
            redirect(CTRL."Zom/restr");
        }
        else{
            redirect(CTRL."Zom/login_view/1");
        }
    }
    public function check_signup(){
        $data=array();
        $data['name']=$_POST['name'];
        $name=$data['name'];
        $data['email']=$_POST['email'];
        $data['password']=sha1($_POST['password']);
        $this->load->Model('ZomModel');
        $sheet = $this->ZomModel->check_signup($data);

        if($sheet['status']){
            $user_id=$sheet['user_id'];
            if($sheet['flag']==1)
                redirect(CTRL."Zom/signup_view/1");
            $this->session->set_userdata('user_id',$user_id);
            $this->session->set_userdata('name',$name);
            $this->session->set_userdata('cuisine',0);
            $this->session->set_userdata('type',0);
            $this->session->set_userdata('category',0);
            redirect(CTRL."Zom/restr");
        }
        else{
            redirect(CTRL."Zom/signup_view/1");
        }
    }

    public function search(){
        $this->session->set_userdata('cuisine',$_POST['cuisine']);
        $this->session->set_userdata('type',$_POST['type']);
        $this->session->set_userdata('category',$_POST['category']);
        redirect(CTRL."Zom/restr");
    }

    public function restr(){
        $secretKey = "0d00f11b7ba52f5817ef50477cf7a025";
        $result=array();
        $st="";
        if($_SESSION['cuisine']!=0)
            $st=$st."&cuisines=".$_SESSION['cuisine'];
        if($_SESSION['category']!=0)
            $st=$st."&category=".$_SESSION['category'];
        if($_SESSION['type']!=0)
            $st=$st."&establishment_type=".$_SESSION['type'];    
      $url = "https://developers.zomato.com/api/v2.1/search?entity_id=4&entity_type=city&count=50";
      $url=$url.$st;
        //print_r($url);exit();
      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //print_r($request_headers);
      //exit(1);
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        exit();
        }
        else
        {

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        
        $result['restaurant']=$transaction['restaurants'];
        //print_r($restaurant);
        //exit(1);
        //var_dump($transaction['data']);
        }

      $url = "https://developers.zomato.com/api/v2.1/cuisines?city_id=4";

      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //print_r($request_headers);
      //exit(1);
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        exit();
        }
        else
        {

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        $result['cuisines']=$transaction['cuisines'];
        //print_r($restaurant);
        //exit(1);
        //var_dump($transaction['data']);
        }

        $url = "https://developers.zomato.com/api/v2.1/categories";

      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //print_r($request_headers);
      //exit(1);
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        exit();
        }
        else
        {

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        $result['categories']=$transaction['categories'];
        //print_r($restaurant);
        //exit(1);
        //var_dump($transaction['data']);
        }

        $url = "https://developers.zomato.com/api/v2.1/establishments?city_id=4";

      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      //print_r($request_headers);
      //exit(1);
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        exit();
        }
        else
        {

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        $result['type']=$transaction['establishments'];
        //print_r($restaurant);
        //exit(1);
        //var_dump($transaction['data']);
        }

        $this->load->view('zom/restr',$result); 
    }

    public function restaurant($id){
        $secretKey = "0d00f11b7ba52f5817ef50477cf7a025";
        $result=array();
        $this->load->Model('ZomModel');
        $sheet = $this->ZomModel->restaurant($id);
        $result['reviewdata']=$sheet['reviewdata'];
        // print_r($result);
        // exit(1);

        

      $url = "https://developers.zomato.com/api/v2.1/restaurant?res_id=";
      $url=$url.$id;
        //print_r($url);exit();
      $request_headers = array();
      $request_headers[] = 'user-key: ' . $secretKey;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_TIMEOUT, 60);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      
      $data = curl_exec($ch);

      if (curl_errno($ch))
        {
        print "Error: " . curl_error($ch);
        exit();
        }
        else
        {

        $transaction = json_decode($data, TRUE);

        curl_close($ch);
        
        $result['restaurant']=$transaction;

        //print_r($result);
        //exit(1);
        //var_dump($transaction['data']);
        $this->load->view('zom/restaurant',$result); 

        }
    }

    public function logout(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('cuisine');
        $this->session->unset_userdata('type');
        $this->session->unset_userdata('category');
        $this->session->sess_destroy();
        redirect(CTRL);
    }

    public function post_review($id){
        $data=array();
        $data['rating']=$_POST['rating'];
        $data['review']=$_POST['review'];
        $data['user_id']=$_SESSION['user_id'];
        $data['restaurant_id']=$id;
        $this->load->Model('ZomModel');
        $sheet = $this->ZomModel->post_review($data);
        redirect(CTRL."Zom/restaurant/".$id);
    }
















    public function add_new_user(){
        $data=array();
        $data['name']=$_POST['name'];
        $data['address']=$_POST['address'];
        $data['email']=$_POST['email'];
        $data['phone']=$_POST['phone'];
        $data['password']=sha1($_POST['password']);
        $this->load->Model('AdminModel');
        $this->AdminModel->add_new_user($data);
        redirect(CTRL."Admin/admin_org_view");
    }
    public function admin_profile()
    {
        $admin_id=$_SESSION['admin_id'];
        $this->load->Model('AdminModel');
        $sheet=$this->AdminModel->admin_profile($admin_id);
        $this->load->view('admin/admin_profile',$sheet);
    }
    public function admin_org_view()
    {
        $this->load->Model('AdminModel');
        $sheet=$this->AdminModel->admin_org_view();
        $this->load->view('admin/admin_org_view',$sheet);
    }
    public function update_profile(){
        $data=array();
        $data['name']=$_POST['name'];
        $data['username']=$_POST['username'];
        $data['admin_id']=$_SESSION['admin_id'];
        $this->load->Model('AdminModel');
        $sheet=$this->AdminModel->update_profile($data);
        redirect(CTRL."Admin/admin_profile");
    }
    public function change_password(){
        $password=sha1($_POST['password']);
        $this->load->Model('AdminModel');
        $sheet=$this->AdminModel->change_password($password);
        redirect(CTRL."Admin/admin_profile");
    }
    public function admin_logout(){
        $this->session->unset_userdata('admin_id');
        $this->session->sess_destroy();
        redirect(CTRL."Admin/login_view");
    }
}
?>