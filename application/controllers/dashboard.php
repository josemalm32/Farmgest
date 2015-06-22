<?php
 
class Dashboard extends CI_Controller
{
    
    //------------------------------------------------------------------------------------------------
    // no construtor tem sempre que se fazer load do models aqui, caso contrario 
    // nao os consegues utilizar se apenas fizer load na funçao
    // na construçao do controller verifica se esta logado o utilizador
    //------------------------------------------------------------------------------------------------
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
        $this->load->model('user_model');
        $this->load->model('treatment_model');
        $this->load->model('season_problems_model');
        $this->load->model('treatment_fieldsection_model');
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

    //------------------------------------------------------------------------------------------------
    // menu de login, devido a falta de actividade por parte do utilizador
    // descriçao mais pormenorizada no login da api, basicamente bastante identico
    //------------------------------------------------------------------------------------------------

    public function lockscreen(){
        $pw = $this->input->post('password');
        $result = $this->user_model->get([
            'username' => $this->session->userdata('name'),
            'password' => hash('sha256', $pw . SALT)
        ]);
        if ($result) {
            redirect('/dashboard');
        }else{
            redirect('/home');
        }
    }

    //------------------------------------------------------------------------------------------------
    // preenchimento da vista com todos os fieldsections existentes, referidos a entidade a qual pertence 
    // o utilizador, tendo mais duas dropbox onde se pode escolher o treatment e o problem, 
    // isto para adicionares algum tratamento ao problema que tenha aqueles campos
    //------------------------------------------------------------------------------------------------

    public function test_layout()
    {
        $this->_require_login();

        require('api.php');
        $api = new api();
        $data['task'] = $api->get_todo();
        $data['id'] = 1;
        $data['flag'] = 0;

        $this->session->set_userdata(['season' => $this->uri->segment(3)]);
        $query = $this->db->query('select * from problem_fieldsection pfs, prod_fields_sections fs where pfs.id_season ='.$this->session->userdata['season'].' and pfs.id_fieldsection = fs.id');
        $data['farm']= $query->result_array();
        $query2 = $this->db->query('select * from prod_season_problems psp, prod_problem_section pps WHERE psp.id = pps.id_problem and psp.id_season = '.$this->session->userdata['season'].'');
        $data['problem'] = $query2->result_array();
        $data['treatment'] = $this->treatment_model->get();
        $this->session->set_userdata(['season' => $this->uri->segment(3)]);
        $this->load->view('dashboard/inc/header_main_view', $data);
        $this->load->view('dashboard/admin_pages/test_view', $data);
        $this->load->view('dashboard/inc/footer_main_view');
    }

    //----------------------------------------------------------------------------------
    // 
    //----------------------------------------------------------------------------------

    public function test_val()
    {

        
        $selectItens = $this->input->post("allValues");
        $selectTreatment = $this->input->post("ChoosenTreatment");
        $selectProblem = $this->input->post("ChoosenProblem");
        $pieces = explode(" ", $selectItens);
        echo $selectItens;
        for($x=0; $x<count($pieces)-1; $x++){
            $this->treatment_fieldsection_model->insert(['id_problem' => $selectProblem,'id_treatment' => $selectTreatment,'id_fieldsection' => $pieces[$x], 'id_user' => $this->session->userdata('id_user'), 'id_entity' => $this->session->userdata('id_entity'), 'id_season' => $this->session->userdata('season')]);
        }
        $this->session->set_userdata(['season'=>0]);
        redirect('rastreability/prod_season_treatment_fieldsection');
    }

}
?>
