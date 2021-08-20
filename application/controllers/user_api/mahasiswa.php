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
                    'message' => 'ID has been deleted'
                ], 200);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'ID not found'
                ], 404);
            }
        }
    }

    public function index_post()
    {
        $data = [
            'nrp' => $this->post('nrp'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if($this->mhs->createMahasiswa($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'ID has been created'
            ], 201);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data'
            ], 400);
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nrp' => $this->put('nrp'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if($this->mhs->updateMahasiswa($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'ID has been modified'
            ], 200);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to modify data'
            ], 400);
        }
    }
}
