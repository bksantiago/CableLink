<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_tb
 *
 * @author Bk Santiago 
 */
class User_tb extends CI_Model{
    var $id = "";
    var $username = "";
    var $password = "";
    var $firstName = "";
    var $middleName = "";
    var $lastName = "";
    var $email = "";
    var $contactNo = "";
    var $positionTb = "";
    
    function __construct() {
        parent::__construct();
        $position = $this->load->model("position_tb", "", TRUE);
    }
    
    function login($username, $password){
        $this->db->select('*');
        $this->db->from("users_tb");
        $this->db->where("username", $username);
        $this->db->where("password", md5($password));
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            foreach($query->result() as $row){
                $agent = $this->convertToUser($row);
            }
            return $agent;
        } else {
            return null;
        }
    }
    
    public function getAll(){
        $query = $this->db->get("users_tb");
        $result = array();
        foreach($query->result() as $row){
            $result[] = $this->convertToUser($row);
        }
        return $result;
    }
    
    public function getAllForReassign($positionId){
        $query = $this->db->get_where("users_tb", array('position >' => $positionId));
        $result = array();
        foreach($query->result() as $row){
            $result[] = $this->convertToUser($row);
        }
        return $result;
    }
    
    public function getById($id){
        $this->db->select("*");
        $this->db->from("users_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $result = new User_tb();
        foreach($query->result() as $row){
            $result = $this->convertToUser($row);
        }
        return $result;
    }
    
    public function getCompleteName(){
        return $this->lastName . ", " . $this->firstName . " " . $this->middleName;
    }
    
    public function usernameExist($username){
        $this->db->select('*');
        $this->db->from("users_tb");
        $this->db->where("username", $username);
        
        $query = $this->db->get();
        
        if($query->num_rows() > 0){
            return "false";
        } else {
            return "true";
        }
    }
    
    private function convertToUser($row){
        $agent = new User_tb();
        $agent->id = $row->id;
        $agent->username = $row->username;
        $agent->password = $row->password;
        $agent->firstName = $row->first_name;
        $agent->middleName = $row->middle_name;
        $agent->lastName = $row->last_name;
        $agent->email = $row->email;
        $agent->contactNo = $row->contact_no;

        $agent->positionTb = $this->position_tb->getPositionById($row->position);
        return $agent;
    }
}

?>