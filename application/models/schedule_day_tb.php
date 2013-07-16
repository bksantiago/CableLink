<?php 

class schedule_day_tb extends CI_Model{
	var $id = "";
	var $day = "";
	var $code = "";

	public function __construct(){
		parent::__construct();
	}

	public function getAll(){
        $query = $this->db->get("schedule_day_tb");
        return $query->result();
    }

    public function getById($id){
        $this->db->select("*");
        $this->db->from("schedule_day_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $sd = new schedule_day_tb();
        
        foreach($query->result() as $row){
            $sd->id = $row->id;
            $sd->day = $row->day;
            $sd->code = $row->code;
        }
        return $sd;
    }
}
?>