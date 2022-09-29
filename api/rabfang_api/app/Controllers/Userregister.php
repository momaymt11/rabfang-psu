<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\UsersModel;

class Userregister extends BaseController
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
        $this->UsersModel = new UsersModel();
    }

    public function register()
    {

        $u_name = $this->request->getVar('u_name');
        $u_email = $this->request->getVar('u_email');
        $u_password = $this->request->getVar('u_password');
        $cpassword = $this->request->getVar('cpassword');
        $u_faculty = $this->request->getVar('u_faculty');
        $u_major = $this->request->getVar('u_major');
        $u_year = $this->request->getVar('u_year');
        $u_phone = $this->request->getVar('u_phone');
        $u_birthday = $this->request->getVar('u_birthday');
        $u_address = $this->request->getVar('u_address');

        $rules = [
            'u_name' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
            'u_email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[users.u_email]',
            ],

            'u_password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',
            ],
            'cpassword' => [
                'label'  => 'Confirm Password',
                'rules'  => 'trim|required|matches[u_password]',
            ],
            'u_faculty' => [
                'label'  => 'Faculty',
                'rules'  => 'required',
            ],
            'u_major' => [
                'label'  => 'Major',
                'rules'  => 'required',
            ],
            'u_year' => [
                'label'  => 'Year',
                'rules'  => 'required',
            ],
            'u_phone' => [
                'label'  => 'Phone',
                'rules'  => 'required',
            ],
            'u_birthday' => [
                'label'  => 'Birthday',
                'rules'  => 'required',
            ],
            'u_address' => [
                'label'  => 'Address',
                'rules'  => 'required',
            ],
        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $hashed_password = password_hash($u_password, PASSWORD_DEFAULT);

            $data = [
                'u_image' => 'no_image.jpg',
                'u_name' => $u_name,
                'u_email' => $u_email,
                'u_password' => $hashed_password,
                'u_faculty' => $u_faculty,
                'u_major' => $u_major,
                'u_year' => $u_year,
                'u_phone' => $u_phone,
                'u_birthday' => $u_birthday,
                'u_address' => $u_address,
            ];

            $result = $this->UsersModel->insert($data);

            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }
}
