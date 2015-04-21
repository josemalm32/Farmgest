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
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
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

    //-------------------------------- entity menu ---------------------------- 
    public function entity_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();  

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

    
    //-------------------------------- expenses menu ----------------------------  

     public function fin_expenses_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();  


        $crud = new grocery_CRUD();

        $crud->where('fin_expenses.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));
        $crud->set_table('fin_expenses');
        $crud->set_theme('datatables');
        $crud->set_subject('Expenses');
        
        $crud->columns('id','description','payment_type', 'total_cost');
        
        $crud->set_relation('id_type', 'fin_expenses_type', 'description', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_type', 'Type Expenses');
        $crud->set_relation('id_vendor', 'fin_vendor_client', 'name', array('id_entity' => $this->session->userdata('id_entity'), 'Vendor' => 1));
        $crud->display_as('id_vendor', 'Vendor');
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');
        $crud->add_action('Add Detail', '', 'dashboard/fin_expenses_detail_menu/add');
        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_expenses_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- expenses detail menu ----------------------------  

     public function fin_expenses_detail_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

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
                'relate' => null, // the first dropdown hasn't a relation
                'data-placeholder' => 'select expense'
            ));

        $config = array(
            'main_table' => 'fin_expenses_detail',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_expenses_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }


    //-------------------------------- expenses type menu ----------------------------  

     public function fin_expenses_type_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

        $crud = new grocery_CRUD();

        $crud->where('fin_expenses_type.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));
        $crud->set_table('fin_expenses_type');
        $crud->set_theme('datatables');
        $crud->set_subject('Expenses Type');
        
        $crud->columns('id','description','state', 'type');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');
        
        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);

        $this->load->view('dashboard/inc/header_view',array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_expenses_type_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- orders menu ---------------------------- 

    public function fin_orders_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

        $crud = new grocery_CRUD();

        $crud->where('fin_orders.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));
        $crud->set_table('fin_orders');
        $crud->set_theme('datatables');
        $crud->set_subject('Orders');
        
        $crud->columns('id','notes', 'order_date', 'deliver_date', 'quantity');
        
        $crud->set_relation('id_customer', 'fin_vendor_client', 'name', array('id_entity' => $this->session->userdata('id_entity'), 'Client'=>1));
        $crud->display_as('id_customer', 'Customer');
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_orders_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- orders detail menu ---------------------------- 

    public function fin_orders_detail_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

        $crud = new grocery_CRUD();

        $crud->set_table('fin_orders_detail');
        $crud->set_theme('datatables');
        $crud->set_subject('Orders Detail');
        $crud->columns('id_order','item', 'quantity', 'quantity_unit', 'notes');

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_orders_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    //-------------------------------- vendor/client menu ---------------------------- 

    public function fin_vendor_client_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

        $crud = new grocery_CRUD();
        
        $crud->where('fin_vendor_client.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));

        $crud->set_table('fin_vendor_client');

        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm', 'Farm');

        $crud->set_relation('id_g_contacts', 'g_contacts', 'name');
        $crud->display_as('id_g_contacts', 'Contact');
        
        $crud->set_theme('datatables');
        $crud->set_subject('Vendor/Client');
        $crud->columns('id', 'name', 'Client','Vendor','Other');

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_vendor_client_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

     //-------------------------------- vendor/client menu ---------------------------- 

    public function fin_product_type_menu(){
        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_product_type');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Product Type');
        $crud->columns('type', 'status', 'id_entity', 'id_farm');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');

        $fields = array(
                'id_entity' => array( // first dropdown name
                'table_name' => 'entitys', // table of entitys
                'title' => 'name', // entitys name
                'relate' => null, // the first dropdown hasn't a relation
                'data-placeholder' => 'select entity'
            ),
                'id_farm' => array( // second dropdown name
                'table_name' => 'farms', // table of farms
                'title' => 'name', // farm name
                'id_field' => 'id',
                'relate' => 'id_entity', // relate table entity to table farm, so you can choose one farm from the entity responsible
                'data-placeholder' => 'select farm'
            ));

        $config = array(
            'main_table' => 'fin_product_type',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/fin_product_type_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- contacts menu ---------------------------- 

    public function g_contacts_menu(){
        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_contacts');
        $crud->set_theme('datatables');
        $crud->set_subject('Contacts');
        $crud->columns('id', 'name', 'phone', 'email');

        $output = $crud->render();  
        $header_output = (array)$output;
        unset($header_output['output']);

        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_contacts_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- add field section menu ---------------------------- 

    public function prod_fields_sections_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();

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

        $crud = new grocery_CRUD();
        $crud->set_table('prod_fields');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_season', 'prod_season', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Field');
        $crud->columns('short_code','id_entity', 'id_farm', 'id_season');
        $crud->display_as('short_code','Field');
        $crud->display_as('id_entity','Entity');
        $crud->display_as('id_farm','Farm');
        $crud->display_as('id_season','Season');

        $fields = array(
                'id_entity' => array( // first dropdown name
                'table_name' => 'entitys', // table of entitys
                'title' => 'name', // entitys name
                'relate' => null, // the first dropdown hasn't a relation
                'data-placeholder' => 'select entity'
            ),
                'id_farm' => array( // second dropdown name
                'table_name' => 'farms', // table of farms
                'title' => 'name', // farm name
                'id_field' => 'id',
                'relate' => 'id_entity', // relate table entity to table farm, so you can choose one farm from the entity responsible
                'data-placeholder' => 'select farm'
            )
        );

         $config = array(
            'main_table' => 'prod_fields',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );

        $categories = new gc_dependent_select($crud, $fields, $config);
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/prod_fields_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- sorts menu ---------------------------- 

    public function prod_sorts_menu(){

        $this->_require_login();

        $crud= new grocery_CRUD();


        $crud->where('prod_sorts.id_entity', 1);
        $crud->field_type('id_entity', 'hidden', 1);
        $crud->set_table('prod_sorts');

        $crud->set_theme('datatables');
        $crud->set_subject('Season');
        
        $crud->columns('common_name', 'id_farm', 'id_entity');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => 1));
        $crud->display_as('id_farm','Farm');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
         $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/prod_sorts_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- storage menu ---------------------------- 

     public function prod_storage_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('prod_storage');
        $crud->set_relation('id_season', 'prod_season', 'name');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_user', 'users', 'username');
        $crud->set_relation('id_custumer', 'fin_vendor_client', 'name');
        $crud->set_relation('id_storage', 'prod_storage_house', 'id');
        $crud->set_theme('datatables');
        $crud->set_subject('Production Storage');
        $crud->columns('id','date_in','id_season','id_entity','id_farm','id_user');
        $crud->display_as('id_season', 'Season');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');
        $crud->display_as('id_user', 'User');
        $crud->display_as('id_custumer', 'Customer');
        $crud->display_as('id_storage', 'Storage House');

        $fields = array(
                'id_entity' => array( // first dropdown name
                'table_name' => 'entitys', // table of entitys
                'title' => 'name', // entitys name
                'relate' => null, // the first dropdown hasn't a relation
                'data-placeholder'=> 'Select'
            ),
            'id_farm'=> array(
                'table_name'=>'farms',
                'title' =>'name',
                'id_field'=>'id',
                'relate'=> 'id_entity',
                'data-placeholder'=> 'Select'
            ),
            'id_season'=>array(
                'table_name'=>'prod_season',
                'title' =>'short_code',
                'relate'=> null,
                'data-placeholder'=> 'Select'
            ),
            'id_user' => array(
                'table_name'=>'users',
                'title' => 'username',
                'relate'=> null,
                'data-placeholder'=> 'Select'
            ),
            'id_custumer' => array(
                'table_name'=>'fin_vendor_client',
                'title' => 'username',
                'relate'=> null,
                'data-placeholder'=> 'Select'
            ),
            'id_storage' => array(
                'table_name'=>'prod_storage',
                'title' => 'username',
                'relate'=> null,
                'data-placeholder'=> 'Select'
            )
        );

        $config = array(
            'main_table' => 'prod_storage',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/prod_storage_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- storage house menu ---------------------------- 

    public function prod_storage_house_menu(){

        $this->_require_login();

        $crud= new grocery_CRUD();

        $crud->set_table('prod_storage_house');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Storage House');
        $crud->columns('description', 'id_farm', 'id_entity');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');

        $fields = array(
            'id_entity' => array(
                'table_name'=>'entitys',
                'title'=> 'name',
                'relate'=> null,
                'data-placeholder'=>'select entity'
            ),
            'id_farm'=> array(
                'table_name'=>'farms',
                'title' =>'name',
                'id_field'=>'id',
                'relate'=> 'id_entity',
                'data-placeholder'=> 'select farm'
            )
        );

        $config = array(
            'main_table'=>'prod_storage_house',
            'main_table_primary'=>'id',
            "url"=> base_url().'index.php/'.__CLASS__.'/'.__FUNCTION__.'/'
            );

        $categories= new gc_dependent_select($crud,$fields,$config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.=$js;

        $header_output=(array)$output;
        unset($header_output['output']);
         $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/prod_storage_house_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    //-------------------------------- storage consum menu ---------------------------- 

     public function prod_storage_consum_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('prod_storage_consum');
        $crud->set_relation('id_storage', 'prod_storage_house', 'id');
        $crud->set_theme('datatables');
        $crud->set_subject('Storage Consum');
        $crud->columns('id', 'id_storage', 'date');
        $crud->display_as('id_storage', 'Storage');

        $fields = array(
            'id_storage' => array( 
            'table_name' => 'prod_storage_house', 
            'title' => 'id', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'prod_storage_consum',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/prod_storage_consum_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- changelog menu ---------------------------- 

     public function g_changelog_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_changelog');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('ChangeLogs');
        $crud->columns('id_entity', 'title', 'statuts');
        $crud->display_as('id_entity', 'Entity');

        $fields = array(
            'id_entity' => array( 
            'table_name' => 'entitys', 
            'title' => 'name', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'g_changelog',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_changelog_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- assets category menu ---------------------------- 

     public function g_assets_category_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_assets_category');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Assets Reserve');
        $crud->columns('id_entity', 'title');
        $crud->display_as('id_entity', 'Entity');

        $fields = array(
            'id_entity' => array( 
            'table_name' => 'entitys', 
            'title' => 'name', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'g_assets_category',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_changelog_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- assets category menu ---------------------------- 

     public function g_assets_reserve_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_assets_reserve');
        $crud->set_relation('id_asset', 'g_assets', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('ChangeLogs');
        $crud->columns('id_asset', 'date_start', 'date_end');
        $crud->display_as('id_asset', 'Assets');

        $fields = array(
            'id_asset' => array( 
            'table_name' => 'g_assets', 
            'title' => 'name', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'g_assets_reserve',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_assets_reserve_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- labels menu ---------------------------- 

     public function g_labels_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_labels');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Labels');
        $crud->columns('id_entity', 'label', 'status');
        $crud->display_as('id_entity', 'Entity');

        $fields = array(
            'id_entity' => array( 
            'table_name' => 'entitys', 
            'title' => 'name', 
            'relate' => null 
            ));

        $config = array(
            'main_table' => 'g_labels',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_labels_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


     //-------------------------------- users menu ---------------------------- 

     public function users_menu(){

        $this->_require_login();

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
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/users_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- documents labels menu ---------------------------- 

    public function g_documents_labels_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_documents_labels');
        $crud->set_relation('id_document', 'g_documents', 'title');
        $crud->set_relation('id_label', 'g_labels', 'label');
        $crud->set_theme('datatables');
        $crud->set_subject('Labels');
        $crud->columns('id_document', 'id_label', 'priority');
        $crud->display_as('id_document', 'Document');
        $crud->display_as('id_label', 'g_labels');

        $fields = array(
                'id_document' => array( 
                'table_name' => 'g_documents', 
                'title' => 'title', 
                'relate' => null 
            ),
            'id_label' => array( 
                'table_name' => 'g_labels', 
                'title' => 'label', 
                'relate' => null 
            )
        );

        $config = array(
            'main_table' => 'g_documents_labels',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_documents_labels_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- assets menu ---------------------------- 

    public function g_assets_menu(){

        $this->_require_login();

        $crud= new grocery_CRUD();

        $crud->set_table('g_assets');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_category', 'g_assets_category', 'title');
        $crud->set_theme('datatables');
        $crud->set_subject('Assets');
        $crud->columns('name','id_category', 'id_farm', 'id_entity');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');
        $crud->display_as('id_category', 'Category');

        $fields = array(
            'id_entity' => array(
                'table_name'=>'entitys',
                'title'=> 'name',
                'relate'=> null,
                'data-placeholder'=>'select '
            ),
            'id_farm'=> array(
                'table_name'=>'farms',
                'title' =>'name',
                'id_field'=>'id',
                'relate'=> 'id_entity',
                'data-placeholder'=> 'select '
            ),
            'id_category'=> array(
                'table_name'=>'g_assets_category',
                'title' =>'name',
                'id_field'=>'id',
                'relate'=> 'id_entity',
                'data-placeholder'=> 'select '
            )
        );

        $config = array(
            'main_table'=>'g_assets',
            'main_table_primary'=>'id',
            "url"=> base_url().'index.php/'.__CLASS__.'/'.__FUNCTION__.'/'
            );

        $categories= new gc_dependent_select($crud,$fields,$config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.=$js;

        $header_output=(array)$output;
        unset($header_output['output']);
         $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_assets_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- tasks menu ---------------------------- 

    public function g_tasks_menu(){
        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_tasks');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_season', 'prod_season', 'name');
        $crud->set_relation('id_fields', 'prod_fields', 'short_code');
        $crud->set_relation('id_fields_section', 'prod_fields_sections', 'section_name');
        $crud->set_theme('datatables');
        $crud->set_subject('Tasks');
        $crud->columns('name', 'date_start', 'date_end', 'status','id_entity', 'id_farm', 'id_season');
        $crud->display_as('id_entity','Entity');
        $crud->display_as('id_farm','Farm');
        $crud->display_as('id_season','Season');

        $fields = array(
                'id_entity' => array( // first dropdown name
                'table_name' => 'entitys', // table of entitys
                'title' => 'name', // entitys name
                'relate' => null, // the first dropdown hasn't a relation
                'data-placeholder' => 'select entity'
            ),
                'id_farm' => array( // second dropdown name
                'table_name' => 'farms', // table of farms
                'title' => 'name', // farm name
                'id_field' => 'id',
                'relate' => 'id_entity', // relate table entity to table farm, so you can choose one farm from the entity responsible
                'data-placeholder' => 'select farm'
            ),
                'id_fields' => array( // third dropdown name
                'table_name' => 'prod_fields', // table of season
                'title' => 'short_code', // season name
                'id_field' => 'id',
                'relate' => 'id_farm', 
                'data-placeholder' => 'select season'
                
            ),
                'id_season' => array( // third dropdown name
                'table_name' => 'prod_season', // table of season
                'title' => 'name', // season name
                'id_field' => 'id',
                'relate' => 'id_farm', 
                'data-placeholder' => 'select season'
            ),
                'id_fields_section' => array( // third dropdown name
                'table_name' => 'prod_fields_sections', // table of season
                'title' => 'section_name', // season name
                'id_field' => 'id',
                'relate' => 'fields', 
                'data-placeholder' => 'select season'
            )
        );

         $config = array(
            'main_table' => 'g_tasks',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );

        $categories = new gc_dependent_select($crud, $fields, $config);
        
        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_tasks_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    //-------------------------------- tasks users menu ---------------------------- 

    public function g_tasks_users_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_tasks_users');
        $crud->set_relation('id_task', 'g_tasks', 'name');
        $crud->set_relation('id_user', 'users', 'username');
        $crud->set_theme('datatables');
        $crud->set_subject('User Task');
        $crud->columns('id_user', 'id_task', 'priority');
        $crud->display_as('id_user', 'User');
        $crud->display_as('id_task', 'Task');

        $fields = array(
                'id_task' => array( 
                'table_name' => 'g_tasks', 
                'title' => 'name', 
                'relate' => null 
            ),
            'id_user' => array( 
                'table_name' => 'users', 
                'title' => 'username', 
                'relate' => null 
            )
        );

        $config = array(
            'main_table' => 'g_tasks_users',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_documents_labels_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

     //-------------------------------- alarms menu ---------------------------- 

    public function g_alarms_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_alarms');
        $crud->set_theme('datatables');
        $crud->set_subject('Alarms');
        $crud->columns('id', 'type');
        
        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_alarms_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


     //-------------------------------- documents menu ---------------------------- 

    public function g_documents_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_documents');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_relation('id_user', 'users', 'username');
        $crud->set_theme('datatables');
        $crud->set_subject('Documents');
        $crud->columns('title','id_user', 'id_entity', 'id_farm');
        $crud->display_as('id_user', 'User');
        $crud->display_as('id_entity', 'Entity');
        $crud->display_as('id_farm', 'Farm');


        $fields = array(
            'id_entity' => array( 
                'table_name' => 'entitys', 
                'title' => 'name', 
                'relate' => null 
            ),
            'id_farm' => array( // second dropdown name
                'table_name' => 'farms', // table of farms
                'title' => 'name', // farm name
                'id_field' => 'id',
                'relate' => 'id_entity', // relate table entity to table farm, so you can choose one farm from the entity responsible
                'data-placeholder' => 'select farm'
            )
        );

        $config = array(
            'main_table' => 'g_documents',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_documents_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


     //-------------------------------- menus ---------------------------- 

    public function g_menus_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('g_menus');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('Menus');
        $crud->columns('title','link','status', 'id_master', 'id_user_role');


        $fields = array(
                'id_entity' => array( 
                'table_name' => 'entitys', 
                'title' => 'name', 
                'relate' => null 
            ),
            'id_farm' => array( 
                'table_name' => 'farms', 
                'title' => 'username', 
                'relate' => null 
            )
        );

        $config = array(
            'main_table' => 'g_menus',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/g_menus_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

     //-------------------------------- rep config menu ---------------------------- 

    public function rep_configuration_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('rep_configuration');
        $crud->set_relation('id_entity', 'entitys', 'name');
        $crud->set_relation('id_farm', 'farms', 'name');
        $crud->set_theme('datatables');
        $crud->set_subject('User Task');
        $crud->columns('query_code', 'status');


        $fields = array(
                'id_entity' => array( 
                'table_name' => 'entitys', 
                'title' => 'name', 
                'relate' => null 
            ),
            'id_farm' => array( 
                'table_name' => 'farms', 
                'title' => 'username', 
                'relate' => null 
            )
        );

        $config = array(
            'main_table' => 'rep_configuration',
            'main_table_primary' => 'id',
            "url" => base_url() .'index.php/'. __CLASS__ . '/' . __FUNCTION__ . '/' //path to method
        );
        $categories = new gc_dependent_select($crud, $fields, $config);

        $js = $categories->get_js();
        $output = $crud->render();
        $output->output.= $js; 

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', $header_output);
        $this->load->view('dashboard/admin_pages/rep_configuration_view',$output);
        $this->load->view('dashboard/inc/footer_view');
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
