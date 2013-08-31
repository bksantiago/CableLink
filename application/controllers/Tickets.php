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
        $this->load->model("contractor_city_tb", "c_city_tb", TRUE);
        $this->load->model("contractor_schedule_tb", "c_schedule_tb", TRUE);
        $this->load->model("dispatch_tb", "", TRUE);
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
            'date_start' => date("Y-m-d H:i:s"),
            'application_type' => $this->input->get("applicationType")
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
        
        if($body["ticket"]->assignedTb->id != $this->session->userdata("user")->id && $this->session->userdata("user")->id != 1){
            $body["view"] = 1;
        }
        
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
        $body["ticket"] = new ticket_tb();
        $body["ticketId"] = $ticketId;        
        $this->load->view("csr/tickets/ticket_reassign", $body);
    }
    
    public function doReassign($ticketId){
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
            'assigned_to' => $agentId,
            'assigned_by' => $this->session->userdata("user")->id
        );
        $this->ta_tb->saveSub($subData);
        msgRedirect("Ticket Successfully Reassigned", base_url() . "Tickets");
    }
    
    public function dispatch($ticketId){
        $ticket = $this->ticket_tb->getById($ticketId);
        $body["contractors"] = $this->c_city_tb->getByFranchiseId($ticket->accountTb->franchiseTb->id);
        $this->load->view("csr/tickets/ticket_dispatch", $body);
    }

    public function view_contractor($userId){
        $body["user"] = $this->user_tb->getById($userId);
        $body["schedules"] = $this->c_schedule_tb->getByUserId($userId);
        $body["days"] = $this->c_schedule_tb->getByUserIdDistinctDays($userId);
        $this->load->view("csr/tickets/ticket_contractor_schedule", $body);
    }

    public function view_date(){
        $userId = $this->input->post("userId");
        $day = $this->input->post("day");
        $timeSched = $this->c_schedule_tb->getByUserIdAndDay($userId, $day);

        echo json_encode($timeSched);
    }

    public function view_calendar(){
        $userId = $this->input->post("userId");
        $date = date('m/d/Y', strtotime($this->input->post("date")));
        $day = $this->input->post("day");

        $dispatch = $this->dispatch_tb->getByUserIdAndDate($userId, $date);
        $dispatchCount = $this->c_schedule_tb->getByUserIdAndDayCount($userId, $day);
        if(!empty($dispatch)){
            //if Puno yung whole day
            if(count($dispatch) == $dispatchCount){
                echo "f";
            } else {
                echo "o";
            }
        }
    }

    public function view_dispatch_time(){
        $userId = $this->input->post("userId");
        $date = date('Y-m-d', strtotime($this->input->post("date")));
        $time = $this->input->post("time");

        $dispatch = $this->dispatch_tb->getSpecific($userId, $date, $time);
        echo json_encode($dispatch);
    }

    public function save_dispatch(){
        $userId = $this->input->post("userId");
        $ticketId = $this->input->post("ticketId");
        $date = date('Y-m-d', strtotime($this->input->post("date")));
        $time = $this->input->post("time");

        $existingDispatch = $this->dispatch_tb->getDispatchByTicketId();

        if(empty($existingDispatch)){
            $time_start = $date;
            switch($time){
                case 1:
                    $time_start .= " 9:00:00";
                    break;
                case 2:
                    $time_start .= " 12:00:00";
                    break;
                case 3:
                    $time_start .= " 15:00:00";
                    break;
            }

            $data = array(
                'user_id' => $userId,
                'ticket_id' => $ticketId,
                'date' => $date,
                'time' => $time,
                'time_start' => $time_start,
                'assigned_id' => $this->session->userdata("user")->id
                );

            foreach($data as $d){
                echo $d . " ";
            }
            
            $this->db->insert("dispatch_tb", $data);

            /*UPDATE EXISTING */
            $dd = array(
                'date_end' => date("Y-m-d H:i:s")
            );
            $this->ta_tb->updateByTicketAndAssignedId($ticketId, $this->session->userdata("user")->id, $dd);
            $this->ticket_tb->updateAssignedTo($ticketId, $userId, $this->session->userdata("user")->id);
        }
    }

    public function upcoming_dispatches(){
        $body["dispatches"] = $this->dispatch_tb->getUpcomingDispatches(date('Y-m-d'));
        $this->load->view("csr/tickets/ticket_upcoming_dispatches", $body);
    }

    public function finish_dispatch(){
        $this->load->view("csr/tickets/ticket_finish_dispatch");
    }

    public function finish_dispatch_view(){
        $ticketId = $this->input->get("ticketId");
        
        $ticket = $this->ticket_tb->getById($ticketId);
        if(empty($ticket)){
            $body["error"] = "No Ticket Found!";
        } else {
            $dispatch = $ticket->getUnifinishedDispatches();
            if(empty($dispatch)){
                $body["error"] = "No dispatches/unfinished dispatches for this ticket";
            } else {
                $body["ticket"] = $ticket;
            }
        }
        $this->load->view("csr/tickets/ticket_finish_dispatch", $body);
    }

    public function finish_dispatch_submit(){
        $ticketId = $this->input->get("ticketId");

        $data = array(
                'time_finish' => date('Y-m-d '),
                'finished_by_id' => $this->session->userdata("user")->id
            );

        $this->db->where("ticket_id", $ticketId);
        $this->db->where("time_finish is NULL");
        $this->db->update("dispatch_tb", $data);

        $this->db->where("id", $ticketId);
        $this->db->update("tickets_tb", array('date_end' => date('Y-m-d H:i:s')));
        echo "<div class='alert alert-success'>Dispatch Successfully Updated</div>";
    }

    public function reschedule($ticketId){
        $ticket = $this->ticket_tb->getById($ticketId);
        $userId = $ticket->assignedTb->id;

        $body["user"] = $this->user_tb->getById($userId);
        
        foreach($ticket->getUnifinishedDispatches() as $d){
            $body["dispatch"] = $d;
        }
        $body["schedules"] = $this->c_schedule_tb->getByUserId($userId);
        $body["days"] = $this->c_schedule_tb->getByUserIdDistinctDays($userId);
        $this->load->view("csr/tickets/ticket_dispatch_reschedule", $body);
    }

    public function submit_reschedule(){
        $dispatchId = $this->input->post("dispatchId");
        $date = date('Y-m-d', strtotime($this->input->post("date")));
        $time = $this->input->post("time");

        $time_start = $date;
        switch($time){
            case 1:
                $time_start .= " 9:00:00";
                break;
            case 2:
                $time_start .= " 12:00:00";
                break;
            case 3:
                $time_start .= " 15:00:00";
                break;
        }

        $data = array(
            'date' => $date,
            'time' => $time,
            'time_start' => $time_start,
            'assigned_id' => $this->session->userdata("user")->id
            );

        $this->db->where("id", $dispatchId);
        $this->db->update("dispatch_tb", $data);
    }
}

?>
