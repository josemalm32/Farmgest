<?php

class Configuration extends CI_Controller
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

        //-------------------------------- entity menu ---------------------------- 
    public function entity_menu(){

        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo(); 
        $data['active'] = 'treeview active';
        $data['id'] = 5;  

        $crud = new grocery_CRUD();
        $crud->set_table('entitys');
        $crud->set_theme('datatables');
        $crud->set_subject('Entity');
        $crud->columns('id','name','email');
        
        $output = $crud->render();  
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/entity_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- farm menu ---------------------------- 

     public function farm_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo(); 
        $data['active'] = 'treeview active';
        $data['id'] = 5;  

        $crud = new grocery_CRUD();

        $crud->where('farms.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));
        $crud->set_table('farms');
        $crud->set_theme('datatables');
        $crud->set_subject('Farm');
        
        $crud->columns('name','location', 'production_type', 'main_culture');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/farm_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


    //-------------------------------- add field section menu ---------------------------- 

    public function prod_fields_sections_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud = new grocery_CRUD();
        
        $crud->where('prod_fields_sections.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));

        $crud->set_table('prod_fields_sections');

        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');

        $crud->set_relation('id_field', 'prod_fields', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_field', 'Field');
        
        $crud->set_theme('datatables');
        $crud->set_subject('Field Section');
        $crud->columns('section_name','id_entity', 'id_farm', 'id_field');

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/prod_fields_sections_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- add field menu ---------------------------- 

    public function prod_fields_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud = new grocery_CRUD();

        $crud->where('prod_fields.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));

        $crud->set_table('prod_fields');

        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');

        $crud->set_theme('datatables');
        $crud->set_subject('Field');
        
        $crud->columns('short_code','id_entity', 'id_farm');
        $crud->display_as('short_code','Field');
        
        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_fields_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- sorts menu ---------------------------- 

    public function prod_sorts_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('prod_sorts.id_entity', 1);
        $crud->field_type('id_entity', 'hidden', 1);
        $crud->set_table('prod_sorts');

        $crud->set_theme('datatables');
        $crud->set_subject('Sorts');
        
        $crud->columns('common_name', 'id_farm', 'id_entity');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => 1));
        $crud->display_as('id_farm','Farm');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_sorts_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    
    //-------------------------------- storage house menu ---------------------------- 

    public function prod_storage_house_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('prod_storage_house.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('prod_storage_house');

        $crud->set_theme('datatables');
        $crud->set_subject('Storage House');
        
        $crud->columns('description', 'id_farm', 'id_entity');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_storage_house_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    //-------------------------------- changelog menu ---------------------------- 

     public function g_changelog_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('g_changelog.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('g_changelog');

        $crud->set_theme('datatables');
        $crud->set_subject('ChangeLogs');
        
        $crud->columns('id_entity', 'title', 'statuts');
        $crud->display_as('id_entity', 'Entity');


        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_changelog_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- assets category menu ---------------------------- 

     public function g_assets_category_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 


        $crud= new grocery_CRUD();

        $crud->where('g_assets_category.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('g_assets_category');

        $crud->set_theme('datatables');
        $crud->set_subject('Assets Category');
        
        $crud->columns('id_entity', 'title');
        $crud->display_as('id_entity', 'Entity');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_changelog_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- labels menu ---------------------------- 

     public function g_labels_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('g_labels.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('g_labels');

        $crud->set_theme('datatables');
        $crud->set_subject('Labels');
        
        $crud->columns('id_entity', 'label', 'status');
        $crud->display_as('id_entity', 'Entity');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_labels_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


     //-------------------------------- users menu ---------------------------- 

     public function users_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud = new grocery_CRUD();
        $crud->set_table('users');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('User');
        $crud->columns('id_entity', 'username', 'date_added', 'type');
        $crud->display_as('id_entity', 'Entity');

        $fields = array(
            'id_entity' => array( 
            'table_name' => 'entitys', 
            'title' => 'name', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'users',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/users_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    

    //-------------------------------- assets menu ---------------------------- 

    public function g_assets_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('g_assets.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('g_assets');

        $crud->set_theme('datatables');
        $crud->set_subject('Storage House');
        
        $crud->columns('name','id_category', 'id_farm', 'id_entity');

        $crud->set_relation('id_category', 'g_assets_category', 'title', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');
        $crud->display_as('id_category', 'Category');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_assets_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }
    

     //-------------------------------- menus ---------------------------- 

    public function g_menus_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 


        $crud= new grocery_CRUD();

        $crud->where('g_menus.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('g_menus');

        $crud->set_theme('datatables');
        $crud->set_subject('Menu');
        
        $crud->columns('title','link','status', 'id_master');

        $crud->where('g_menus.id_user_role', $this->session->userdata('id_user'));
        $crud->field_type('id_user_role', 'hidden', $this->session->userdata('id_user'));

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/g_menus_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

     //-------------------------------- rep config menu ---------------------------- 

    public function rep_configuration_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 5; 

        $crud= new grocery_CRUD();

        $crud->where('rep_configuration.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('rep_configuration');

        $crud->set_theme('datatables');
        $crud->set_subject('Repositorium Configuration');
        
        $crud->columns('query_code', 'status');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/rep_configuration_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    
}
?>