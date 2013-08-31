<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tickets
 *
 * @author Bk Santiago 
 */
class Accounts extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("customer_tb", "", TRUE);
        $this->load->model("ticket_tb", "", TRUE);
        $this->load->model("ticket_assinged_tb", "ta_tb", TRUE);
        $this->load->model("contractor_city_tb", "c_city_tb", TRUE);
        $this->load->model("contractor_schedule_tb", "c_schedule_tb", TRUE);
        $this->load->model("dispatch_tb", "", TRUE);
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
    
    public function index(){
        $head["title"] = "Tickets Page";
        $header["user"] = $this->session->userdata("user");
        
        $body["n"] = $this->input->get("n");
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('admin/accounts', $body);
        $this->load->view('templates/footer');
    }

    public function ticket_list(){
        $body["tickets"] = $this->ticket_tb->getAll();
        $this->load->view("csr/tickets/ticket_list", $body);
    }
    
}

?>
