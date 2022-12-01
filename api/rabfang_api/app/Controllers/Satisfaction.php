<?php

namespace App\Controllers;


use App\Models\SatisfactionFormModel;
use App\Models\SatisfactionAnsModel;
use App\Models\SatisfactionModel;

class Satisfaction extends BaseController
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

        $this->SatisfactionFormModel = new SatisfactionFormModel();
        $this->SatisfactionAnsModel = new SatisfactionAnsModel();
        $this->SatisfactionModel = new SatisfactionModel();
    }


    public function question()
    {

        $data =  $this->SatisfactionFormModel->findAll();

        foreach ($data as  $key => $row) {
            $key = $key + 1;
            $dataarr[] = array(
                'id' => $key,
                'title' => $row['s_f_question'],
                'choice' => array(array('qname' => $row['s_f_id'], 'choicevalue' => array(
                    array('name' => 'Very low', 'value' => 1),
                    array('name' => 'Low', 'value' => 2),
                    array('name' => 'Moderate', 'value' => 3),
                    array('name' => 'More', 'value' => 4),
                    array('name' => 'Most', 'value' => 5)
                ))),
            );
        }


        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function add_form()
    {

        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $answer = $this->request->getVar('answer');

        $answerarr =  json_decode($answer);


        $rules = [
            'name' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
            'email' => [
                'label'  => 'Email',
                'rules'  => 'required',
            ],

        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {



            $data = [
                's_name' => $name,
                's_email' => $email,
            ];

            $this->SatisfactionModel->insert($data);
            $insertID = $this->SatisfactionModel->getInsertID();

            if ($insertID) {

                foreach ($answerarr as $item) {
                    $dataarr[] = [
                        's_a_s_id' => $insertID,
                        's_a_q_id' => $item->id,
                        's_a_q_value' => $item->value,
                    ];
                }


                $result =  $this->SatisfactionAnsModel->insertBatch($dataarr);
            }



            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }
}
