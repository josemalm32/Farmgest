<?php

class Dashboard extends CI_Controller
{
    // ------------------------------------------------------------------------ 
    
    public function __construct() 
    {
        parent::__construct();

        $session_entity = $this->session->userdata('id_entity');
        $user_id = $this->session->userdata('id_user');
        if (!$user_id) {
            $this->logout();
        }

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('grocery_CRUD_model');
        $this->load->library('grocery_CRUD');
        $this->load->library('gc_dependent_select');
        
    }

    // ------------------------------------------------------------------------ 
    
    public function index()
    {
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 1;

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/dashboard_view');
        $this->load->view('dashboard/inc/footer_main_view');
        
    }
    
    // ------------------------------------------------------------------------ 
     
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    // ------------------------------------------------------------------------ 
    
    private function _require_login()
    {
        if ($this->session->userdata('id_user') == false) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized.']));
            return false;
        }
    }

    
}
?>
