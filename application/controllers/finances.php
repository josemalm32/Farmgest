<?php
 
class Finances extends CI_Controller
{
    //------------------------------------------------------------------------------------------------
    // no construtor tem sempre que se fazer load do models aqui, caso contrario 
    // nao os consegues utilizar se apenas fizer load na funçao
    // na construçao do controller verifica se esta logado o utilizador
    //------------------------------------------------------------------------------------------------
    
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
        $this->load->model('report_model');
        $this->load->library('grocery_CRUD');
        $this->load->model('crud_model');
        
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

    //------------------------------------------------------------------------------------------------
    // require_login, necessita de estar logado para ver a pagina
    // vai buscar a funçao ao controlador get_todo, para apresentar na vista a lista de tasks
    // como se trabalha com o grocery crud nesta pagina e interfere com o javascript desenvolvido, necessita-se de ter 
    // a variavel active para saber qual dos modulos está activo
    // 1 - dashboard
    // 2 - finances
    // 3 - rastreability
    // 4 - operations
    // 5 - configuration
    // A variavel query é utilizada para definir o modulo e os reports agregados aquele modulo
    // queryFinances = Finances ou queryRastreability = Rastreability
    //------------------------------------------------------------------------------------------------

    public function fin_expenses_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // menu para adicionar detalhes das despesas, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    // com o pequeno pormenor, se for para adicionar novo registo apartir do das tabela despesas
    // nao existe a necessidade de escolher a despesa, porque já vai ser preenchida pelo sistema 
    // atraves do uri(4), isto é, passa-se o id pelo url e guarda-se na tabela para inserção escondendo o campo para preenchimento
    //------------------------------------------------------------------------------------------------

     public function fin_expenses_detail_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // funçao destinada a automaticamente aumentar ou diminuir o stock existente apartir da inserção de novas
    // despesas, que quer dizer, que se comprou algum tipo de bem, esse mesmo e aumentado no stock, 
    // onde qualquer tipo de tratamento ou fertilizaçao utilizado, irá fazer com que seja descontado no stock existente
    //------------------------------------------------------------------------------------------------

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

/*  dependendo do resultado obtido, vai inserir na base de dados como despesa ou utilização,
 *  consegue saber se e para adicionar ou  remover a quantidade do stock a partir do 'type' = add or sub
 *  PROBLEMA table storage precisa de ter um campo preciso quanto ao nome do item ou atraves do lote,
 *  dessa maneira ja se consegue baixar ou aumentar do stock fazendo um distinct na tabela com o sum do stock do mesmo item, já se visualiza tudo correctamente
 */

        if($result){  
            echo "validation Complete";  
        }

    }


    //------------------------------------------------------------------------------------------------
    // menu para adicionar um tipo de despesa, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

     public function fin_expenses_type_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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


    //------------------------------------------------------------------------------------------------
    // menu para adicionar encomendas, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function fin_orders_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // menu para adicionar os detalhes da encomenda, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function fin_orders_detail_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // menu para adicionar encomenda de plantas, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function fin_orders_plants_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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


    //------------------------------------------------------------------------------------------------
    // menu para adicionar vendedores ou clientes, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function fin_vendor_client_menu(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // menu para adicionar tipo de produtos, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------ 

    public function fin_product_type_menu(){
         $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
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

    //------------------------------------------------------------------------------------------------
    // faz uma listagem de todas os report existentes para este modulo (queryFinances)
    //------------------------------------------------------------------------------------------------
    
    public function get_query($query_code=null)
    {
        if ($query_code != null) {
            $result = $this->report_model->get([
                'query_code' => $query_code,
                'status' => 'active'
            ]);
            return $result;
        }
        return  null;
    }


    //------------------------------------------------------------------------------------------------
    // verifica o id se encontra a null, caso se encontre a null, quer dizer que ja foi feita uma query inicial,
    // caso contrario, encontra-se a fazer pela primeira vez, isto é, se for executada um dos reports 
    // atraves da lista no canto superior direito, faz com que seja guardado o id desse report, 
    // para caso se queira fazer alterações, adicionando restrições seja só pegar na 
    // query inicial adicionando as restriçoes introduzidas, depois dessa verificação
    // se o report já foi feito, grava-se o excel criado na root da pasta publica e manda-se para a 
    // respectiva view
    //------------------------------------------------------------------------------------------------
    public function test_query($id=null){
         $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryFinances';
        $data['query'] = $this->get_query($query);
        $data['active'] = 'treeview active';
        $data['id'] = 2;

        if ($id==null)
            $result = $this->report_model->get($this->session->userdata('id_report'));
        else
            $result = $this->report_model->get($id);

        
        if ($result[0]['type'] == 'excel' ){
            $result = $this->report_model->export_excel($id);

            if ($result!=null){
                foreach($result as $row){
                    $newfile = FCPATH."report.xls";
                    $file = $row;
                    if(copy($file, $newfile)){      
                        $data['file'] = "successExcel";
                    }
                }
                
            }
            else{
                $data['file'] = null;
            }

            $this->load->view('dashboard/inc/header_main_view',$data);
            $this->load->view('dashboard/admin_pages/report_view');
            $this->load->view('dashboard/inc/footer_main_view');  
        }else if ($result[0]['type']=='word'){

            $result = $this->report_model->export_word($id);

            if ($result!=null){
                $newfile = FCPATH."report.docx";
                $data['file'] = "successWord";     
            }
            else{
                $data['file'] = null;
            }
            $this->load->view('dashboard/inc/header_main_view',$data);
            $this->load->view('dashboard/admin_pages/report_view');
            $this->load->view('dashboard/inc/footer_main_view');
        }
        
    }

    //------------------------------------------------------------------------------------------------
    // apresenta a view com o numero de restriçoes a serem introduzidas e o link para download do report
    //------------------------------------------------------------------------------------------------

    public function tableQuery()
    {
        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 2;
        $data['active'] = 'treeview active';

        $result=$this->report_model->get($this->session->userdata('id_report'));
        $pieces = explode(" ",$result[0]['query_sql']);
       

        for($i=0; $i<count($pieces); $i++)
        {
            if(strcmp("FROM",$pieces[$i])){
                $i++;
                $tblName = $pieces[$i];
            }
        }
        $numRows = $this->input->post('numRow');

        $allColumns = $this->crud_model->getDBColumns($tblName);
        
        foreach ($allColumns->result_array() as $key => $row) {
            $dataColumns[$key] =array('name'=>$row['column_name'], 'type'=>$row['data_type']);
        }

        $data['numRow'] = $numRows;
        $data['nameColumns'] = $dataColumns;
        

        $data['type'] = array("<",">","<=",">=","=","!=", "like");

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/test_builder_view');
        $this->load->view('dashboard/inc/footer_main_view');

    }

    
    //------------------------------------------------------------------------------------------------
    // trata a informação relevante as restriçoes introduzidas pelo utilizador, como o numero de restriçoes
    // e as restriçoes efectuadas, gerando o report e apresenta o link para download voltando ao controller test_query
    //------------------------------------------------------------------------------------------------

    public function transformQuery(){
        $columnTable = array();
        $typeColumn = array();
        $insertedValue = array();
        $query = " ";
        $this->_require_login();
        $j=0;

        $data['id'] = 2;
        $data['active'] = 'treeview active';

        $maxCol = $this->input->post('nRow');

        for($i=0; $i<$maxCol; $i++){
            $ColumnName= explode(" ",$this->input->post('column'.$i));

            $columnTable[$i] = $ColumnName[0];
            //echo $columnTable[$i], " - ";
            $typeColumn[$i] = $this->input->post('data'.$i);
            //echo $typeColumn[$i], " - ";
            $insertedValue[$i] = $this->input->post('restriction'.$i);
            //echo $insertedValue[$i], " - ";
        }
     
        $result=$this->report_model->get($this->session->userdata('id_report'));

        $pieces = explode(" ",$result[0]['query_sql']);
        $allPieces = count($pieces);

        for($a=0; $a < $allPieces; $a++)
        {
            if(strcmp("WHERE",$pieces[$a]) || strcmp("where", $pieces[$a]))
                $j = $a;
        }

        if($j==0){
            $query = $result[0]['query_sql'].' WHERE ';
        }else{

            for($q = 0; $q<=$j; $q++){
                $aux = $query.' '.$pieces[$q].' ';
                $query = $aux;  
            }
        }
        
        $query = $query.' WHERE ';
        for ($k = 0; $k<$maxCol; $k++){
            if($insertedValue != null)
            {
                if($k == $maxCol-1)
                    $query .= $columnTable[$k]." ".$typeColumn[$k]." ".$insertedValue[$k];
                else
                    $query .= $columnTable[$k]." ".$typeColumn[$k]." ".$insertedValue[$k]." AND ";
            }
        }
        //echo $query;
        $this->session->set_userdata(['query' => $query]);
        $this->test_query();
    }

}
?>