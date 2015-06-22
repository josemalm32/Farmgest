<?php

class Rastreability extends CI_Controller
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
        $this->load->model('problem_fieldsection_model');
        $this->load->model('report_model');
        $this->load->model('fieldsection_model');
        $this->load->model('grocery_CRUD_model');
        $this->load->model('inventory_model');
        $this->load->model('prod_season_problem_model');
        $this->load->model('prod_season_fields_sections_model');
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
    //------------------------------------------------------------------------------------------------


    //------------------------------------------------------------------------------------------------
    // menu para adicionar seasons, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function prod_season_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        $data['query'] = $this->get_query($query);
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud = new grocery_CRUD();


        $crud->where('prod_season.id_entity', $this->session->userdata('id_entity'));
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->set_table('prod_season');
       
        $crud->set_relation_n_n('season_fields', 'prod_season_fields_sections', 'prod_fields_sections', 'id_season', 'id_fields_section', 'section_name');

        $crud->set_theme('datatables'); 
        $crud->set_subject('Season');
        
        $crud->columns('name','start_date', 'end_date', 'status', 'production_type', 'id_farm');
        
        $crud->set_relation('id_farm', 'farms', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('id_farm','Farm');
        
        $crud->set_relation('production_type','prod_sorts','common_name', array('id_entity' => $this->session->userdata('id_entity')));
        $crud->display_as('production_type','Poduction Type');
        
        $crud->fields('name','start_date', 'end_date', 'status', 'production_type', 'id_farm', 'expected_yeld', 'expected_yeld_unit', 'expected_income', 'n_plants', 'season_fields');
        $crud->add_action('Add Problem', '', 'rastreability/apply_problem', 'ui-icon-alert');
        $crud->add_action('Add Action', '', 'rastreability/prod_season_problems_actions_menu/add', 'ui-icon-flag');
        $crud->add_action('Add Treatment', '', 'dashboard/test_layout', 'ui-icon-alert');
        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_view',$output);
        $this->load->view('dashboard/inc/footer_view');
    }


    //------------------------------------------------------------------------------------------------------------------------------------------
    // menu para adicionar fertilizantes, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------------------------------------------------

    public function prod_fertilization_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        
        $data['query'] = $this->get_query($query);
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


    //------------------------------------------------------------------------------------------------
    // menu para adicionar um tipo de despesa, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function prod_season_problems_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';

        $data['query'] = $this->get_query($query);
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud= new grocery_CRUD();


        $crud->set_table('prod_season_problems');

        $crud->set_theme('datatables');
        $crud->set_subject('Season Problem');
        
        $crud->columns();

        if($this->uri->segment(4)!=null)
            $crud->field_type('id_season', 'hidden', $this->uri->segment(4));
        else{
            $crud->set_relation('id_season', 'prod_season', 'name');
            $crud->display_as('id_season', 'Season');
        }
        
        $crud->set_relation_n_n('problem_section', 'prod_problem_section', 'prod_season_fields_sections', 'id_problem' , 'id_season', 'section_name', 'id_field_section');

        $crud->add_action('Add Action', '', 'rastreability/prod_season_problems_actions_fieldsection_menu/add', 'ui-icon-flag');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_problems_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    public function prod_season_treatment_fieldsection(){
        
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';

        $data['query'] = $this->get_query($query);
        $data['active'] = 'treeview active';
        $data['id'] = 3;

        $crud= new grocery_CRUD();
        $crud->set_table('treatment_fieldsection');
        $crud->field_type('id_entity', 'hidden', $this->session->userdata('id_entity'));
        $crud->field_type('id_user', 'hidden', $this->session->userdata('id_user'));
        $crud->set_theme('datatables');
        $crud->set_subject('Treatment FieldSection');

        $crud->columns('id','id_treatment', 'id_problem' , 'id_fieldsection', 'id_season');
        
        $crud->set_relation('id_treatment', 'prod_treatment', 'name');
        $crud->set_relation('id_problem', 'prod_season_problems', 'name');
        $crud->set_relation('id_fieldsection', 'prod_fields_sections', 'section_name');
        $crud->set_relation('id_season', 'prod_season', 'name');

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/treatment_fieldsection_view',$output);
        $this->load->view('dashboard/inc/footer_view');

        
    }

    //------------------------------------------------------------------------------------------------
    // menu para adicionar um tipo de tratamento, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function prod_treatment_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        $data['query'] = $this->get_query($query);
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
       
        //$crud->set_relation('id_season', 'prod_season', 'name', array('id_entity' => $this->session->userdata('id_entity')));
        //$crud->display_as('id_season','Season');

        $crud->callback_after_insert(array($this, 'inventory_management'));
       
        $output = $crud->render();
     
        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_treatment_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    //------------------------------------------------------------------------------------------------
    // menu para adicionar a colheita de uma season, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

    public function prod_season_harvast_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        $data['query'] = $this->get_query($query);
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

        $output = $crud->render();

        $header_output=(array)$output;
        unset($header_output['output']);
        $this->load->view('dashboard/inc/header_view', array_merge($data, $header_output));
        $this->load->view('dashboard/admin_pages/prod_season_harvast_view',$output);
        $this->load->view('dashboard/inc/footer_view');

    }


    //------------------------------------------------------------------------------------------------
    // menu para adicionar problem action, utilizando o grocery crud (http://www.grocerycrud.com/documentation/options_functions)
    //------------------------------------------------------------------------------------------------

     public function prod_season_problems_actions_menu(){

        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        $data['query'] = $this->get_query($query);
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


    //------------------------------------------------------------------------------------------------
    // funçao destinada a automaticamente aumentar ou diminuir o stock existente apartir da inserção de novas
    // despesas, que quer dizer, que se comprou algum tipo de bem, esse mesmo e aumentado no stock, 
    // onde qualquer tipo de tratamento ou fertilizaçao utilizado, irá fazer com que seja descontado no stock existente
    //------------------------------------------------------------------------------------------------

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
    

    //------------------------------------------------------------------------------------------------
    // faz uma listagem de todas os report existentes para este modulo (queryRastreability)
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

    public function apply_problem(){
        $this->_require_login();
        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $query = 'queryRastreability';
        $data['query'] = $this->get_query($query);
        $data['active'] = 'treeview active';
        $data['id'] = 3;
        $data['flag'] = 0;
        $this->session->set_userdata(['season' => $this->uri->segment(3)]);

        $query = $this->db->query('select * from prod_season_fields_sections pfs, prod_fields_sections fs where pfs.id_season ='.$this->session->userdata['season'].' and pfs.id_fields_section = fs.id');
        $data['season_rows']= $query->result_array();

        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/season_problem_view');
        $this->load->view('dashboard/inc/footer_main_view');
    }

    public function problemDB(){
        $selectItens = $this->input->post("allValues");
        $pieces = explode(" ", $selectItens);
        $name= $this->input->post("name");
        $type = $this->input->post("type");
        $status = $this->input->post("status");
        $dateEnd = $this->input->post("dEnd");
        $dateStart = $this->input->post("dStart");
        $description = $this->input->post("description");
        $notes = $this->input->post("notes");

        $this->prod_season_problem_model->insert([
                'id_season' => $this->session->userdata['season'],
                'name' => $name,
                'type' => $type,
                'status' => $status,
                'description' => $description,
                'notes' => $notes,
                'start_date' => $dateStart,
                'end_date' => $dateEnd
            ]);

        $id_problem = $this->db->query('Select MAX(id) FROM prod_season_problems');
        $prob = $id_problem->result_array();
        
        for($x=0; $x<count($pieces)-1; $x++){
            $this->problem_fieldsection_model->insert(['id_problem' => $prob[0]['MAX(id)'],'id_fieldsection' => $pieces[$x], 'id_user' => $this->session->userdata('id_user'), 'id_entity' => $this->session->userdata('id_entity'), 'id_season' => $this->session->userdata('season')]);
        }

        redirect('/rastreability/prod_season_menu');
    }

}
?>