<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of city_tb
 *
 * @author Bk Santiago 
 */
class city_tb extends CI_Model{
    var $id = "";
    var $city = "";
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAll(){
        $query = $this->db->get("city_tb");
        return $query->result();
    }
    
    public function getById($id){
        $this->db->select("*");
        $this->db->from("city_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $city = new city_tb();
        
        foreach($query->result() as $row){
            $city->id = $row->id;
            $city->city = $row->city;
        }
        return $city;
    }
}

?>
