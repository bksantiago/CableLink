<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of agents
 *
 * @author Bk Santiago 
 */
class Archive extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("position_tb", "", TRUE);
        $this->load->model("city_tb", "", TRUE);
        $this->load->model("announcement_tb", "", TRUE);
        $this->load->model("contractor_city_tb", "cc_tb", TRUE);
        $this->load->model("contractor_schedule_tb", "cs_tb", TRUE);
        $this->load->model("schedule_day_tb", "s_day_tb", TRUE);
        $this->load->model("schedule_time_tb", "s_time_tb", TRUE);
        $this->load->library("session");
        
        //validate if Admin
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        }
        if(!$proceed){
            sendHome();
        }
    }
    
    function index(){
        sendHome();
    }

    function announcement_archive(){
        $body["announcements"] = $this->announcement_tb->getAll();
        $this->load->view("archive/announcement", $body);
    }
    
    function announcement_view($id){
        $body["announce"] = $this->announcement_tb->getById($id);
        $this->load->view("archive/announcement_view", $body);
    }
}
?>