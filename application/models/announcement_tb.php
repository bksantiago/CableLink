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
    var $comments = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", '', TRUE);
        $this->load->model("comment_tb", "", TRUE);
    }
    
    public function get(){
        $this->db->from("announcement_tb");
        $this->db->order_by("created_date", "DESC");
        $this->db->limit(1);
        $query = $this->db->get();
        
        foreach($query->result() as $row){
            $this->id = $row->id;
            $this->header = $row->header;
            $this->information = $row->information;
            $this->createdDate = $row->created_date;
            $this->createdBy = $this->user_tb->getById($row->created_by);
            $this->comments = $this->comment_tb->getByAnnouncementId($row->id);
        }
        return $this;
    }
    
    public function getAll(){
        $this->db->order_by("created_date", "DESC");
        $query = $this->db->get("announcement_tb");
        
        $announcements = array();
        foreach($query->result() as $row){
            $a = new announcement_tb();
            $a->id = $row->id;
            $a->header = $row->header;
            $a->information = $row->information;
            $a->createdDate = $row->created_date;
            $a->createdBy = $this->user_tb->getById($row->created_by);
            $a->comments = $this->comment_tb->getByAnnouncementId($row->id);
            $announcements[] = $a;
        }
        return $announcements;
    }
}

?>
