<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author Bk Santiago 
 */
class Home extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("announcement_tb", "", TRUE);
        $this->load->helper("url");
        $this->load->library("session");
        
        //validate if Logged in
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        }
        if(!$proceed){
            header("Location: " . base_url());
        }
    }
    
    function index(){
        $head["title"] = "Home Page"; 
        $header["user"] = $this->session->userdata("user");
        $body["announce"] = $this->announcement_tb->get();
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('home', $body);
        $this->load->view('templates/footer');
    }
    
}

?>
