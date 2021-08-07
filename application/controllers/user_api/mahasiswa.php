<?php
defined('BASEPATH') or exit('No direct script access allowed');
require FCPATH . 'vendor/autoload.php';
use chriskacerguis\RestServer\RestController;
class Mahasiswa extends RestController
{
    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ( $id === null ) {
            $mahasiswa = $this->mhs->getMahasiswa();
        } else {
            $mahasiswa = $this->mhs->getMahasiswa($id);          
        }
        
        if($mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $mahasiswa,
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'No users were found'
            ], 404);
        }
    }

    public function index_delete()
    {
        $id = $this->delete('id');
        if ( $id === null ) {
            $this->response([
                'status' => false,
                'message' => 'ID not provided'
            ], 400);
        } else {
            if ($this->mhs->deleteMahasiswa($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'ID has been deleted'
                ], 204);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID not found'
                ], 404);
            }
        }
    }

}
