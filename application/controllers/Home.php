<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->model('option_model', 'option');
        $this->load->model('noticia_model', 'noticia');
        $this->load->model('arquivos', 'arquivos');
    }

	public function index()
	{
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
        $dados['titulo'] = 'home';
        $dados['noticia_arquivos'] = $noticiasFinal;
		$this->load->view('home', $dados);
	}
}