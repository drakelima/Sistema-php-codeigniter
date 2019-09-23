<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MultiUpload extends CI_Controller {

    public function index()
    {
        $data['title'] = "Upload Multi File";
        $this->load->view('upload', $data, FALSE);
    }

    public function proses_upload(){
        $config['upload_path'] = FCPATC.'./uploads/file';
        $config['allowed_types'] = 'pdf';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '100';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';

        $this->load->library('upload', $config);

        if($tihs->upload->do_upload('userFile')){
            $token = $this->input->post('token');
            $name = $this->upload->data('file_name');
            $this->db->insert('upload', ['file'=>$name, 'token'=>$token]);
        }

    }
}