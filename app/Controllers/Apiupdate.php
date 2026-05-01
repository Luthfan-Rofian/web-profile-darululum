<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\ModelKonfigurasi;

class Apiupdate extends ResourceController
{
    use ResponseTrait;

    // public function __construct()
    // {
    //     // $this->protect('api-key');
    //     $this->jwt_secret = getenv('api-key');
    //     $this->jwt_algorithm = 'HS256';
    //     $this->jwt_ttl = 3600;
    // }

    // get all data
    public function index()
    {
        $model = new ModelKonfigurasi();
        $data = $model->findAll();
        return $this->respond($data, 200);
    }

    // get single data
    public function show($id = null)
    {

        $model = new ModelKonfigurasi();
        $data = $model->getWhere(['id_setaplikasi' => $id])->getResult();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }

    // create a data
    public function create()
    {
        $model = new ModelKonfigurasi();
        $data = [
            'vercms' => $this->request->getPost('vercms'),
            'verdb' => $this->request->getPost('verdb')
        ];
        $data = json_decode(file_get_contents("php://input"));
        //$data = $this->request->getPost();
        $model->insert($data);
        $response = [
            'status'   => 201,
            'error'    => null,
            'messages' => [
                'success' => 'Data Saved'
            ]
        ];

        return $this->respondCreated($data, 201);
    }


    public function update($id = null)
    {
        $model = new ModelKonfigurasi();
        $json = $this->request->getJSON();
        if ($json) {
            $data = [
                'vercms'    => $json->vercms,
                'sts_web'   => $json->sts_web,
                'nama'      => $json->nama,
                'deskripsi' => $json->deskripsi
            ];
        } else {
            $input = $this->request->getRawInput();
            $data = [
                'vercms'    => $input['vercms'],
                'sts_web'   => $input['sts_web'],
                'nama'      => $input['nama'],
                'deskripsi' => $input['deskripsi']
            ];
        }

        $model->update($id, $data);
        $response = [
            'status'   => 200,
            'error'    => null,
            'messages' => [
                'success' => 'Data Berhasil di updated'
            ]
        ];
        return $this->respond($response);
    }

    // delete data
    public function delete($id = null)
    {
        $model = new ModelKonfigurasi();
        $data = $model->find($id);
        if ($data) {
            $model->delete($id);
            $response = [
                'status'   => 200,
                'error'    => null,
                'messages' => [
                    'success' => 'Data Deleted'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('No Data Found with id ' . $id);
        }
    }
}
