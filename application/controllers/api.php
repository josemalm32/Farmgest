<?php

class Api extends CI_Controller
{
    
    // ------------------------------------------------------------------------
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('todo_model');

    }
    
    // ------------------------------------------------------------------------
    
    private function _require_login()
    {
        if ($this->session->userdata('id_user') == false) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized.']));
            return false;
        }
    }
    
    // ------------------------------------------------------------------------
    
    public function login()
    {
        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $result = $this->user_model->get([
            'username' => $login,
            'password' => $password
            //'password' => hash('sha256', $password . SALT)
        ]);
        
        $this->output->set_content_type('application_json');

        if ($result) {
            $this->session->set_userdata(['id_user' => $result[0]['id']]);
            $this->output->set_output(json_encode(['result' => 1]));
            //return false;
            redirect('/dashboard');
        }
        
        $this->output->set_output(json_encode(['result' => 0]));
        redirect('/');
    }

    public function get_todo($id = null)
    {
        $this->_require_login();
        
        if ($id != null) {
            $result = $this->todo_model->get([
                'todo_id' => $id,
                'user_id' => $this->session->userdata('user_id')
            ]);
        } else {
            $result = $this->todo_model->get([
                'user_id' => $this->session->userdata('user_id')
            ]);
        }
        
        $this->output->set_output(json_encode($result));
    }
}
?>
    