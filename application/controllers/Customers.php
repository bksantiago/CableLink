<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customers
 *
 * @author Bk Santiago 
 */
class Customers extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("customer_tb", "", TRUE);
        $this->load->model("city_tb", "", TRUE);
        $this->load->library("session");
        
        //validate if Login
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            $proceed = true;
        } else {
            sendHome();
        }
    }
    
    public function index(){
        $head["title"] = "Customers Page";
        $header["user"] = $this->session->userdata("user");
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('admin/customers');
        $this->load->view('templates/footer');
    }
    
    public function customer_list($f = null){
        if($this->input->get("search") != ""){
            $body["search"] = $this->input->get("search");
            $body["customers"] = $this->customer_tb->getSearch($body["search"]);
        } else {
            $body["customers"] = $this->customer_tb->getAll();
        }
        
        $body["user"] = $this->session->userdata("user");
        
        //for Ticket Creation;
        if($f == 1){
            $body["forTicket"] = 1;
        }
        
        $this->load->view('admin/customers/customer_list', $body);
    }
    public function customer_registration(){
        $body["cities"] = $this->city_tb->getAll();
        $body["date"] = date('F d, Y');
        $body["user"] = $this->session->userdata("user");
        $this->load->view('admin/customers/customer_registration', $body);
    }
    
    public function edit($id){
        $body["cities"] = $this->city_tb->getAll();
        $body["customer"] = $this->customer_tb->getById($id);
        $url = 'admin/customers/customer_registration';
            
        $this->load->view($url, $body);
    }
    
    public function view($id){
        $body["customer"] = $this->customer_tb->getById($id);
        $url = 'admin/customers/customer_view';
        
        $this->load->view($url, $body);
    }
    
    public function save(){
        $data = array(
            'franchise' => $this->input->post("franchise"),
            'billing_cycle' => $this->input->post("billing"),
            'application_date' => date("Y-m-d H:i:s"),
            'application_type' => $this->input->post("applicationtype"),
            'prefix' => $this->input->post("prefix"),
            'first_name' => $this->input->post("firstname"),
            'middle_name' => $this->input->post("middlename"),
            'last_name' => $this->input->post("lastname"),
            'address' => $this->input->post("address"),
            'account_type' => $this->input->post("accounttype"),
            'birthdate' => date('Y-m-d', strtotime($this->input->post("birthdate"))),
            'email' => $this->input->post("email"),
            'contact_no1' => $this->input->post("contact1"),
            'contact_no2' => $this->input->post("contact2"),
            'contact_no3' => $this->input->post("contact3"),
            'landmarks' => $this->input->post("landmarks"),
            'created_by' => $this->session->userdata("user")->id,
        );
        //TODO save/update also
        if($this->input->post("id") != ""){
            unset($data['application_date']);
            unset($data['created_by']);
            $this->db->where("id", $this->input->post("id"));
            $this->db->update("customer_tb", $data);
            echo "update;bottom";
        } else {
            $this->db->insert("customer_tb", $data);
            echo "save;top";
        }
    }
}

?>
