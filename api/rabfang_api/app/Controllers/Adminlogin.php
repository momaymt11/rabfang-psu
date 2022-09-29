<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;
use App\Models\AdminModel;


class Adminlogin extends BaseController
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
    }

    public function auth()
    {

        $admin_username = $this->request->getVar('admin_username');
        $admin_password = $this->request->getVar('admin_password');

        $rules = [
            'admin_username' => [
                'label'  => 'Username',
                'rules'  => 'required',

            ],

            'admin_password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',

            ],

        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors()), JSON_UNESCAPED_SLASHES);
        } else {

            $pQuery = $this->db->prepare(function ($db) {
                $sql = "SELECT * FROM admin WHERE admin_username = ?";

                return (new Query($db))->setQuery($sql);
            });
            $data = $pQuery->execute($admin_username)->getRow();

            if ($data) {
                $pass = $data->admin_password;
                $verify_pass = password_verify($admin_password, $pass);
                if ($verify_pass) {

                    $ses_data = array(
                        'admin_id'       => $data->admin_id,
                        'admin_role'     => 'admin'
                    );

                    echo json_encode(array('status' => true, 'data' => $ses_data, 'msg' =>  'สำเร็จ'), JSON_UNESCAPED_SLASHES);
                } else {
                    echo json_encode(array('status' => false, 'msg' =>  'Wrong Password'), JSON_UNESCAPED_SLASHES);
                }
            } else {
                echo json_encode(array('status' => false, 'msg' =>  'This account does not exist'), JSON_UNESCAPED_SLASHES);
            }
        }
    }
}
