<?php

class Widgets extends CI_Controller
{
    
    // ------------------------------------------------------------------------
    
    public function __construct() 
    {
        parent::__construct();
        $user_id = $this->session->userdata('id_user');
        if (!$user_id) {
            $this->logout();
        }
    }
    
    // ------------------------------------------------------------------------
    
    public function index()
    {
        $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/widgets_view');
        $this->load->view('dashboard/inc/footer_view');
    }
    
    // ------------------------------------------------------------------------

    
}