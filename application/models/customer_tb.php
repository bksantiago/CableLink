<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customer_tb
 * 
 * @var billingCycle    1 = Regular Cycle   | 2 = Quarterly Cycle
 * @var applicationType 0 = Cable           | 1 = Internet          | 2 = Both
 * @var accountType     1 = Parent          | 0 = Children
 * 
 * @author Bk Santiago 
 */
class Customer_tb extends CI_Model{
    var $id = "";
    var $franchiseTb = "";
    var $billingCycle = "";
    var $applicationDate = "";
    var $applicationType = "";
    var $prefix = "";
    var $firstName = "";
    var $middleName = "";
    var $lastName = "";
    var $address = "";
    var $accountType = "";
    var $birthdate = "";
    var $email = "";
    var $contact1 = "";
    var $contact2 = "";
    var $contact3 = "";
    var $landmarks = "";
    var $createdBy = "";
    var $ticketsTb = "";
    
    public function __construct() {
        parent::__construct();
        $this->load->model("city_tb", "", TRUE);
        $this->load->model("user_tb", "", TRUE);
    }
    
    public function getAll(){
        $query = $this->db->get("customer_tb");
        $customers = array();
        foreach($query->result() as $row){
            $customers[] = $this->convertToCustomer($row);
        }
        return $customers;
    }
    
    public function getSearch($txt){
        $data = array(
            'first_name' => $txt,
            'middle_name' => $txt,
            'last_name' => $txt,
            'address' => $txt,
            'email' => $txt,
            'landmarks' => $txt
        );
        $this->db->from("customer_tb");
        $this->db->like("id", $txt, 'none');
        $query = $this->db->get();
        if($query->num_rows() == 0){
            $this->db->from("customer_tb");
            $this->db->or_like($data);
            $query = $this->db->get();
        }
        
        $customers = array();
        foreach($query->result() as $row){
            $customers[] = $this->convertToCustomer($row);
        }
        return $customers;
    }
    
    public function getById($id){
        $this->db->from("customer_tb");
        $this->db->where("id", $id);
        
        $query = $this->db->get();
        $customer = "";
        foreach($query->result() as $row){
            $customer = $this->convertToCustomer($row);
        }
        return $customer;
    }
    
    public function getCompleteName(){
        return $this->lastName . ", " . $this->firstName . " " . $this->middleName;
    }
    
    public function getApplicationType(){
        switch($this->applicationType){
            case 0: return "Cable"; break;
            case 1: return "Internet"; break;
            case 2: return "Both"; break;
            default : return ""; break;
        }
    }
    
    public function getMyTickets(){
        $this->load->model("ticket_tb", "", TRUE);
        return $this->ticket_tb->getTicketsByCustomerId($this->id);
    }
    
    private function convertToCustomer($row){
        $cus = new Customer_tb();
        $cus->id = $row->id;
        $cus->franchiseTb = $this->city_tb->getById($row->franchise);
        $cus->billingCycle = $row->billing_cycle;
        $cus->applicationDate = $row->application_date;
        $cus->applicationType = $row->application_type;
        $cus->prefix = $row->prefix;
        $cus->firstName = $row->first_name;
        $cus->middleName = $row->middle_name;
        $cus->lastName = $row->last_name;
        $cus->address = $row->address;
        $cus->accountType = $row->account_type;
        $cus->birthdate = $row->birthdate;
        $cus->email = $row->email;
        $cus->contact1 = $row->contact_no1;
        $cus->contact2 = $row->contact_no2;
        $cus->contact3 = $row->contact_no3;
        $cus->landmarks = $row->landmarks;
        $cus->createdBy = $this->user_tb->getById($row->created_by);
        
        return $cus;
    }
}

?>
