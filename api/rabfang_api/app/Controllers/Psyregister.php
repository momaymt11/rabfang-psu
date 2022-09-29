<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\PsychiatristModel;

class Psyregister extends BaseController
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        helper('html');
        $this->db = \Config\Database::connect();
        $this->datetime = date('Y-m-d H:i:s');
        $this->session = session();
        $this->PsychiatristModel = new PsychiatristModel();
    }

    public function register()
    {

        $psy_name = $this->request->getVar('psy_name');
        $psy_email = $this->request->getVar('psy_email');
        $psy_password = $this->request->getVar('psy_password');
        $cpassword = $this->request->getVar('cpassword');

        $rules = [
            'psy_name' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
            'psy_email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[users.u_email]',
            ],

            'psy_password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',
            ],
            'cpassword' => [
                'label'  => 'Confirm Password',
                'rules'  => 'trim|required|matches[psy_password]',
            ],
        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $hashed_password = password_hash($psy_password, PASSWORD_DEFAULT);

            $data = [
                'psy_image' => 'no_image.jpg',
                'psy_name' => $psy_name,
                'psy_email' => $psy_email,
                'psy_password' => $hashed_password,
                'psy_lang' => 'English',
            ];

            $result = $this->PsychiatristModel->insert($data);

            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }
}
