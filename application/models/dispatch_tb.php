<?php 

class dispatch_tb extends CI_Model{
	var $id = "";
	var $userTb = "";
    var $ticketTb = "";
    var $date = "";
    var $schedTime = "";
    var $timeStart = "";
    var $timeFinish = "";
    var $assignedTb = "";
    var $finishedByTb = "";
    
	public function __construct(){
		parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("ticket_tb", "", TRUE);
        $this->load->model("schedule_time_tb", "st_tb", TRUE);
	}

    public function getAll(){
        $query = $this->db->get("dispatch_tb");
        $data = array();
        foreach($query>result() as $row){
            $data[] = $this->convertToRow($row);
        }
        return $data;
    }

    public function getSpecific($userId, $date, $time){
        $data = array(
            'user_id' => $userId,
            'date' => date('Y-m-d', strtotime($date)),
            'time' => $time
            );
        $query = $this->db->get_where("dispatch_tb", $data);
        
        $d = new dispatch_tb();
        foreach($query->result() as $row){
            $d = $this->convertToRow($row);
        }
        return $d;
    }

    public function getDispatchByTicketId($ticketId){
        $data = array(
            'ticket_id' => $ticketId
            );
        $query = $this->db->get_where("dispatch_tb", $data);

        $d = array();
        foreach($query->result() as $row){
            $d[] = $this->convertToRow($row);
        }
        return $d;
    }

    public function getUnfinishedDispatchByTicketId($ticketId){
        $data = array(
            'ticket_id' => $ticketId,
            'time_finish' => NULL
            );
        $query = $this->db->get_where("dispatch_tb", $data);

        $d = array();
        foreach($query->result() as $row){
            $d[] = $this->convertToRow($row);
        }
        return $d;
    }

    public function getUpcomingDispatches($date){
        $data = array(
            'date >' => $date
            );
        $query = $this->db->get_where("dispatch_tb", $data);

        $d = array();
        foreach($query->result() as $row){
            $d[] = $this->convertToRow($row);
        }
        return $d;
    }

    public function getByUserIdAndDate($userId, $date){
        $data = array(
            'user_id' => $userId,
            'date' => date('Y-m-d', strtotime($date))
            );
        $query = $this->db->get_where("dispatch_tb", $data);

        $d = array();
        foreach($query->result() as $row){
            $d[] = $this->convertToRow($row);
        }
        return $d;
    }

    private function convertToRow($row){
        $d = new dispatch_tb();
        $d->id = $row->id;
        $d->userTb = $this->user_tb->getById($row->user_id);
        $d->ticketTb = $this->ticket_tb->getById($row->ticket_id);
        $d->date = $row->date;
        $d->schedTime = $this->st_tb->getById($row->time);
        $d->timeStart = $row->time_start;
        $d->timeFinish = $row->time_finish;
        $d->assignedTb = $this->user_tb->getById($row->assigned_id);
        $d->finishedByTb = $this->user_tb->getById($row->assigned_id);
        return $d;
    } 	
}
?>