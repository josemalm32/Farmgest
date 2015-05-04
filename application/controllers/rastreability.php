<?php

class Rastreability extends CI_Controller
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
        $this->load->model('report_model');
        $this->load->model('grocery_CRUD_model');
        $this->load->model('inventory_model');
        $this->load->library('grocery_CRUD');
        
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

    //-------------------------------- season menu ---------------------------- 

    public function prod_season_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud = new grocery_CRUD();


        $crud->where('prod_season.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('prod_season');
       
        $crud->set_relation_n_n('template', 'prod_season_template', 'prod_template', 'id', 'id', 'name');

        $crud->set_theme('datatables'); 
        $crud->set_subject('Season');
        
        $crud->columns('name','start_date', 'end_date', 'status', 'production_type', 'id_farm');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('production_type','prod_sorts','common_name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('production_type','Poduction Type');
        
        //$crud->fields('name','start_date', 'end_date', 'status', 'production_type', 'id_farm', 'expected_yeld', 'expected_yeld_unit', 'expected_income', 'n_plants', 'template');
        $crud->add_action('Add Problem', '', 'rastreability/prod_season_problems_menu/add', 'ui-icon-alert');
        $crud->add_action('Add Action', '', 'rastreability/prod_season_problems_actions_menu/add', 'ui-icon-flag');
        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

     //-------------------------------- fertilization menu ---------------------------- 

    public function prod_fertilization_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud= new grocery_CRUD();

        $crud->where('prod_fertilization.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->where('prod_fertilization.id_user', $this->session->userdata('id_user'));
        $crud->field_type('id_user', 'hidden', $this->session->userdata('id_user'));
        $crud->display_as('id_user','User');
        
        $crud->set_table('prod_fertilization');

        $crud->set_theme('datatables');
        $crud->set_subject('Fertilization');
        
        $crud->columns('type', 'date', 'id_user', 'id_farm');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');

        $crud->callback_after_insert(array($this, 'inventory_management'));
        
        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_fertilization_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- season problems menu ---------------------------- 

    public function prod_season_problems_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud= new grocery_CRUD();


        $crud->set_table('prod_season_problems');

        $crud->set_theme('datatables');
        $crud->set_subject('Season Problem');
        
        $crud->columns('id_season','name', 'type');
        
        $crud->set_relation('id_season', 'prod_season', 'name');
        $crud->display_as('id_season', 'Season');

        $crud->add_action('Add Action', '', 'rastreability/prod_season_problems_actions_fieldsection_menu/add', 'ui-icon-flag');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_problems_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    

    //-------------------------------- season treatment  menu ---------------------------- 

    public function prod_treatment_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud= new grocery_CRUD();

        $crud->where('prod_treatment.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('prod_treatment');

        $crud->set_theme('datatables');
        $crud->set_subject('Season Treatment');
        
        $crud->columns('name','active_substance', 'security_interval', 'persistence', 'id_entity', 'id_farm');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('id_problem_action','prod_season_problems_actions','type');
        $crud->display_as('id_problem_action','Problem Type');
       
        $crud->set_relation('id_season', 'prod_season', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_season','Season');

        $crud->callback_after_insert(array($this, 'inventory_management'));
       
        $output = $crud->render();
     
        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_treatment_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- season harvast  menu ---------------------------- 

    public function prod_season_harvast_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud = new grocery_CRUD();

        $crud->where('prod_season_harvast.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('prod_season_harvast');
        $crud->set_theme('datatables');
        $crud->set_subject('Season Harvast');
        
        $crud->columns('id_entity', 'id_farm', 'id_field', 'id_field_section', 'id_season', 'id_sort', 'harv_start_date', 'harv_end_date');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('id_season', 'prod_season', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');

        $crud->set_relation('id_field_section','prod_fields_sections','section_name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_field_section','FieldSection');
        
        $crud->set_relation('id_field','prod_fields','short_code', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_field','Field');     

        $crud->set_relation('id_sort', 'prod_sorts', 'technical_name', array('id_entity' => $this->session->userdata('id_entity')));   
        $crud->display_as('id_sort', 'Technical Name');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_harvast_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    //-------------------------------- seson problems actions menu ---------------------------- 

     public function prod_season_problems_actions_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 3;


        $crud= new grocery_CRUD();


        $crud->set_table('prod_season_problems_actions');

        $crud->set_theme('datatables');
        $crud->set_subject('Season Problem Action');
        
        $crud->columns('id_season', 'type', 'date_start', 'date_end');
        
        $crud->set_relation('id_season', 'prod_season', 'name');
        $crud->display_as('id_season', 'Season');

        $output = $crud->render();

        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_problems_actions_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }

    public function inventory_management($post_array,$primary_key)
    {  

        if($post_array['id_expense']!=null){
            $type = 'add';
            $id_exp_detail = $primary_key;

            $result = $this->inventory_model->insert([
                'id_exp_detail' => $id_exp_detail
            ]);
        }else if ($post_array['name']!=null){
            $type = 'sub';
            $id_treatment = $primary_key;

            $result = $this->inventory_model->insert([
                'id_treatment' => $id_treatment,
                'name' => $post_array['name'],
                'quantity' => $post_data['recomended_dose'],
                'lote' => $post_array['id_package'],
                'type' => $type,
                'date' => date(),
                'id_user' => $this->session->userdata('id_user'),
                'id_entity' => $this->session->userdata('id_entity')
            ]);
        }else{
            $type = 'sub';
            $id_fertilization = $primary_key;

            $result = $this->inventory_model->insert([
                'id_fertilization' => $id_fertilization,
                'name' => $post_data['name'],
                'quantity' => $post_data['quantity'],
                'lote' => $post_data['id_package'],
                'type' => $type,
                'date' => date(),
                'id_user' => $this->session->userdata('id_user'),
                'id_entity' => $this->session->userdata('id_entity')
            ]);
        }

        if($result){
            echo "validation Complete";
        }

    }

    public function reports($query_code=null)  //-------------- FALTA AINDA METER A FARM
    {
        $this->_require_login();
        
        if ($query_code!=null) {
            $result = $this->report_model->get([
                'id_entity' => $this->session->userdata('id_entity'),
                'query_code' => $query_code
            ]);
        } else{
            $result = null;
        }

        return $result;
    }

}
?>