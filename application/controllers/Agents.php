<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of agents
 *
 * @author Bk Santiago 
 */
class Agents extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->model("position_tb", "", TRUE);
        $this->load->model("city_tb", "", TRUE);
        $this->load->model("ticket_assigned_tb", "ta_tb", TRUE);
        $this->load->model("announcement_tb", "", TRUE);
        $this->load->model("contractor_city_tb", "cc_tb", TRUE);
        $this->load->model("contractor_schedule_tb", "cs_tb", TRUE);
        $this->load->model("schedule_day_tb", "s_day_tb", TRUE);
        $this->load->model("schedule_time_tb", "s_time_tb", TRUE);
        $this->load->library("session");
        
        //validate if Admin
        $proceed = false;
        $user = $this->session->userdata("user");
        if($user != null){
            if($user->id == 1){
                $proceed = true;
            }
        }
        if(!$proceed){
            sendHome();
        }
    }
    
    function index(){
        $head["title"] = "Agent Page";
        $header["user"] = $this->session->userdata("user");
        
        $this->load->view('templates/heads', $head);
        $this->load->view('templates/header', $header);
        $this->load->view('admin/agents');
        $this->load->view('templates/footer');
    }
    
    function agent_list(){
        if($this->input->get("search") != ""){
            $body["search"] = $this->input->get("search");
            $body["agents"] = $this->user_tb->getSearch($body["search"]);
        } else {
           $body["agents"] = $this->user_tb->getAll();
        }

        $this->load->view("admin/agents/agent_list", $body);
    }
    function agent_registration(){
        $body["cities"] = $this->city_tb->getAll();
        $body["positions"] = $this->position_tb->getAllPositions();
        $body["schedDay"] = $this->s_day_tb->getAll();
        $body["schedTime"] = $this->s_time_tb->getAll();
        $this->load->view("admin/agents/agent_registration", $body);
    }
    
    function announcement(){
        $body["announcement"] = $this->announcement_tb->get();
        $this->load->view("admin/agents/agent_announcement", $body);
    }
    
    function announcement_save(){
        $data = array(
            'header' => $this->input->post("header"),
            'information' => $this->input->post("information"),
            'created_date' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata("user")->id
        );
        $this->db->insert("announcement_tb", $data);
        echo "save;top";
    }

    function announcement_edit(){
        $body["announcement"] = $this->announcement_tb->get();
        $this->load->view("admin/agents/agent_announcement_edit", $body);
    }

    function announcement_update(){
        $data = array(
            'header' => $this->input->post("header"),
            'information' => $this->input->post("information"),
            'created_date' => date("Y-m-d H:i:s"),
            'created_by' => $this->session->userdata("user")->id
        );
        $this->db->where("id", $this->input->post("id"));
        $this->db->update("announcement_tb", $data);
        echo "save;top";
    }

    function edit($id){
        $body["positions"] = $this->position_tb->getAllPositions();
        $body["cities"] = $this->city_tb->getAll();
        $body["agent"] = $this->user_tb->getById($id);
        $body["schedDay"] = $this->s_day_tb->getAll();
        $body["schedTime"] = $this->s_time_tb->getAll();

        if($body["agent"]->positionTb->id == "5"){
            $body["contractorCity"] = $this->cc_tb->getByUserId($body["agent"]->id);
            $body["schedules"] = convertToNumeric($this->cs_tb->getByUserId($body["agent"]->id));
        }

        $this->load->view("admin/agents/agent_edit", $body);
    }
    
    function save(){
        $data = array(
            'username' => $this->input->post("username"),
            'password' => md5($this->input->post("password")),
            'first_name'=> $this->input->post("firstname"),
            'middle_name'=> $this->input->post("middlename"),
            'last_name'=> $this->input->post("lastname"),
            'email'=> $this->input->post("email"),
            'contact_no'=> $this->input->post("contact"),
            'position'=> $this->input->post("position"),
        );

        $this->db->insert("users_tb", $data);
        $newId = $this->db->insert_id();

        if($this->input->post("position") == "5"){
            $cities = $this->input->post("cities");
            $schedules = $this->input->post("schedule");
            if(!empty($cities)){
                foreach($cities as $city){
                    $cityData = array(
                        'user_id' => $newId,
                        'city_id' => $city,
                    );
                    $this->db->insert("contractor_city_tb", $cityData);
                }
            }
            if(!empty($schedules)){
                foreach($schedules as $sched){
                    $s = explode(";", $sched);
                    $schedData = array(
                        'contractor_id' => $newId,
                        'schedule_day' => $s[0],
                        'schedule_time' => $s[1],
                    );
                    $this->db->insert("contractor_schedule_tb", $schedData);
                }
            }
        }
        
        echo "save;top";
    }

    function update(){
        $data = array(
            'first_name'=> $this->input->post("firstname"),
            'middle_name'=> $this->input->post("middlename"),
            'last_name'=> $this->input->post("lastname"),
            'email'=> $this->input->post("email"),
            'contact_no'=> $this->input->post("contact"),
            'position'=> $this->input->post("position"),
        );
        $userId = $this->input->post("id");

        $this->db->where("id", $userId);
        $this->db->update("users_tb", $data);

        if($this->input->post("position") == "5"){
            $cities = $this->input->post("cities");
            $schedules = $this->input->post("schedule");

            $this->db->where("user_id", $userId);
            $this->db->delete("contractor_city_tb");

            if(!empty($cities)){
                foreach($cities as $city){
                    $cityData = array(
                        'user_id' => $userId,
                        'city_id' => $city,
                    );
                    $this->db->insert("contractor_city_tb", $cityData);
                }
            }

            $this->db->where("contractor_id", $userId);
            $this->db->delete("contractor_schedule_tb");

            if(!empty($schedules)){
                foreach($schedules as $sched){
                    $s = explode(";", $sched);
                    $schedData = array(
                        'contractor_id' => $userId,
                        'schedule_day' => $s[0],
                        'schedule_time' => $s[1],
                    );
                    $this->db->insert("contractor_schedule_tb", $schedData);
                }
            }
        }

        //update session if same
        if($this->session->userdata("user")->id == $userId){
            $this->session->set_userdata("user", $this->user_tb->getById($userId));
        }

        echo "update;bottom";
    }
    
    function contractors(){
        $body["contractors"] = $this->user_tb->getContractors();
        $this->load->view("admin/agents/agent_contractors", $body);
    }

    function report_single(){
        if($this->input->get("search") != ""){
            $body["search"] = $this->input->get("search");
            $body["agents"] = $this->user_tb->getAgentForReport($body["search"]);
        } else {
           $body["agents"] = $this->user_tb->getAgentForReport();
        }
        $this->load->view("admin/agents/reports/agent_single_list", $body);
    }

    function generate_single($agentId){
        $body["agent"] = $this->user_tb->getById($agentId);

        if($this->input->get("dateFrom") != ""){
            $dateFrom = $this->input->get("dateFrom");
            $dateTo = $this->input->get("dateTo");

            $assignedReport = $this->ta_tb->getReportByUserFromTo($agentId, $dateFrom, $dateTo);

            $body["totalHandled"] = count($assignedReport);
            $body["totalResolve"] = $this->ta_tb->getTotalResolve($assignedReport);
            $body["minHandledTime"] = $this->ta_tb->getMinHandletime($assignedReport) . " hours";
            $body["maxHandledTime"] = $this->ta_tb->getMaxHandletime($assignedReport) . " hours";
            $body["averageHandledTime"] = $this->ta_tb->getAverageHandletime($assignedReport) . " hours";

            $body["dateFrom"] = $dateFrom;
            $body["dateTo"] = $dateTo;
        }
        $this->load->view("admin/agents/reports/agent_single_generated", $body);
    }

    function report_multiple(){
        $this->load->view("admin/agents/reports/agent_multiple_list");
    }

    function generate_multiple($p = "2-3-4"){
        $pos = explode("-", $p);
        $positions = array();
        $positionString = array();

        foreach($pos as $pp){
            $positionString[] = $pp;
            $positions[] = $this->position_tb->getPositionById($pp);            
        }
        $body["positions"] = $positions;

        if($this->input->get("dateFrom") != ""){
            $dateFrom = $this->input->get("dateFrom");
            $dateTo = $this->input->get("dateTo");

            $assignedReports = $this->ta_tb->getReportByPositionFromTo($positionString, $dateFrom, $dateTo);            

            $body["agents"] = $assignedReports;
            $body["dateFrom"] = $dateFrom;
            $body["dateTo"] = $dateTo;
        }

        $this->load->view("admin/agents/reports/agent_multiple_generated", $body);
    }

    function report_contractor(){
        if($this->input->get("search") != ""){
            $body["search"] = $this->input->get("search");
            $body["agents"] = $this->user_tb->getContractorForReport($body["search"]);
        } else {
           $body["agents"] = $this->user_tb->getContractorForReport();
        }        
        $this->load->view("admin/agents/reports/agent_contractor_list", $body);
    }
}
?>