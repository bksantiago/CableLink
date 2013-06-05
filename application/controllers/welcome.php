<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
    
    public function __construct() {
        parent::__construct();
        $this->load->model("user_tb", "", TRUE);
        $this->load->helper("url");
        $this->load->library("session");
    }
    
    public function index()
    {
        $head["title"] = "Login Page";
        $head["base"] = base_url();
        $body["error"] = 0;
        
        $username = $this->input->post("username");
        $password = $this->input->post("password");
        
        if(!empty($username) && !empty($password)){
            $result = $this->user_tb->login($username, $password);

            if($result != null){
                $this->session->set_userdata("user", $result);
                header("location: home");
            } else {
                $body["error"] = 1;
            }
        }
        
        $this->load->view('templates/heads', $head);
        $this->load->view('welcome_message', $body);
        $this->load->view('templates/footer');

    }
}