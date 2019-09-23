<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Noticia_model extends CI_Model {

    function __construct(){
        parent::__construct();
        $this->load->model('arquivos');
    }

    public function salvar($dados, $arquivos){
        
        if(isset($dados['id']) && $dados['id'] > 0):
            //noticia já existe, devo editar
            $this->db->where('id', $dados['id']);
            unset($dados['id']);
            $this->db->update('noticias', $dados);
            return $this->db->affected_rows();
        else:
            //noticia não existe, devo inserir
            $this->db->insert('noticias', $dados);
            $id_db_noticia = $this->db->insert_id();
            foreach ($arquivos as $arquivo) {
                $dadosArquivo['arquivo']        =  $arquivo['file_name'];
                $dadosArquivo['id_arquivo']     =  $id_db_noticia;
                $this->db->insert('arquivos', $dadosArquivo);
            }

            return $id_db_noticia;
        endif;
    }

    public function salvar_noticia($dados_update){
        if(isset($dados_update['id']) && $dados_update['id'] > 0){
            $this->db->where('id', $dados_update['id']);
            unset($dados_update['id']);
            $this->db->update('noticias', $dados_update);
            return $this->db->affected_rows();
        }
    }

    public function get($limit=0, $offset=0){
        if($limit == 0):
            $this->db->order_by('id','desc');
            $query = $this->db->get('noticias');
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        else:
            $this->db->order_by('id','desc');
            $query = $this->db->get('noticias');
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        endif;
    }

    //retorna um registro
    public function get_single($id=0){
        $this->db->where('id', $id);
        $query = $this->db->get('noticias', 1);
        if($query->num_rows() == 1):
            $row = $query->row();
            return $row;
        else:
            return NULL;
        endif;
    }

    public function excluir($id=0){
        $this->db->where('id', $id);
        $this->db->delete('noticias');
        return $this->db->affected_rows();

    }

    public function get_arquivos($id=0){
        $this->db->select('*');
        $this->db->from('noticias');
        $this->db->join('arquivos','noticias.id = arquivos.id_arquivo','inner');
        $this->db->where('arquivos.id_arquivo', $id);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function get_noticia_arquivos(){
        $this->db->select('*');
        $this->db->from('noticias');
        $this->db->join('arquivos','arquivos.id_arquivo = noticias.id','inner');
        $this->db->where('arquivos.id_arquivo = noticias.id');
        $query=$this->db->get();
        return $query->result_array();
    }


}