<?php 

class schedule_time_tb extends CI_Model{
	var $id = "";
	var $schedule = "";
	var $code = "";

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
        $query = $this->db->get("schedule_time_tb");
        return $query->result();
    }

    public function getById($id){
    	$this->db->select("*");
    	$this->db->from("schedule_time_tb");
    	$this->db->where("id", $id);

    	$query = $this->db->get();
    	$st = new schedule_time_tb();

    	foreach($query->result() as $row){
    		$st->id = $row->id;
    		$st->schedule = $row->schedule;
    		$st->code = $row->code;
    	}
    	return $st;
    }
}
?>