<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Arquivos extends CI_Model{
    function __construct() {
        $this->tableName = 'arquivos';
    }
  
    public function getRows($id = ''){
        $this->db->select('id,arquivo');
        $this->db->from('arquivos');
        if($id){
            $this->db->where('id',$id);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            $this->db->order_by('uploaded_on','desc');
            $query = $this->db->get();
            $result = $query->result_array();
        }
        return !empty($result)?$result:false;
    }

    public function excluir($id){
        $this->db->where('id', $id);
        $this->db->delete('arquivos');
        return $this->db->affected_rows();
    }

    public function get($limit=0, $offset=0){
        if($limit == 0):
            $this->db->order_by('id','desc');
            $query = $this->db->get('arquivos');
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        else:
            $this->db->order_by('id','desc');
            $query = $this->db->get('arquivos');
            if($query->num_rows() > 0):
                return $query->result();
            else:
                return NULL;
            endif;
        endif;
    }
    
    /*
     * Insert file data into the database
     * @param array the data for inserting into the table
     */
    public function insert($data = array()){
        $insert = $this->db->insert_batch('arquivos',$data);
        return $insert?true:false;
    }

    public function getArquivosByNoticiaId($id_noticia){
        $this->db->select('*');
        $this->db->from('arquivos');
        $this->db->where('id_arquivo', $id_noticia);
        $query=$this->db->get();
        return $query->result_array();
    }

    public function salvar($uploadData){
            //insert into arquivos arquivo, id_arquivo where  
            //noticia não existe, devo inserir
            //$this->db->insert('arquivos', $arquivos);
            //$id_db_noticia = $this->db->insert_id();
            foreach ($uploadData as $arquivo) {
                $dadosArquivo['arquivo'] = $arquivo['file_name'];
                $dadosArquivo['id_arquivo'] = $arquivo['id_arquivo'];
                $this->db->insert('arquivos', $dadosArquivo);
            }
            return $this->db->affected_rows();
    }

    public function exclui_arquivo($id){
        $this->db->where('id', $id);
        $this->db->delete('arquivos');
        return $this->db->affected_rows();
    }

    public function get_single($id=0){
        $this->db->where('id', $id);
        $query = $this->db->get('arquivos', 1);
        if($query->num_rows() == 1):
            $row = $query->row();
            return $row;
        else:
            return NULL;
        endif;
    }

    
}