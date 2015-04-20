<?php

class Api extends CI_Controller
{
    
    // ------------------------------------------------------------------------
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('todo_model');
        $this->load->model('entity_model');

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
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->user_model->get([
            'username' => $username,
            'password' => $password
            //'password' => hash('sha256', $password . SALT)
        ]);
        
        $this->output->set_content_type('application_json');

        if ($result) {
            $this->session->set_userdata(['id_user' => $result[0]['id']]);
            $this->session->set_userdata(['id_entity' => $result[0]['id_entity']]);
            $this->session->set_userdata(['name' => $result[0]['username']]);
            $this->output->set_output(json_encode(['result' => 1]));
            $result_entity = $this->entity_model->get([
                'id' => $result[0]['id_entity']
            ]);
            if($result_entity){
                $this->session->set_userdata(['entity'=> $result_entity[0]['name']]);
            }else{
                $this->session->set_userdata(['entity'=> null]);
            }
                
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
                'id' => $id,
                'id_user' => $this->session->userdata('id_user')
            ]);
        } else {
            $result = $this->todo_model->get([
                'id_user' => $this->session->userdata('id_user')
            ]);
        }

        return $result;
    }

    public function get_entity($id = null)
    {

        $this->_require_login();
        
        if ($id != null) {
            $result = $this->entity_model->get([
                'id' => $id,
            ]);
        } else {
            $result = $this->entity_model->get([
                'id' => $this->session->userdata('id_entity')
            ]);
        }

        return $result;
    }
}
?>
    