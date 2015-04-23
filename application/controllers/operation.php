<?php

class Operation extends CI_Controller
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

    //-------------------------------- storage menu ---------------------------- 

     public function prod_storage_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();

        $crud->where('prod_storage.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->where('prod_storage.id_user', $this->session->userdata('id_user'));
        $crud->field_type('id_user', 'hidden', $this->session->userdata('id_user'));
        $crud->set_table('prod_storage');
        $crud->set_theme('datatables');
        $crud->set_subject('Season Harvast');
        
        $crud->columns('id','date_in','id_season','id_entity','id_farm','id_user');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('id_season', 'prod_season', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('id_storage','prod_storage_house','description', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_storage','Field');     

        $crud->set_relation('id_custumer', 'fin_vendor_client', 'name', array('id_entity' => $this->session->userdata('id_entity'), 'Client' => 1));   
        $crud->display_as('id_custumer', 'Customer');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_storage_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- storage consum menu ---------------------------- 

     public function prod_storage_consum_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->set_table('prod_storage_consum');
        $crud->set_theme('datatables');
        $crud->set_subject('Storage Consum');
        
        $crud->columns('id', 'id_storage', 'date');
        
        $crud->set_relation('id_storage','prod_storage_house','description');
        $crud->display_as('id_storage','Storage House');  

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_storage_consum_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }
    
    //-------------------------------- documents labels menu ---------------------------- 

    public function g_documents_labels_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->set_table('prod_storage_consum');
        $crud->set_theme('datatables');
        $crud->set_subject('Labels');
        
        $crud->columns('id_document', 'id_label', 'priority');
        
        $crud->set_relation('id_document','g_documents','title',array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_label', 'g_labels', 'label',array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_document', 'Document');
        $crud->display_as('id_label', 'g_labels'); 

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_documents_labels_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- tasks menu ---------------------------- 

    public function g_tasks_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->where('g_tasks.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));

        $crud->set_table('g_tasks');
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_season', 'prod_season', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_fields', 'prod_fields', 'short_code', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_fields_section', 'prod_fields_sections', 'section_name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_theme('datatables');
        $crud->set_subject('Tasks');
        $crud->columns('name', 'date_start', 'date_end', 'status','id_entity', 'id_farm', 'id_season');
        $crud->display_as('id_entity','Entity');
        $crud->display_as('id_farm','Farm');
        $crud->display_as('id_season','Season');
  
        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_tasks_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- tasks users menu ---------------------------- 

    public function g_tasks_users_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->where('g_tasks_users.id_user', $this->session->userdata('id_user'));
        $crud->field_type('id_user', 'hidden', $this->session->userdata('id_user'));

        $crud->set_table('g_tasks_users');
        $crud->set_relation('id_task', 'g_tasks', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_theme('datatables');
        $crud->set_subject('User Task');
        $crud->columns('id_user', 'id_task', 'priority');
        $crud->display_as('id_user', 'User');
        $crud->display_as('id_task', 'Task');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_tasks_users_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


    //-------------------------------- alarms menu ---------------------------- 

    public function g_alarms_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->set_table('g_alarms');
        $crud->set_theme('datatables');
        $crud->set_subject('Alarms');
        $crud->columns('id', 'type');
        
        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_alarms_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


     //-------------------------------- documents menu ---------------------------- 

    public function g_documents_menu(){

        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();

        $crud->where('prod_storage.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->where('prod_storage.id_user', $this->session->userdata('id_user'));
        $crud->field_type('id_user', 'hidden', $this->session->userdata('id_user'));

        $crud->set_table('g_documents');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Documents');

        $crud->columns('title','id_user', 'id_entity', 'id_farm');

        $crud->display_as('id_user', 'User');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_documents_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- contacts menu ---------------------------- 

    public function g_contacts_menu(){

        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->set_table('g_contacts');
        $crud->set_theme('datatables');
        $crud->set_subject('Contacts');
        $crud->columns('id', 'name', 'phone', 'email');

        $output = $crud->render();  
        $header_output = (array)$output;
        unset($header_output['output']);

        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_contacts_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }
    
    //-------------------------------- assets category menu ---------------------------- 

     public function g_assets_reserve_menu(){

        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 4; 

        $crud = new grocery_CRUD();
        $crud->set_table('g_assets_reserve');
        $crud->set_relation('id_asset', 'g_assets', 'name',array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_theme('datatables');
        $crud->set_subject('ChangeLogs');
        $crud->columns('id_asset', 'date_start', 'date_end');
        $crud->display_as('id_asset', 'Assets');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_assets_reserve_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


}
?>
