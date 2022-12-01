<?php

namespace App\Controllers;

use CodeIgniter\Database\Query;


class Psylogin extends BaseController
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

        $psy_email = $this->request->getVar('psy_email');
        $psy_password = $this->request->getVar('psy_password');

        $rules = [
            'psy_email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email',

            ],

            'psy_password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',

            ],

        ];


        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors()), JSON_UNESCAPED_SLASHES);
        } else {

            $pQuery = $this->db->prepare(function ($db) {
                $sql = "SELECT * FROM psychiatrist WHERE psy_email = ?";

                return (new Query($db))->setQuery($sql);
            });
            $data = $pQuery->execute($psy_email)->getRow();

            if ($data) {
                $pass = $data->psy_password;
                $verify_pass = password_verify($psy_password, $pass);
                if ($verify_pass) {

                    $ses_data = array(
                        'psy_id'       => $data->psy_id,
                        'psy_role'     => 'psy'
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
