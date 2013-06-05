<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of announcement_tb
 *
 * @author Bk Santiago 
 */
class announcement_tb extends CI_Model{
    var $id = "";
    var $header = "";
    var $information = "";
    var $createdDate = "";
    var $createdBy = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", '', TRUE);
    }
    
    public function get(){
        $query = $this->db->get("announcement_tb");
        
        foreach($query->result() as $row){
            $this->id = $row->id;
            $this->header = $row->header;
            $this->information = $row->information;
            $this->createdDate = $row->created_date;
            $this->createdBy = $this->user_tb->getById($row->created_by);
        }
    return $this;
    }
}

?>
