<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profile
 *
 * @author Bk Santiago 
 */
class Profile extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("ticket_tb", "", TRUE);
        $this->load->model("contractor_city_tb", "cc_tb", TRUE);
        $this->load->model("contractor_schedule_tb", "cs_tb", TRUE);
        $this->load->library("session");
        
        //validate if Login
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        } else {
            sendHome();
        }
    }
    
    public function index(){
        $user = $this->user_tb->getById($this->input->get("id"));
        $head["title"] = $user->firstName . "'s Profile";
        $header["user"] = $this->session->userdata("user");
        $body["user"] = $user;
        $body["assigned"] = $this->ticket_tb->getAssigned($user->id);
        
        if($user->id == $this->session->userdata("user")->id){
            $body["myProfile"] = 1;
        }

        if($user->positionTb->id == 5){
            $body["cities"] = $this->cc_tb->getByUserId($user->id);
            $body["schedules"] = $this->cs_tb->getByUserId($user->id);
            //$body["scheduleNum"] = convertToNumericalSchedule($this->cs_tb->getByUserId($user->id));
        }
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        
        if($user->id != ""){
            $this->load->view('profile', $body);
        } else {
            $this->load->view('errors/not_found');
        }
        
        $this->load->view('templates/footer');
    }
    
    public function upload(){
        $dir = './uploads/';
        $config['upload_path'] = $dir;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']    = '2048'; //2 mb
        $config['overwrite']    = true; //2 mb
        
        $this->load->library('upload', $config);
        
        
        if(!$this->upload->do_upload("file")){
            $error = array('error' => $this->upload->display_errors());
            foreach($error as $a){
                echo $a;
            }
        } else {
            $upload_data = $this->upload->data();
            
            $id = $this->session->userdata("user")->id;
            rename($dir . $upload_data["file_name"], $dir . $id . '.jpg');
            
            redirect("/Profile?id=" . $id, "refresh");
        }
    }
}

?>
