<?php

namespace App\Controllers;


use App\Models\MentalhealthFormModel;
use App\Models\MentalhealthModel;
use App\Models\MentalhealthAnsModel;

class Mentalhealth extends BaseController
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

        $this->MentalhealthFormModel = new MentalhealthFormModel();
        $this->MentalhealthModel = new MentalhealthModel();
        $this->MentalhealthAnsModel = new MentalhealthAnsModel();
    }



    public function question()
    {


        $data =  $this->MentalhealthFormModel->findAll();

        foreach ($data as  $key => $row) {
            $key = $key + 1;
            $dataarr[] = array(
                'id' => $key,
                'title' => $row['m_f_question'],
                'choice' => array(array('qname' => $row['m_f_id'], 'choicevalue' => array(
                    array('name' => 'Nope', 'value' => 1),
                    array('name' => 'Sometime', 'value' => 2),
                    array('name' => 'Often', 'value' => 3),
                    array('name' => 'Regularly', 'value' => 4),
                    array('name' => 'Most Regularly', 'value' => 5)
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
        // print_r($answerarr);

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

            $total = 0;

            $data = [
                'm_name' => $name,
                'm_email' => $email,
            ];

            $this->MentalhealthModel->insert($data);
            $insertID = $this->MentalhealthModel->getInsertID();

            if ($insertID) {


                foreach ($answerarr as $item) {
                    $dataarr[] = [
                        'm_a_m_id' => $insertID,
                        'm_a_q_id' => $item->id,
                        'm_a_q_value' => $item->value,
                    ];

                    $total += $item->value;
                }


                $result =  $this->MentalhealthAnsModel->insertBatch($dataarr);
            }

            if ($total <= 23) {
                $testResult = "You have a low level of stress and it disappears in a short period of time. It is a stress that occurs in everyday life and is able to adapt to various situations appropriately. This level of stress is considered useful in daily life. It is the motivation that leads to success in life.";
            } else if ($total <= 41) {
                $testResult = "Do you experience moderate stress in your daily life due to threats or stressful event may feel anxious or scared considered normal This level of stress is neither harmful nor harmful to life. You can relieve stress by doing energetic activities such as exercising, playing sports, doing fun things like listening to music, reading, doing hobbies, or having a conversation with someone you trust.";
            } else if ($total <= 61) {
                $testResult = "You have a high level of stress. It is the degree to which you get annoyed by things or events around you, causing anxiety, fear, conflict, or being in a situation that is resolved. can't handle that problem Difficulty adjusting feelings will affect daily life. and illnesses such as high blood pressure stomach ulcers, etc. What you need to do when you are stressed at this level is: Relieve stress in a simple but effective way is breathing exercises, stress relief, and discussions to relieve stress with trusted people. Find the cause or problem that is stressful and find a solution. If you are unable to manage stress on your own Should consult with consultants in various agencies.";
            } else {
                $testResult = "You have severe stress. It is an ongoing high level of stress or you are facing a life crisis, such as a serious illness. Chronic disability, loss of loved ones, property or loved ones, this level of stress can lead to physical and mental illness. unhappy life highs bad decision can't restrain the mood
                This level of stress, if left unattended, can be detrimental to both yourself and those close to you and should be assisted quickly by a counselor, such as by phone or a local counselor.";
            }



            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success', 'resulttest' => $testResult));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }
}
