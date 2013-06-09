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
class Tickets extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("customer_tb", "", TRUE);
        $this->load->model("ticket_tb", "", TRUE);
        $this->load->model("ticket_assinged_tb", "ta_tb", TRUE);
        $this->load->library("session");
        
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        } else {
            sendHome();
        }
    }
    
    public function index(){
        $head["title"] = "Tickets Page";
        $header["user"] = $this->session->userdata("user");
        
        $body["n"] = $this->input->get("n");
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('csr/tickets', $body);
        $this->load->view('templates/footer');
    }
    
    public function create(){
        $body = "";
        if($this->input->get("search") != ""){
            $body["customer"] = $this->customer_tb->getById($this->input->get("search"));
            if(empty($body["customer"])){
                $body["error"] = 1;
            }
        }
        $this->load->view("csr/tickets/ticket_create", $body);
    }
    public function submit(){
        $data = array(
            'account_no' => $this->input->get("accountno"),
            'assigned_to' => $this->session->userdata("user")->id,
            'date_start' => date("Y-m-d H:i:s")
        );
        $body["ticket"] = $this->ticket_tb->save($data);
        $body["customer"] = $body["ticket"]->accountTb;
        $this->load->view("csr/tickets/ticket_create", $body);
    }
    
    public function ticket_list(){
        $body["tickets"] = $this->ticket_tb->getAll();
        $this->load->view("csr/tickets/ticket_list", $body);
    }
    
    public function assigned(){
        $body["tickets"] = $this->ticket_tb->getAssigned($this->session->userdata("user")->id);
        $this->load->view("csr/tickets/ticket_assigned", $body);
    }
    
    public function view($id){
        $body["ticket"] = $this->ticket_tb->getById($id);
        $body["customer"] = $body["ticket"]->accountTb;
        
        if($body["ticket"]->assignedTb->id != $this->session->userdata("user")->id){ $body["view"] = 1;}
        
        $this->load->view("csr/tickets/ticket_create", $body);
    }
    
    public function saveNotes(){
        $ticketId = $this->input->post("id");
        $data = array('remarks' => $this->input->post("notes"));
        $this->ta_tb->updateByTicketAndAssignedId($ticketId, $this->session->userdata("user")->id, $data);
        echo "ok";
    }
    
    public function resolve($ticketId){
        $data = array(
            'date_end' => date("Y-m-d H:i:s")
        );
        $this->ticket_tb->resolve($ticketId, $this->session->userdata("user")->id,$data);
        msgRedirect("Ticket Successfully Resolve", base_url() . "Tickets");
    }
    
    public function reassign($ticketId){
        $body["agents"] = $this->user_tb->getAllForReassign($this->session->userdata("user")->id);
        $body["ticket"] = $this->ticket_tb;
        $body["ticketId"] = $ticketId;
        $this->load->view("csr/tickets/ticket_reassign", $body);
    }
    
    public function doReassign(){
        $ticketId = $this->input->post("ticketId");
        $agentId = $this->input->post("agentId");
        
        /*UPDATE EXISTING */
        $data = array(
            'date_end' => date("Y-m-d H:i:s")
        );
        $this->ta_tb->updateByTicketAndAssignedId($ticketId, $this->session->userdata("user")->id, $data);
        $this->ticket_tb->updateAssignedTo($ticketId, $agentId, $this->session->userdata("user")->id);
        /*INSERT NEW */
        $subData = array(
            'ticket_id' => $ticketId,
            'date_start' => date("Y-m-d H:i:s"),
            'assigned_to' => $agentId
        );
        $this->ta_tb->saveSub($subData);
        msgRedirect("Ticket Successfully Reassigned", base_url() . "Tickets");
    }
}

?>
