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
    }
    
    // ------------------------------------------------------------------------ check
    
    public function index()
    {
        $this->load->view('dashboard/inc/header_view');
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
        $crud->columns('id','name','email');
        
        $output = $crud->render();  

        $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/entity_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- farm menu ---------------------------- check

     public function farm_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('farms');
        $crud->set_theme('datatables');
        $crud->columns('id','name','location', 'production_type', 'main_culture');
        
        $output = $crud->render();  

         $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/farm_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    
    //-------------------------------- expenses menu ----------------------------  check

     public function fin_expenses_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses');
        $crud->set_theme('datatables');
        $crud->columns('id','description','payment_type', 'total_cost');
        
        $output = $crud->render();  
         
        $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/fin_expenses_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    //-------------------------------- expenses detail menu ----------------------------  check

     public function fin_expenses_detail_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses_detail');
        $crud->set_theme('datatables');
        $crud->columns('id','item_description','item_quantity', 'technical_name');
        
        $output = $crud->render();  
         
        $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/fin_expenses_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }


    //-------------------------------- expenses type menu ----------------------------  check

     public function fin_expenses_type_menu(){

        $this->_require_login();

        $crud = new grocery_CRUD();
        $crud->set_table('fin_expenses_type');
        $crud->set_theme('datatables');
        $crud->columns('id','description','state', 'type');
        
        $output = $crud->render();  
         
        $this->load->view('dashboard/inc/header_view');
        $this->load->view('dashboard/admin_pages/fin_expenses_type_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

}