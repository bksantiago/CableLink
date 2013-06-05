<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ticket_assigned_tb
 *
 * @author Bk Santiago 
 */
class ticket_assigned_tb extends CI_Model{
    var $id = "";
    var $ticketTb = "";
    var $dateStart = "";
    var $dateEnd = "";
    var $assignedTo = "";
    var $remarks = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
    }
    
    public function save($ticket){
        $data = array(
            'ticket_id' => $ticket->id,
            'date_start' => $ticket->dateStart,
            'assigned_to' => $ticket->assignedTb->id
        );
        $this->db->insert("ticket_assigned_tb", $data);
    }
    
    public function saveSub($data){
        $this->db->insert("ticket_assigned_tb", $data);
    }
    
    public function updateByTicketAndAssignedId($ticketId, $assignedTo, $data){
        $this->db->where("ticket_id", $ticketId);
        $this->db->where("assigned_to", $assignedTo);
        $this->db->update("ticket_assigned_tb", $data);
    }
    
    public function getByTicketId($ticketId){
        $this->db->from("ticket_assigned_tb");
        $this->db->where("ticket_id", $ticketId);
        
        $query = $this->db->get();
        $ta = array();
        foreach($query->result() as $row){
            $ta[] = $this->convertToRow($row);
        }
        return $ta;
    }
    
    public function getByTicketAndAssignedId($ticketId, $assignedTo){
        $this->db->from("ticket_assigned_tb");
        $this->db->where("ticket_id", $ticketId);
        $this->db->where("assigned_to", $assignedTo);
        
        $query = $this->db->get();
        $ta = "";
        foreach($query->result() as $row){
            $ta = $this->convertToRow($row);
        }
        return $ta;
    }
    
    private function convertToRow($row){
        $this->load->model("ticket_tb", "", TRUE);
        $ta = new ticket_assigned_tb();
        $ta->id = $row->id;
        //$ta->ticketTb = $this->tickets_tb->getById($row->ticket_id);
        $ta->ticketTb = $row->ticket_id;
        $ta->dateStart = $row->date_start;
        $ta->dateEnd = $row->date_end;
        $ta->assignedTo = $this->user_tb->getById($row->assigned_to);
        $ta->remarks = $row->remarks;
        return $ta;
    }
}

?>
