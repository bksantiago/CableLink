<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Account
 *
 * @author Bk Santiago 
 */
class Account extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("session");
    }
    
    public function index(){
        
    }
    
    public function logout(){
        $this->session->sess_destroy();
        header("location: " . base_url());
    }
}

?>