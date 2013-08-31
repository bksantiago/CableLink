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
    var $assignedBy = "";
    
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

    public function getSingleAssignedTo($assignedTo){
        $this->db->from("ticket_assigned_tb");
        $this->db->where("assigned_to", $assignedTo);
        
        $query = $this->db->get();
        $ta = new ticket_assigned_tb();
        foreach($query->result() as $row){
            $ta = $this->convertToRow($row);
        }
        return $ta;
    }
    
    public function getByTicketAndAssignedId($ticketId, $assignedTo){
        $this->db->from("ticket_assigned_tb");
        $this->db->where("ticket_id", $ticketId);
        $this->db->where("assigned_to", $assignedTo);
        
        $query = $this->db->get();
        $ta = new ticket_assigned_tb();
        foreach($query->result() as $row){
            $ta = $this->convertToRow($row);
        }
        return $ta;
    }

    /* FOR REPORTS */

    public function getReportByUserFromTo($userId, $dateFrom, $dateTo){
        $data = "assigned_to = '$userId' and
            date_start >= '" . date('Y-m-d H:i:s', strtotime($dateFrom)) . "' and (
            date_end <= '" . date('Y-m-d H:i:s', strtotime($dateTo . " 23:59:59")) . "' or
            date_end is null
            )";
        $this->db->from("ticket_assigned_tb");
        $this->db->where($data);
       
        $query = $this->db->get();
        
        $tickets = array();
        foreach($query->result() as $row){
            $tickets[] = $this->convertToRow($row);
        }
        return $tickets;
    }

    public function getReportByPositionFromTo($pos, $dateFrom, $dateTo){
        $data = "date_start >= '" . date('Y-m-d H:i:s', strtotime($dateFrom)) . "' and (
            date_end <= '" . date('Y-m-d H:i:s', strtotime($dateTo . " 23:59:59")) . "' or
            date_end is null
            )";
        $this->db->from("ticket_assigned_tb");
        $this->db->join("users_tb", "ticket_assigned_tb.assigned_to = users_tb.id");
        $this->db->where($data);
        $this->db->where_in("users_tb.position", $pos);
       
        $query = $this->db->get();
        
        $tickets = array();
        foreach($query->result() as $row){
            $tickets[] = $this->convertToRow($row);
        }


        //distinct algo
        $distinctId = array();

        foreach($tickets as $t) {
            if(!in_array($t->assignedTo->id, $distinctId)){
                $distinctId[] = $t->assignedTo->id;
            }
        }

        $taFinal = array();
        foreach($distinctId as $dId){
            $taFinal[] = $this->getSingleAssignedTo($dId);
        }
        return $taFinal;
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
        $ta->assignedBy = $this->user_tb->getById($row->assigned_by);
        return $ta;
    }

    /* REPORTS FUNCTION */

    function getTotalResolve($ticketAssigned){
        $this->load->model("ticket_tb", "", TRUE);
        $count = 0;
        foreach($ticketAssigned as $ta) {
            $ticket = $this->ticket_tb->getById($ta->ticketTb);
            if($ticket->dateEnd == $ta->dateEnd && $ticket->dateEnd != null) {
                $count++;
            }
        }
        return $count;
    }

    function getMinHandletime($ticketAssigned){
        $min = 0;
        foreach($ticketAssigned as $ta) {
            if($ta->dateEnd != null){
                $d1 = strtotime($ta->dateStart);
                $d2 = strtotime($ta->dateEnd);

                $seconds = $d2 - $d1;

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                //$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                $diff = $hours . "." . $seconds;

                if($diff < $min || $min == 0) {
                    $min = $diff;
                }
            }
            
        }
        return round($min, 2);
    }

    function getMaxHandletime($ticketAssigned){
        $max = 0;
        foreach($ticketAssigned as $ta) {
            if($ta->dateEnd != null){
                $d1 = strtotime($ta->dateStart);
                $d2 = strtotime($ta->dateEnd);

                $seconds = $d2 - $d1;

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                //$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                $diff = $hours . "." . $seconds;

                if($diff > $max || $max == 0) {
                    $max = $diff;
                }
            }
            
        }
        return round($max, 2);
    }

    function getAverageHandletime($ticketAssigned){
        $total = 0;
        foreach($ticketAssigned as $ta) {
            if($ta->dateEnd != null){
                $d1 = strtotime($ta->dateStart);
                $d2 = strtotime($ta->dateEnd);

                $seconds = $d2 - $d1;

                $days    = floor($seconds / 86400);
                $hours   = floor(($seconds - ($days * 86400)) / 3600);
                $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
                //$seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

                $diff = $hours . "." . $seconds;

                $total += $diff;
            }
            
        }
        if ($total > 0){
            return round(($total / count($ticketAssigned)), 2);    
        } else {
            return 0;
        }
    }
}

?>
