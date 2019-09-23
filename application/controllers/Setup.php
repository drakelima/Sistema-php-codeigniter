<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('option_model','option');
    }

    public function index() {
    if($this->option->get_option('setup_executado') == 1):
            redirect('setup/alterar','refresh');
        else:
            redirect('setup/instalar','refresh');
        endif;
    }

     public function instalar(){
        if($this->option->get_option('setup_executado') == 1):

            redirect('setup/alterar','refresh');
        endif;
        //regras de validação
        $this->load->library(array('form_validation'));
        $this->form_validation->set_rules('login','NOME','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha','SENHA','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha2','REPITA A SENHA','trim|required|min_length[3]|matches[senha]');
        //verifica a validação
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            $this->option->update_option('user_login', $dados_form['login']);
            $this->option->update_option('user_pass', password_hash($dados_form['senha'], PASSWORD_DEFAULT)
                );
            $inserido = $this->option->update_option('setup_executado', 1);
            if($inserido):
                set_msg('<p>Sistema instalado, use os dados cadastrados para logar no sistema</p>');
                redirect('setup/login', 'refresh');
            endif;
        endif;
        //carrega view
        $dados['titulo'] = 'Central de estágio - setup do sisterma';
        $dados['h2'] = 'Setup do sistema';
        $this->load->view('painel/setup',$dados);

    }
    
    public function login(){
        if($this->option->get_option('setup_executado') != 1):
        // setup não esta ok mandar para instalar o sistema
        redirect('setup/instalar','refresh');
    endif;
        //regras de validação
        $this->load->library(array('form_validation'));
        $this->form_validation->set_rules('login','NOME','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha','SENHA','trim|required|min_length[3]');

        //verifica a validação
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            if($this->option->get_option('user_login') == $dados_form['login']):
                //usuário existe
                if(password_verify($dados_form['senha'], $this->option->get_option('user_pass'))):
                    //senha ok, fazer login
                    $this -> session->set_userdata('logged',TRUE);
                    $this -> session->set_userdata('user_login',$dados_form['login']);
                    //fazer redirect para home do painel
                    redirect('noticia/listar','refresh');
                else:
                    //senha incorreta
                    set_msg('<p>Senha incorreta</p>');
                endif;
            else:
                //usuario não existe
                set_msg('<p>Usuario não existe!</p>');
            endif;            
        endif;

        //carrega view
        $dados['titulo'] = 'Central de estágio - setup do sisterma';
        $dados['h2'] = 'Acessar o painel';
        $this->load->view('painel/login',$dados);

    }

    public function alterar(){
        //verificar o login do usuario
        verifica_login();

        //regras de validação
        $this->load->library(array('form_validation'));
        $this->form_validation->set_rules('login','NOME','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha','SENHA','trim|required|min_length[3]');

        if(isset($POST['senha']) && $_POST['senha'] != ''):
            $this->form_validation->set_rules('senha2', 'REPITA A SENHA', 'trim|required|min_length[3]|matches[senha]');
        endif;

        //verifica a validação
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            $this->option->update_option('user_login', $dados_form['login']);
            if(isset($dados_form['senha']) && $dados_form['senha'] != ''):
                $this->option->update_option('user_pass', password_hash($dados_form['senha'], PASSWORD_DEFAULT)
                );
            endif;
            set_msg('Dados alterados com sucesso!');
        endif;

        //carrega a view
        $_POST['login'] = $this->option->get_option('user_login');
        $dados['titulo'] = 'Central de estágio - configuração do sistema';
        $dados['h2'] = 'Acessar o painel';
        
        $this->load->view('painel/includes/aside-nav',$dados);
        $this->load->view('painel/apresentacao',$dados);
        $this->load->view('painel/includes/footer',$dados);
    }

    public function logout(){
        //destroi os dados da sessão
        $this->session->unset_userdata('logged');
        $this->session->unset_userdata('user_login');
        set_msg('<p>Você saiu do sistema!</p>');
        redirect('home', 'refresh');
    }/* */

    public function config(){
        //verifica a validação
        $this->form_validation->set_rules('login','NOME','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha','SENHA','trim|required|min_length[3]');
        $this->form_validation->set_rules('senha2','REPITA A SENHA','trim|required|min_length[3]');
        
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $dados_form = $this->input->post();
            $this->option->update_option('user_login', $dados_form['login']);
            
            if((isset($dados_form['senha']) && $dados_form['senha'] != '') 
            && (isset($dados_form['senha2']) && $dados_form['senha2'] != '')
            && $dados_form['senha'] == $dados_form['senha2']){
                
                $this->option->update_option('user_pass', password_hash($dados_form['senha'], PASSWORD_DEFAULT)
                );
            set_msg('Dados alterados com sucesso!');
            }else{
                set_msg('O campo NOVA SENHA e REPITA A SENHA devem ser iguais, repita a operação!');
            }
        endif;
        //carrega a view
        $_POST['login'] = $this->option->get_option('user_login');
        $dados['titulo'] = 'Prodema - configuração do sisterma';
        $dados['h2'] = 'Acessar o painel';
        $this->load->view('painel/includes/aside-nav',$dados);
        $this->load->view('painel/config',$dados);
        $this->load->view('painel/includes/footer',$dados);
    }

}