<?php

namespace App\Controllers;


use App\Models\ChatModel;

class Chat extends BaseController
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
        $this->ChatModel = new ChatModel();
    }



    public function chat_list()
    {
        $a_id = $this->request->getVar('a_id');

        $data =   $this->ChatModel
            ->select("c_id,c_text,DATE_FORMAT(c_datetime, '%e %M %Y %H:%i') as c_datetime_as,c_datetime,u_name,u_image,psy_name,psy_image, IF(c_u_id, 'YES', 'NO') as user_chat_act,IF(c_psy_id, 'YES', 'NO') as psy_chat_act, IF(c_u_id, 'USER', 'PSY') as role")
            ->join('users', 'chat.c_u_id = users.u_id', 'left')
            ->join('psychiatrist', 'chat.c_psy_id = psychiatrist.psy_id', 'left')
            ->orderBy('c_datetime', 'ASC')
            ->where(['c_a_id' => $a_id])
            ->findAll();

        foreach ($data as $row) {
            $dataarr[] = array(
                'c_id' => $row['c_id'],
                'c_text' => $row['c_text'],
                'c_datetime_as' => $row['c_datetime_as'],
                'user_chat_act' => $row['user_chat_act'],
                'u_name' => $row['u_name'],
                'u_image' => base_url('uploads') . '/' . $row['u_image'],
                'psy_chat_act' => $row['psy_chat_act'],
                'psy_name' => $row['psy_name'],
                'psy_image' => base_url('uploads') . '/' . $row['psy_image'],
                'role' => $row['role'],
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function add_chat()
    {

        $c_a_id = $this->request->getVar('c_a_id');
        $c_psy_id = $this->request->getVar('c_psy_id');
        $c_text = $this->request->getVar('c_text');


        $rules = [
            'c_text' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {


            $data = [
                'c_a_id' => $c_a_id,
                'c_psy_id' => $c_psy_id,
                'c_text' => $c_text,
            ];

            $result = $this->ChatModel->insert($data);

            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }


    public function add_chat_user()
    {

        $c_a_id = $this->request->getVar('c_a_id');
        $c_u_id = $this->request->getVar('c_u_id');
        $c_text = $this->request->getVar('c_text');


        $rules = [
            'c_text' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {


            $data = [
                'c_a_id' => $c_a_id,
                'c_u_id' => $c_u_id,
                'c_text' => $c_text,
            ];

            $result = $this->ChatModel->insert($data);

            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }
}
