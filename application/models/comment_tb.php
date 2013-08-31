<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comment_tb
 *
 * @author Bk Santiago 
 */
class comment_tb extends CI_Model{
    var $id = "";
    var $announcementId = "";
    var $comment = "";
    var $createdDate = "";
    var $createdBy = "";
    
    public function __construct() {
        $this->load->model("user_tb", "", TRUE);
        parent::__construct();
    }
    
    public function getByAnnouncementId($id){
        $this->db->where("announcement_id", $id);
        $this->db->order_by("created_date");
        $query = $this->db->get("comment_tb");
        
        $comments = array();
        foreach($query->result() as $row){
            $c = new comment_tb();
            $c->id = $row->id;
            $c->announcementId = $row->announcement_id;
            $c->comment = $row->comment;
            $c->createdDate = $row->created_date;
            $c->createdBy = $this->user_tb->getById($row->created_by);
            $comments[] = $c;
        }
        return $comments;
    }
}

?>
