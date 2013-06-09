<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comment
 *
 * @author Bk Santiago 
 */
class Comment extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", '', TRUE);
        $this->load->library("session");
        
        //validate if login
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        }
        if(!$proceed){
            header("Location: " . base_url());
        }
    }
    
    public function save(){
        $data = array(
            "announcement_id" => $this->input->post("announcementId"),
            "comment" => $this->input->post("comment"),
            "created_date" => date("Y-m-d H:i:s"),
            "created_by" => $this->session->userdata("user")->id
        );
        
        $this->db->insert("comment_tb", $data);
        redirect("home");
    }
}

?>
