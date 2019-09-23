<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticia extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('option_model', 'option');
        $this->load->model('noticia_model', 'noticia');
        $this->load->model('arquivos', 'arquivos');
    }

    public function index(){
        redirect('noticia/listar', 'refresh');
    }

    public function listar(){
        //verifica se o usuário eestá logado
        verifica_login();

        $arrayNoticias = $this->noticia->get();
        $noticiasFinal = array();

        if(isset($arrayNoticias)){
            foreach ($arrayNoticias as $linha) {
                
                $array = array(
                    "id" => $linha->id,
                    "comarca" => $linha->comarca,
                    "unidade" => $linha->unidade,
                    "tipo_estagio" => $linha->tipo_estagio,
                    "vagas" => $linha->vagas,
                    "inicio_inscricao" => $linha->inicio_inscricao,
                    "fim_inscricao" => $linha->fim_inscricao,
                ); 
                
                $aux_arquivos = $this->arquivos->getArquivosByNoticiaId($linha->id);
                foreach ($aux_arquivos as $key => $value) {
                    $array['arquivos'][$key] = $value['arquivo'];
                }

                array_push($noticiasFinal, $array);
            }
        }
        //carrega view
        $dados['titulo'] = 'Central de estágio - Listagem dos registros';
        $dados['h2'] = 'Listagem dos registros';
        $dados['tela'] = 'listar';
        $dados['noticias'] = $this->noticia->get();
        $dados['arquivos'] = $this->arquivos->get();
        $dados['noticia_arquivos'] = $noticiasFinal;

        $this->load->view('painel/includes/aside-nav',$dados);
        $this->load->view('painel/noticias',$dados);
        $this->load->view('painel/includes/footer',$dados);
    }

    public function cadastrar(){
        //verifica se o usuário eestá logado
        verifica_login();

        //regras de vailidação
        $this->form_validation->set_rules('comarca','COMARCA','trim|required');
        $this->form_validation->set_rules('unidade','UNIDADE','trim|required');
        $this->form_validation->set_rules('vagas','VAGAS','trim|required');
        $this->form_validation->set_rules('inicio_inscricao','INICIO DAS INSCRICOES','trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('fim_inscricao','FIM DAS INSCRICOES','trim|required|min_length[10]|max_length[10]');

        //verificação da vadidação
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $this->load->library('upload', config_upload());
            $filesCount = count($_FILES['arquivos']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['arquivo']['name'] = $_FILES['arquivos']['name'][$i];
                $_FILES['arquivo']['type']     = $_FILES['arquivos']['type'][$i];
                $_FILES['arquivo']['tmp_name'] = $_FILES['arquivos']['tmp_name'][$i];
                $_FILES['arquivo']['error']     = $_FILES['arquivos']['error'][$i];
                $_FILES['arquivo']['size']     = $_FILES['arquivos']['size'][$i];


                if ($this->upload->do_upload('arquivo')) {
                    //Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
                } else {
                    set_msg('Insira pelo menos um arquivo!');
                }
            }

            if (!empty($uploadData)) {
                // Insert files data into the database

                $dados_form = $this->input->post();
                $dados_insert['comarca'] = to_db($dados_form['comarca']);
                $dados_insert['unidade'] = to_db($dados_form['unidade']);
                $dados_insert['tipo_estagio'] = to_db($dados_form['tipo_estagio']);
                $dados_insert['vagas'] = to_db($dados_form['vagas']);
                $dados_insert['inicio_inscricao'] = to_db($dados_form['inicio_inscricao']);
                $dados_insert['fim_inscricao'] = to_db($dados_form['fim_inscricao']);

                //salvar no banco de dados
                if($id = $this->noticia->salvar($dados_insert, $uploadData)){
                    set_msg('<p>Noticia cadastrada com sucesso!</p>');
                    redirect('noticia/listar/'.$id, 'refresh');
                }else{
                    set_msg('<p>Erro, noticia não cadastrada!</p>');
                    redirect('noticia/cadastrar');
                }
            }
        
        endif;

        //carrega view
        $dados['titulo'] = 'Central de estágio - Cadastro de seleção';
        $dados['h2'] = 'Cadastro de seleção';
        $dados['tela'] = 'cadastrar';
        $this->load->view('painel/includes/aside-nav',$dados);
        $this->load->view('painel/noticias',$dados);
        $this->load->view('painel/includes/footer',$dados);
    }


    public function excluir(){

        //verifica se o usuário eestá logado
        verifica_login();

        //verifica se foi passado o id da notícia
        $id = $this->uri->segment(3);
        //SELECT * FROM `arquivos` INNER JOIN `noticias` WHERE noticias.id = 21

        if($id > 0):
            //id informado, continuar com exclusão
            if($noticia = $this->noticia->get_single($id) && $arquivos_registro = 
            $this->noticia->get_arquivos($id)):

                $dados['noticia'] = $noticia;

                $arquivos_remover = array();

                //seleciona os arquivos para serem excluidos da máquina
                foreach ($arquivos_registro as $arquivo) {
                    $arquivo_upload = 'uploads/'.$arquivo['arquivo'];
                    array_push($arquivos_remover,$arquivo_upload);
                }

                //exclui os registros de arquivos do banco de dados
                foreach ($arquivos_registro as $arquivo) {
                    //printInfoDump($arquivo->$id);
                    $this->arquivos->excluir($arquivo['id'] );
                }

                if($this->noticia->excluir($id)){
                //Não está excluindo os arquivos pdf da máquina, falta imlementar!!!
                foreach ($arquivos_remover as $arquivo) {
                    //printInfoDump('uploads/'.$arquivo['arquivo']);
                    unlink($arquivo);
                }
                set_msg('<p>Noticia excluida com sucesso!</p>');
                redirect('noticia/listar', 'refresh');
                }
                else{
                    set_msg('<p>Erro, nenhuma noticia excluida!</p>');
                }
            else:
                set_msg('<p>Noticia inexistente!, escolhe uma noticia para excluir</p>');
                redirect('noticia/listar', 'refresh');
            endif;
        else:
            set_msg('<p>Você deve escolher uma noticia para excluir!</p>');
            redirect('noticia/listar', 'refresh');
        endif;
    }

    public function editar(){
        //verifica se o usuário eestá logado
        verifica_login();

        //verifica se foi passado o id da notícia
        $id = $this->uri->segment(3);
        $remocao_arquivo = $this->uri->segment(4);
        if(isset($remocao_arquivo)){
            $arquivo_removido = 'true';
        }
        if($id > 0):
            //id informado, continuar com edição
            if($noticia = $this->noticia->get_single($id)):
                $arquivos_noticia = $this->arquivos->getArquivosByNoticiaId($id);
                $dados['noticia'] = $noticia;
                $dados_update['id'] = $noticia->id;
                
            else:
                set_msg('<p>Noticia inexistente!, escolhe uma noticia para editar</p>');
                redirect('noticia/listar', 'refresh');
            endif;
        else:
            set_msg('<p>Você deve escolher uma noticia para editar!</p>');
        endif;

        //regras de validação
        $this->form_validation->set_rules('comarca','COMARCA','trim|required');
        $this->form_validation->set_rules('unidade','UNIDADE','trim|required');
        $this->form_validation->set_rules('vagas','QUANTIDADE DE VAGAS','trim|required');
        $this->form_validation->set_rules('inicio_inscricao','INICIO DAS INSCRICOES','trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('fim_inscricao','FIM DAS INSCRICOES','trim|required|min_length[10]|max_length[10]');
        
        //verifica a validação
        if($this->form_validation->run() == FALSE):
            if(validation_errors()):
                set_msg(validation_errors());
            endif;
        else:
            $this->load->library('upload', config_upload());
            //insere os arquivos novos passado
            if(isset($_FILES['arquivos']) && $_FILES['arquivos']['name'] != ''){
                
                $filesCount = count($_FILES['arquivos']['name']);
                for($i = 0; $i < $filesCount; $i++){
                $_FILES['arquivo']['name'] = $_FILES['arquivos']['name'][$i];
                $_FILES['arquivo']['type']     = $_FILES['arquivos']['type'][$i];
                $_FILES['arquivo']['tmp_name'] = $_FILES['arquivos']['tmp_name'][$i];
                $_FILES['arquivo']['error']     = $_FILES['arquivos']['error'][$i];
                $_FILES['arquivo']['size']     = $_FILES['arquivos']['size'][$i];


                if ($this->upload->do_upload('arquivo')) {
                    $fileData = $this->upload->data();
                    $uploadData[$i]['file_name'] = $fileData['file_name'];
                    $uploadData[$i]['id_arquivo'] = $id;
                    } 

                }
                
                $dados_form = $this->input->post();
                $dados_update['comarca'] = to_db($dados_form['comarca']);
                $dados_update['unidade'] = to_db($dados_form['unidade']);
                $dados_update['tipo_estagio'] = to_db($dados_form['tipo_estagio']);
                $dados_update['vagas'] = to_db($dados_form['vagas']);
                $dados_update['inicio_inscricao'] = to_db($dados_form['inicio_inscricao']);
                $dados_update['fim_inscricao'] = to_db($dados_form['fim_inscricao']);
                            
                if(isset($uploadData) || $this->noticia->salvar_noticia($dados_update) || isset($arquivo_removido)){
                    $this->arquivos->salvar($uploadData);
                    set_msg('<p>Noticia alterada com sucesso!</p>');
                    redirect('noticia/listar');
                } else{
                    set_msg('<p>Nenhuma alteração foi salva!</p>');
                }
            }
        endif;

        //carrega view
        $dados['titulo'] = 'Central de estágio - alteração de noticias';
        $dados['h2'] = 'alteração de registro';
        $dados['tela'] = 'editar';
        $dados['arquivos'] = $arquivos_noticia;

        $this->load->view('painel/includes/aside-nav',$dados);
        $this->load->view('painel/noticias',$dados);
        $this->load->view('painel/includes/footer',$dados);
    }

    public function excluir_arquivo(){
        $id = $this->uri->segment(3);
        $idNoticia = $this->uri->segment(4);
        $arquivo_alterado = 'true';
        $arquivo = $this->arquivos->get_single($id);
        $caminho_remocao = 'uploads/'.$arquivo->arquivo;

        if ($this->arquivos->exclui_arquivo($id)){
            unlink($caminho_remocao);
            set_msg('Arquivo excluído!');
        } else {
            set_msg('Erro ao excluir arquivo!');
        }
        
        redirect('noticia/editar/'.$idNoticia.'/'.$arquivo_alterado,'refresh');
    }
}