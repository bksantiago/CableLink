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
class Agents extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("position_tb", "", TRUE);
        $this->load->model("announcement_tb", "", TRUE);
        $this->load->library("session");
        
        //validate if Admin
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            if($user->id == 1){
                $proceed = true;
            }
        }
        if(!$proceed){
            sendHome();
        }
    }
    
    function index(){
        $head["title"] = "Agent Page";
        $header["user"] = $this->session->userdata("user");
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('admin/agents');
        $this->load->view('templates/footer');
    }
    
    function agent_list(){
        $body["agents"] = $this->user_tb->getAll();
        $this->load->view("admin/agents/agent_list", $body);
    }
    function agent_registration(){
        $body["positions"] = $this->position_tb->getAllPositions();
        $this->load->view("admin/agents/agent_registration", $body);
    }
    
    function announcement(){
        $body["announcement"] = $this->announcement_tb->get();
        $this->load->view("admin/agents/agent_announcement", $body);
    }
    
    function announcement_save(){
        $data = array(
            'header' => $this->input->post("header"),
            'information' => $this->input->post("information"),
            'created_date' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata("user")->id
        );
        $this->db->insert("announcement_tb", $data);
        echo "save;top";
    }
    
    function save(){
        $data = array(
            'id' => "",
            'username' => $this->input->post("username"),
            'password' => md5($this->input->post("password")),
            'first_name'=> $this->input->post("firstname"),
            'middle_name'=> $this->input->post("middlename"),
            'last_name'=> $this->input->post("lastname"),
            'email'=> $this->input->post("email"),
            'contact_no'=> $this->input->post("contact"),
            'position'=> $this->input->post("position"),
        );
        $this->db->insert("users_tb", $data);
        echo "save;top";
    }
    
    function contractors(){
        $body["contractors"] = $this->user_tb->getContractors();
        $this->load->view("admin/agents/agent_contractors", $body);
    }
}
?>