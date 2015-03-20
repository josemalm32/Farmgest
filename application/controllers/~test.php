<?php

class Test extends CI_Controller
{
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('user_model');
        $result = $this->user_model->get();
//        $result = $this->user_model->insert(['login' => 'Markus2']);

//          $result = $this->user_model->delete(array(
//              'login' => 'Markus2'
//          ));
//        $result = $this->user_model->update(
//                array('password' => 'dog', 'login' => 'hen'),
//                array('login' => 'Markus3'));
        
        $result = $this->user_model->insertUpdate([
            'login' => 'Donny2'
        ], 23);
        
        echo '<pre>';
        print_r($result);
    }

    public function index()
    {
        $this->output->enable_profiler(true);
    }
    
    public function test_get()
    {
        $data = $this->user_model->get(5);
        print_r($data);
    }
    
    public function test_insert()
    {
        $result = $this->user_model->insert([
            'login' => 'Jethro'
        ]);
        print_r($result);
    }
    
    public function test_update()
    {
        $result = $this->user_model->update([
            'login' => 'Peggy'
        ], 3);
        print_r($result);
    }
    
    public function test_delete($user_id)
    {
        $result = $this->user_model->delete($user_id);
        print_r($result);
    }
    
}