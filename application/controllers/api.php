<?php 

class Api extends CI_Controller
{
    
    //------------------------------------------------------------------------------------------------
    // no construtor tem sempre que se fazer load do models aqui, caso contrario 
    // nao os consegues utilizar se apenas fizer load na funçao
    //------------------------------------------------------------------------------------------------
    public function __construct() 
    {
        parent::__construct();
         $this->load->model('user_model');
        $this->load->model('todo_model');
        $this->load->model('entity_model');

    }
    
    //------------------------------------------------------------------------------------------------
    // esta funçao obriga que apenas pessoas logadas consigam visualizar o que esta na pagina. mesmo que façam 
    // acessos directos, sem estar logado, nao conseguem aceder as páginas
    //------------------------------------------------------------------------------------------------
    private function _require_login()
    {
        if ($this->session->userdata('id_user') == false) {
            $this->output->set_output(json_encode(['result' => 0, 'error' => 'You are not authorized.']));
            return false;
        }
    }
    
    
    //------------------------------------------------------------------------------------------------
    // retira-se do form da view home, username e password, das textbox's, liga-se ao modelo do user, que é derivado do crud_model (model 'pai')
    // verifica-se o resultado do acesso a base de dados, se for 1 ou true, inicia-se as variaveis de sessao e redireciona-se para a view dashboard
    // caso contrario o resultado do result seja 0 ou false, fica na mesma view (home)
    //------------------------------------------------------------------------------------------------
    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $result = $this->user_model->get([
            'username' => $username,
            'password' => hash('sha256', $password . SALT)
        ]);
        
        $this->output->set_content_type('application_json');

        if ($result) {
            $this->session->set_userdata(['id_user' => $result[0]['id']]);
            $this->session->set_userdata(['id_entity' => $result[0]['id_entity']]);
            $this->session->set_userdata(['name' => $result[0]['username']]);
            $this->output->set_output(json_encode(['result' => 1]));
            $result_entity = $this->entity_model->get([
                'id' => $result[0]['id_entity']
            ]);
            if($result_entity){
                $this->session->set_userdata(['entity'=> $result_entity[0]['name']]);
            }else{
                $this->session->set_userdata(['entity'=> null]);
            }
                
            //return false;
            redirect('/dashboard');
            
        }
        
        $this->output->set_output(json_encode(['result' => 0]));
        redirect('/');
    }

    //------------------------------------------------------------------------------------------------
    // esta função faz a listagem de todas as tasks do utilizador que se loga
    // atraves do acesso ao modelo todo, a qual esta ligado a tabela das tasks, 
    // aonde procuras as tasks destinadas ao id da pessoa logada
    //------------------------------------------------------------------------------------------------
    public function get_todo($id = null)
    {
        $this->_require_login();
        
        if ($id != null) {
            $result = $this->todo_model->get([
                'id' => $id,
                'id_user' => $this->session->userdata('id_user')
            ]);
        } else {
            $result = $this->todo_model->get([
                'id_user' => $this->session->userdata('id_user')
            ]);
        }

        return $result;
    }

    //------------------------------------------------------------------------------------------------
    // esta função serve para ir buscar a entity de determinado id
    //------------------------------------------------------------------------------------------------

    public function get_entity($id = null)
    {

        $this->_require_login();
        
        if ($id != null) {
            $result = $this->entity_model->get([
                'id' => $id,
            ]);
        } else {
            $result = $this->entity_model->get([
                'id' => $this->session->userdata('id_entity')
            ]);
        }

        return $result;
    }

}
?>
    