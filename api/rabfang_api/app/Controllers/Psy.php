<?php

namespace App\Controllers;

use App\Models\PsychiatristModel;
use App\Models\UsersModel;
use App\Models\AppointmentModel;
//
use App\Models\MentalhealthFormModel;
use App\Models\MentalhealthModel;
use App\Models\MentalhealthAnsModel;

class Psy extends BaseController
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
        $this->UsersModel = new UsersModel();
        $this->AppointmentModel = new AppointmentModel();

        //
        $this->MentalhealthFormModel = new MentalhealthFormModel();
        $this->MentalhealthModel = new MentalhealthModel();
        $this->MentalhealthAnsModel = new MentalhealthAnsModel();
    }



    public function psy_visits_appointments()
    {
        $psy_id = $this->request->getVar('psy_id');

        $data =  $this->AppointmentModel
            ->select("*,DATE_FORMAT(a_date, '%W %e %M %Y %H:%i') as a_date_as")
            ->join('users', 'appointment.a_u_id = users.u_id')
            ->orderBy('a_date', 'ASC')
            ->where(['a_psy_id' => $psy_id])
            ->findAll();

        foreach ($data as $row) {

            $dataarr[] = array(
                'a_id' => $row['a_id'],
                'u_image' => base_url('uploads') . '/' . $row['u_image'],
                'u_name' => $row['u_name'],
                'u_faculty' => $row['u_faculty'],
                'u_major' => $row['u_major'],
                'a_topic' => explode(",", $row['a_topic']),
                'a_date_as' => $row['a_date_as'],
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function psy_result_mental()
    {


        $data =  $this->MentalhealthModel
            ->select("*,DATE_FORMAT(m_datetime, '%W %e %M %Y %H:%i') as m_datetime_as,SUM(m_a_q_value) as total")
            ->join('mentalhealth_ans', 'mentalhealth.m_id = mentalhealth_ans.m_a_m_id')
            ->groupBy('m_id')
            ->orderBy('m_datetime', 'DESC')
            ->findAll();



        if ($data) {
            echo json_encode(array('status' => true, 'data' => $data), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function psy_account_settings()
    {
        $psy_id = $this->request->getVar('psy_id');
        $data =  $this->PsychiatristModel->where(['psy_id' => $psy_id])->find();

        foreach ($data as $row) {
            $dataarr = array(
                'psy_id' => $row['psy_id'],
                'psy_image' => base_url('uploads') . '/' . $row['psy_image'],
                'psy_name' => $row['psy_name'],
                'psy_email' => $row['psy_email'],
                'psy_password' => $row['psy_password'],
                'psy_lang' => explode(",", $row['psy_lang']),
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function psy_update_account()
    {

        $msg = '';
        $bool = null;
        $psy_id = $this->request->getVar('psy_id');
        $img = $this->request->getVar('file');
        $psy_name = $this->request->getVar('psy_name');
        $psy_email = $this->request->getVar('psy_email');
        $psy_password = $this->request->getVar('psy_password');
        $psy_lang = $this->request->getVar('psy_lang');

        $rules = [
            'psy_name' => [
                'label'  => 'Name',
                'rules'  => 'required',
            ],
            'psy_email' => [
                'label'  => 'Email',
                'rules'  => 'required|valid_email|is_unique[psychiatrist.psy_email,psy_email,{psy_email}]',
            ],
            'psy_password' => [
                'label'  => 'Password',
                'rules'  => 'trim',
            ],
            'psy_lang' => [
                'label'  => 'Language',
                'rules'  => 'required',
            ],
        ];

        $imageUpload = [
            'file' => [
                'rules'  => 'uploaded[file]',
            ],
        ];

        $rulesValidImage = [
            'file' => [
                'label'  => 'Image',
                'rules'  => 'mime_in[file,image/jpg,image/jpeg,image/png]|max_size[file,2048]',
            ],
        ];


        if (!$this->validate($rules)) {
            $bool = false;
            $msg = $this->validator->listErrors();
        } else {

            $data = [
                'psy_name' => $psy_name,
                'psy_email' => $psy_email,
                'psy_lang' => $psy_lang,
            ];


            $this->PsychiatristModel->update(['psy_id' => $psy_id], $data);

            if ($psy_password != "") {
                $hashed_password = password_hash($psy_password, PASSWORD_DEFAULT);
                $data = [
                    'psy_password' => $hashed_password
                ];
                $this->PsychiatristModel->update(['psy_id' => $psy_id], $data);
            }

            if ($this->validate($imageUpload)) {
                if ($this->validate($rulesValidImage)) {
                    if (!empty($_FILES['file']['name'])) {
                        $file_tmp = $_FILES['file']['tmp_name'];
                        $tmp = explode('.', $_FILES['file']['name']);
                        $file_extension = end($tmp);
                        $file_ext = strtolower($file_extension);
                        $iniqID = uniqid();
                        $file = 'uploads/' . $iniqID . '.' . $file_ext;
                        $fileName = $iniqID . '.' . $file_ext;
                        move_uploaded_file($file_tmp, $file);

                        $data = [
                            'psy_image' => $fileName,
                        ];
                        $this->PsychiatristModel->update(['psy_id' => $psy_id], $data);

                        $bool = true;
                        $msg = 'success';
                    }
                } else {

                    $bool = false;
                    $msg = $this->validator->listErrors();
                }
            } else {
                $bool = true;
                $msg = 'success';
            }
        }
        echo json_encode(array('status' => $bool, 'msg' => $msg), JSON_UNESCAPED_SLASHES);
    }
}
