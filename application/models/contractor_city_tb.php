<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contractor_city_tb
 *
 * @author Bk Santiago 
 */
class contractor_city_tb extends CI_Model {
    var $id = "";
    var $userTb = "";
    var $city = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("city_tb", "", TRUE);
    }
    
    public function getAll(){
        $query = $this->db->get("contractor_city_tb");
        $data = array();
        foreach($query->result() as $row){
            $cc = new contractor_city_tb();
            $cc->userTb = $this->user_tb->getById($row->user_id);
            $cc->city = $this->city_tb->getById($row->city_id);
            $data[] = $cc;
        }
        return $data;
    }
    
    public function getByFranchiseId($id){
        $query = $this->db->get_where("contractor_city_tb", array("city_id" => $id));
        $data = array();
        
        foreach($query->result() as $row){
            $cc = new contractor_city_tb();
            $cc->id = $row->id;
            $cc->userTb = $this->user_tb->getById($row->user_id);
            $cc->city = $this->city_tb->getById($row->city_id);
            $data[] = $cc;
        }
        return $data;
    }
}

?>
