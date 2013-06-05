<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ticket_tb
 *
 * @author Bk Santiago 
 */
class Ticket_tb extends CI_Model{
    var $id = "";
    var $accountTb = "";
    var $assignedTb = "";
    var $dateStart = "";
    var $dateEnd = "";
    var $ticketsAssignedTb = "";
    var $singleAssignedTb = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("ticket_assigned_tb", 'ta_tb', TRUE);
        $this->load->model("customer_tb", '', TRUE);
        $this->load->model("user_tb", '', TRUE);
    }
    
    public function save($data){
        $this->db->insert("tickets_tb", $data);
        $ticketId = $this->db->insert_id();
        
        $this->ta_tb->save($this->getById($ticketId));
        return $this->getById($ticketId);
    }
    
    public function getById($id){
        $this->db->from("tickets_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $ticket = "";
        foreach($query->result() as $row){
            $ticket = $this->convertToRow($row);
        }
        return $ticket;
    }
    
    public function getAssignCount($userId){
        $this->db->from("tickets_tb");
        $this->db->where("assigned_to", $userId);
        $this->db->where("date_end is NULL");
        return $this->db->count_all_results();
    }
    
    public function getAll(){
        $query = $this->db->get("tickets_tb");
        $tickets = array();
        foreach($query->result() as $row){
            $tickets[] = $this->convertToRow($row);
        }
        return $tickets;
    }
    
    public function getAssigned($userId){
        $this->db->from("tickets_tb");
        $this->db->where("assigned_to", $userId);
        $this->db->where("date_end is NULL");
        $query = $this->db->get();
        $tickets = array();
        foreach($query->result() as $row){
            $tickets[] = $this->convertToRow($row);
        }
        return $tickets;
    }
    
    public function getTicketsByCustomerId($customerId){
        $this->db->from("tickets_tb");
        $this->db->where("account_no", $customerId);
        $this->db->order_by("date_start", "desc");
        $query = $this->db->get();
        
        $tickets = array();
        foreach($query->result() as $row){
            $tickets[] = $this->convertToRow($row);
        }
        return $tickets;
    }
    
    public function resolve($id, $assignedTo, $data){
        $this->db->where("id", $id);
        $this->db->update("tickets_tb", $data);
        $this->ta_tb->updateByTicketAndAssignedId($id, $assignedTo, $data);
    }
    
    public function updateAssignedTo($ticketId, $newAgentId, $oldAgentId){
        $this->db->where("id", $ticketId);
        $this->db->where("assigned_to", $oldAgentId);
        $this->db->update("tickets_tb", array('assigned_to' => $newAgentId));
    }
    
    private function convertToRow($row){
        $ticket = new Ticket_tb();
        $ticket->id = $row->id;
        $ticket->accountTb = $this->customer_tb->getById($row->account_no);
        $ticket->assignedTb = $this->user_tb->getByid($row->assigned_to);
        $ticket->dateStart = $row->date_start;
        $ticket->dateEnd = $row->date_end;
        $ticket->ticketsAssignedTb = $this->ta_tb->getByTicketId($row->id);
        $ticket->singleAssignedTb = $this->ta_tb->getByTicketAndAssignedId($row->id, $row->assigned_to);
        return $ticket;
    }
}

?>
