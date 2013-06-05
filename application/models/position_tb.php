<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of position_tb
 *
 * @author Bk Santiago 
 */
class Position_tb extends CI_Model{
    var $id = "";
    var $code = "";
    var $position = "";
    
    public function __construct() {
        parent::__construct();
    }
    
    function getPositionById($id){
        $this->db->select('*');
        $this->db->from("position_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $query->result();
        $pos = new Position_tb();
        foreach($query->result() as $row){
            $pos->id = $row->id;
            $pos->code = $row->code;
            $pos->position = $row->position;
        }
        return $pos;
    }
    
    function getAllPositions(){
        $this->db->select('*');
        $this->db->from("position_tb");
        
        $query = $this->db->get();
        
        return $query->result();
    }
}

?>