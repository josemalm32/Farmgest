<?php

class Dashboard extends CI_Controller
{
    // ------------------------------------------------------------------------ 
    
    public function __construct() 
    {
        parent::__construct();

        $user_id = $this->session->userdata('id_user');
        if (!$user_id) {
            $this->logout();
        }

        $this->load->database();
        $this->load->helper('url');
        $this->load->model('fieldsection_model');
        $this->load->model('crud_model');
        
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

    public function test_layout(){
        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 1;
        $data['flag'] = 0;
        $data['farm']=$this->fieldsection_model->get('id_farm => 1');

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/test_view');
        $this->load->view('dashboard/inc/footer_main_view');
    }

    public function testQueryBuilder()
    {
        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 1;
        $data['numRow'] = 0;
        $table = $this->crud_model->getDBtables();

        foreach ($table->result_array() as $key => $row) {
            $info[$key] =array('name'=>$row['table_name']);
        }

        $data['tables']= $info;

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/test_builder_view');
        $this->load->view('dashboard/inc/footer_main_view');
        
    }

    public function tableQuery()
    {
        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 1;
        $tblName = $this->input->post('table');
        $numRows = $this->input->post('numRow');

        $result = $this->crud_model->getDBColumns($tblName);


        foreach($result as $row)
        {
            if($row['column_type']==" ")
                $data['type'] = array_push($row['column_type']);
            
        }

        if($result != null)    
        {
            $data['numRow'] = $numRows;
            $data['columns'] = $result->column_name;
        }

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/test_builder_view');
        $this->load->view('dashboard/inc/footer_main_view');

    }
}
?>
