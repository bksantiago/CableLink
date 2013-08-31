<?php 

class contractor_schedule_tb extends CI_Model{
	var $id = "";
	var $userTb = "";
	var $schedDay = "";
	var $schedTime = "";

	public function __construct(){
		parent::__construct();
		$this->load->model("user_tb", "", TRUE);
		$this->load->model("schedule_day_tb", "sd_tb", TRUE);
		$this->load->model("schedule_time_tb", "st_tb", TRUE);
	}

	public function getAll(){
        $query = $this->db->get("contractor_schedule_tb");
        $data = array();
        foreach($query>result() as $row){
        	$data[] = $this->convertToRow($row);
        }
        return $data;
    }

    public function getByUserId($id){
    	$query = $this->db->get_where("contractor_schedule_tb", array('contractor_id' => $id));
    	$data = array();
        foreach($query->result() as $row){
        	$data[] = $this->convertToRow($row);
        }
        return $data;
    }

    public function getByUserIdAndDay($id, $day){
        $query = $this->db->get_where("contractor_schedule_tb", array('contractor_id' => $id, 'schedule_day' => $day));
        $data = array();
        foreach($query->result() as $row){
            $data[] = $this->convertToRow($row);
        }
        return $data;
    }

    public function getByUserIdAndDayCount($id, $day){
        $query = $this->db->get_where("contractor_schedule_tb", array('contractor_id' => $id, 'schedule_day' => $day));
        $data = array();
        foreach($query->result() as $row){
            $data[] = $this->convertToRow($row);
        }
        return count($data);
    }

    public function getByUserIdDistinctDays($id){
        $this->db->distinct();
        $this->db->select("schedule_day");
        $this->db->where('contractor_id', $id);
        
        $query = $this->db->get('contractor_schedule_tb');
        $data = array();
        foreach($query->result() as $row){
            $cs = new contractor_schedule_tb();
            $cs->schedDay = $this->sd_tb->getById($row->schedule_day);

            $data[] = $cs;
        }
        return $data;
    }

    private function convertToRow($row){
    	$cs = new contractor_schedule_tb();
    	$cs->id = $row->id;
    	$cs->userTb = $this->user_tb->getById($row->id);
    	$cs->schedDay = $this->sd_tb->getById($row->schedule_day);
    	$cs->schedTime = $this->st_tb->getById($row->schedule_time);
    	return $cs;
    }
}
?>