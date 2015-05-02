<?php

class Finances extends CI_Controller
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

    //-------------------------------- expenses menu ----------------------------  

    public function fin_expenses_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 2; 


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
        $crud->add_action('Add Detail', '', 'finances/fin_expenses_detail_menu/add','ui-icon-flag');
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
        $data['active'] = 'treeview active';
        $data['id'] = 2;

        $crud = new grocery_CRUD();
        if ($this->uri->segment(4)>0){
            $crud->where('fin_expenses.id_expense', $this->uri->segment(4));
            $crud->field_type('id_expense','hidden', $this->uri->segment(4));
        }
        $crud->set_table('fin_expenses_detail');
        $crud->set_theme('datatables'); 
        $crud->set_subject('Expenses Detail');
        
        $crud->set_relation('id_expense', 'fin_expenses', 'description', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('id_item_type', 'fin_expenses_type', 'description', array('id_entity' => $this->session->userdata('id_entity')));
        
        $crud->columns('id','item_description','item_quantity', 'technical_name');
        
        $crud->callback_after_insert(array($this, 'inventory_management'));

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_expenses_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');
        
    }

    public function inventory_management($post_array,$primary_key)
    {  

        $this->load->model('inventory_model');


        if($post_array['id_expense']!=null){
            $type = 'add';
            $id_exp_detail = $primary_key;

            $result = $this->inventory_model->insert([
                'id_exp_detail' => $id_exp_detail,
                'name' => $post_array['brand'],
                'quantity' => $post_array['item_quantity'],
                'lote' => $post_array['package_code'],
                'type' => $type,
                'date_operation' => date("Y-m-d H:i:s"),
                'id_user' => $this->session->userdata('id_user'),
                'id_entity' => $this->session->userdata('id_entity')
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
                'date_operation' => date("Y-m-d H:i:s"),
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
                'date_operation' => date("Y-m-d H:i:s"),
                'id_user' => $this->session->userdata('id_user'),
                'id_entity' => $this->session->userdata('id_entity')
            ]);
        }

/* dependendo do resultado obtido, vai inserir na base de dados como despesa ou utilização,
 * consegue saber se e para adicionar ou  remover a quantidade do stock a partir do 'type' = add or sub
 * PROBLEMA table storage precisa de ter um campo preciso quanto ao nome do item ou atraves do lote,
 * dessa maneira ja se consegue baixar ou aumentar do stock fazendo um distinct na tabela com o sum do stock do mesmo item, já se visualiza tudo correctamente
 */

        if($result){  
            echo "validation Complete";  
        }

    }


    //-------------------------------- expenses type menu ----------------------------  

     public function fin_expenses_type_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 2;

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
        $data['active'] = 'treeview active';
        $data['id'] = 2;

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
        $data['active'] = 'treeview active';
        $data['id'] = 2;

        $crud = new grocery_CRUD();

        $crud->set_table('fin_orders_detail');
        $crud->set_theme('datatables');
        $crud->set_subject('Orders Detail');
        $crud->columns('id_order','item', 'quantity', 'quantity_unit', 'notes');
        $crud->set_relation('id_order', 'fin_orders', 'description', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_relation('item', 'prod_sorts', 'common_name', array('id_entity' => $this->session->userdata('id_entity')));
        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_orders_detail_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }

    public function fin_orders_plants_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 2;

        $crud = new grocery_CRUD();

        $crud->set_table('fin_orders_plants');
        $crud->set_theme('datatables');
        $crud->set_subject('Plants Orders');
        $crud->columns('item','order_date', 'delivery_date', 'plants_quantity', 'notes');
        $crud->set_relation('item', 'prod_sorts', 'common_name', array('id_entity' => $this->session->userdata('id_entity')));
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
        $data['active'] = 'treeview active';
        $data['id'] = 2;

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
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['active'] = 'treeview active';
        $data['id'] = 2;

        $crud = new grocery_CRUD();
        $crud->where('fin_product_type.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity','hidden', $this->session->userdata('id_entity'));
        $crud->set_table('fin_product_type');
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->set_theme('datatables');
        $crud->set_subject('Product Type');
        $crud->columns('type', 'status', 'id_entity', 'id_farm');
        $crud->display_as('id_farm', 'Farm');

        $output = $crud->render();
         
        $header_output = (array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($header_output, $data));
        $this->load->view('dashboard/admin_pages/fin_product_type_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }
}
?>