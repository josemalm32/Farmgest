<?php

class Home extends CI_Controller
{
    // ------------------------------------------------------------------------
    
    public function index()
    {
        $this->load->view('home/inc/header_view');
        $this->load->view('home/home_view');
        $this->load->view('home/inc/footer_view');
    }
    
    public function lockscreen(){
        $this->load->view('home/inc/header_lock_view');
        $this->load->view('home/lockscreen_view');
        $this->load->view('home/inc/footer_view');
    }

    // ------------------------------------------------------------------------
    /*
    public function register()
    {
        $this->load->view('home/inc/header_view');
        $this->load->view('home/register_view');
        $this->load->view('home/inc/footer_view');
    }
    */
    // ------------------------------------------------------------------------
    
//    public function code()
//    {
//    echo hash('sha256', 'custom' . SALT);
//    }
    
//    public function test()
//    {        
//        $this->db   ->select('user_id, login')
//                    ->from('user')
//                    ->order_by('user_id DESC');
//        
//        $q = $this->db->get();
//        print_r($q->result());

//        $this->db->insert('user', [
//            'login' => 'Jenkins'
//        ]);
        
//        $this->db->where(['user_id' => 4]);
//        $this->db->update('user', [
//            'login' => 'Sammy'
//        ]);
        
//        $this->db->delete('user', ['user_id' => 3]);
        
//    }
    
}