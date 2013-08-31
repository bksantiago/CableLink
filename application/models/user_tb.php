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
    
    function getAssignedCount() {
        $this->load->model("ticket_tb", "", TRUE);
        return $this->ticket_tb->getAssignCount($this->id);
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
    
    public function getSearch($txt){
        $data = array(
            'username' => $txt,
            'first_name' => $txt,
            'middle_name' => $txt,
            'last_name' => $txt,
            'email' => $txt,
            'contact_no' => $txt
        );
        $this->db->from("users_tb");
        $this->db->like("id", $txt, 'none');
        $query = $this->db->get();

        if($query->num_rows() == 0){
            $this->db->from("users_tb");
            $this->db->or_like($data);
            $query = $this->db->get();
        }
        
        $customers = array();
        foreach($query->result() as $row){
            $customers[] = $this->convertToUser($row);
        }
        return $customers;
    }

    public function getAll(){
        $query = $this->db->get("users_tb");
        $result = array();
        foreach($query->result() as $row){
            $result[] = $this->convertToUser($row);
        }
        return $result;
    }

    public function getAgentForReport($txt = null){
        $data = "(username like '%$txt%' or
            first_name like '%$txt%' or
            middle_name like '%$txt%' or
            last_name like '%$txt%' or
            email like '%$txt%') and
            position > 1 and position < 5";

        if($txt == null){
            $query = $this->db->get_where("users_tb", array('position >' => 1, 'position <' => 5));
        } else {
            $this->db->from("users_tb");
            $this->db->where("id", $txt);
            $this->db->where("position >", 1);
            $this->db->where("position <", 5);
            $query = $this->db->get();

            if($query->num_rows() == 0){
                $this->db->from("users_tb");
                $this->db->where($data);
                $query = $this->db->get();
            }
        }

        $customers = array();
        foreach($query->result() as $row){
            $customers[] = $this->convertToUser($row);
        }
        return $customers;
    }

    public function getContractorForReport($txt = null){
        $data = "(username like '%$txt%' or
            first_name like '%$txt%' or
            middle_name like '%$txt%' or
            last_name like '%$txt%' or
            email like '%$txt%') and
            position = 5";

        if($txt == null){
            $query = $this->db->get_where("users_tb", array('position' => 5));
        } else {
            $this->db->from("users_tb");
            $this->db->where("id", $txt);
            $this->db->where("position", 5);
            $query = $this->db->get();

            if($query->num_rows() == 0){
                $this->db->from("users_tb");
                $this->db->where($data);
                $query = $this->db->get();
            }
        }

        $customers = array();
        foreach($query->result() as $row){
            $customers[] = $this->convertToUser($row);
        }
        return $customers;
    }
    
    public function getAllForReassign($positionId){
        $query = $this->db->get_where("users_tb", array('position >' => $positionId, 'position <' => 5));
        $result = array();
        foreach($query->result() as $row){
            $result[] = $this->convertToUser($row);
        }
        return $result;
    }
    
    public function getContractors(){
        $query = $this->db->get_where("users_tb", array("position =" => 5));
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