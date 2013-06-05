<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ajax
 *
 * @author Bk Santiago 
 */
class Ajax extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
    }
    
    public function index(){}
        
    public function validateUsername(){
        $username = $this->input->get("username");
        $exist = $this->user_tb->usernameExist($username);
        echo $exist;
    }
}

?>
