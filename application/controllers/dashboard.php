<?php

class Dashboard extends CI_Controller
{
    private $limit = 10;
    // ------------------------------------------------------------------------ check
    
    public function __construct() 
    {
        parent::__construct();

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
    
    // ------------------------------------------------------------------------ check
    
    public function index()
    {
        $this->load->view('dashboard/inc/header_view', (object)array('js_files' => array() , 'css_files' => array()));
        $this->load->view('dashboard/admin_pages/dashboard_view');
        $this->load->view('dashboard/inc/footer_view');
    }
    
    // ------------------------------------------------------------------------ check
     
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('/');
    }

    // ------------------------------------------------------------------------ check
    
    private function _require_login()
    {
        if ($this->session->userdata('id_user') == false) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized.']));
            return false;
        }
    }

    //-------------------------------- entity menu ---------------------------- check
    public function entity_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('entitys');
        $crud->set_theme('datatables');
        $crud->set_subject('Entity');
        $crud->columns('id','name','email');
        
        $output = $crud->render();  
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/entity_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- farm menu ---------------------------- check

     public function farm_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('farms');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Farm');
        $crud->columns('id','name','location', 'production_type', 'main_culture');

        $fields = array(
            'id_entity' => array( // first dropdown name
            'table_name' => 'entitys', // table of entitys
            'title' => 'name', // entitys name
            'relate' => null // the first dropdown hasn't a relation
            ));

        $config = array(
            'main_table' => 'farms',
            'main_table_primary' => 'id',
            "url" => base_url() . __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/farm_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    
    //-------------------------------- expenses menu ----------------------------  check

     public function fin_expenses_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses');
        $crud->set_theme('datatables');
        $crud->set_subject('Expenses');
        $crud->columns('id','description','payment_type', 'total_cost');
        
        $output = $crud->render();  
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/fin_expenses_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- expenses detail menu ----------------------------  check

     public function fin_expenses_detail_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses_detail');
        $crud->set_relation('id_expense', 'fin_expenses', 'description');
        $crud->set_theme('datatables');
        $crud->set_subject('Expenses Detail');
        $crud->columns('id','item_description','item_quantity', 'technical_name');
        
         $fields = array(
            'id_expense' => array( // first dropdown name
            'table_name' => 'fin_expenses', // table of entitys
            'title' => 'description', // entitys name
            'relate' => null // the first dropdown hasn't a relation
            ));

        $config = array(
            'main_table' => 'fin_expenses_detail',
            'main_table_primary' => 'id',
            "url" => base_url() . __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/fin_expenses_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }


    //-------------------------------- expenses type menu ----------------------------  check

     public function fin_expenses_type_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses_type');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Expenses Type');
        $crud->columns('id','description','state', 'type');
        
         $fields = array(
            'id_entity' => array( // first dropdown name
            'table_name' => 'entitys', // table of entitys
            'title' => 'name', // entitys name
            'relate' => null // the first dropdown hasn't a relation
            ),
            'id_farm' => array( // second dropdown name
            'table_name' => 'farms', // table of farms
            'title' => 'name', // farm name
            'id_field' => 'id',
            'relate' => 'id_entity', // relate table entity to table farm, so you can choose one farm from the entity responsible
            'data-placeholder' => 'select farm'
            ));

        $config = array(
            'main_table' => 'fin_expenses_type',
            'main_table_primary' => 'id',
            "url" => base_url() . __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/fin_expenses_type_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

}