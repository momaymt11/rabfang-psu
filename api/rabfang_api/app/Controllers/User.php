<?php

namespace App\Controllers;

use App\Models\PsychiatristModel;
use App\Models\UsersModel;
use App\Models\AppointmentModel;

use CodeIgniter\Database\Query;

class User extends BaseController
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
    }



    public function time_appoinntment()
    {

        $psy_id = $this->request->getVar('psy_id');
        $date = $this->request->getVar('date');

        $time = array(
            array('id' => 1, 'time' => "09:00"),
            array('id' => 2, 'time' => "09:30"),
            array('id' => 3, 'time' => "10:00"),
            array('id' => 4, 'time' => "10:30"),
            array('id' => 5, 'time' => "11:00"),
            array('id' => 6, 'time' => "11:30"),
            array('id' => 7, 'time' => "13:00"),
            array('id' => 8, 'time' => "13:30"),
            array('id' => 9, 'time' => "14:00"),
            array('id' => 10, 'time' => "14:30"),
        );

        $result = [];
        foreach ($time as $data) {
            $result[] = array('id' => $data['id'], 'time' => $data['time'], 'isValue' => $this->checkIsValue($psy_id, $date, $data['time']));
        }

        echo json_encode(array('status' => true, 'data' => $result), JSON_UNESCAPED_SLASHES);
    }


    public function checkIsValue($psy_id = false, $date = false, $time = false)
    {
        $pQuery = $this->db->prepare(function ($db) {
            $sql = 'SELECT a_psy_id,REPLACE(TRIM(TIME_FORMAT(TIME(a_date), "%H: %i"))," ", "") as a_time, DATE(a_date) as a_date  FROM appointment  HAVING a_psy_id = ?  AND a_date =  ? AND a_time =  ?';

            return (new Query($db))->setQuery($sql);
        });
        $data = $pQuery->execute($psy_id, $date, $time)->getRow();
        if ($data) {
            return true;
        } else {
            return false;
        }
    }



    public function user_make_an_appointment()
    {


        $data =  $this->PsychiatristModel->findAll();



        foreach ($data as $row) {

            $dataarr[] = array(
                'psy_id' => $row['psy_id'],
                'psy_image' => base_url('uploads') . '/' . $row['psy_image'],
                'psy_name' => $row['psy_name'],
                'psy_email' => $row['psy_email'],
                'psy_lang' => explode(",", $row['psy_lang']),
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function user_make_an_appointment_action()
    {

        $a_u_id = $this->request->getVar('a_u_id');
        $a_psy_id = $this->request->getVar('a_psy_id');
        $a_topic = $this->request->getVar('a_topic');
        $a_date = $this->request->getVar('a_date');


        $rules = [
            'a_u_id' => [
                'label'  => 'User',
                'rules'  => 'required',
            ],
            'a_psy_id' => [
                'label'  => 'Psychiatrist',
                'rules'  => 'required',
            ],
            'a_topic' => [
                'label'  => 'Topic',
                'rules'  => 'required',
            ],
            'a_date' => [
                'label'  => 'Date and Time',
                'rules'  => 'required',
            ],
        ];

        if (!$this->validate($rules)) {

            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {


            $data = [
                'a_u_id' => $a_u_id,
                'a_psy_id' => $a_psy_id,
                'a_topic' => $a_topic,
                'a_date' => $a_date,
            ];

            $result = $this->AppointmentModel->insert($data);

            if ($result) {
                echo json_encode(array('status' => true, 'msg' => 'success',));
            } else {
                echo json_encode(array('status' => false, 'msg' => 'error',));
            }
        }
    }



    public function user_my_appointment_book()
    {

        $u_id = $this->request->getVar('u_id');

        $data =  $this->AppointmentModel
            ->select("*,DATE_FORMAT(a_date, '%W %e %M %Y %H:%i') as a_date_as")
            ->join('psychiatrist', 'appointment.a_psy_id = psychiatrist.psy_id')
            ->where(['a_u_id' => $u_id])
            ->orderBy('a_date', 'ASC')
            ->findAll();

        foreach ($data as $row) {

            $dataarr[] = array(
                'a_id' => $row['a_id'],
                'psy_image' => base_url('uploads') . '/' . $row['psy_image'],
                'psy_name' => $row['psy_name'],
                'a_topic' => explode(",", $row['a_topic']),
                'psy_lang' => explode(",", $row['psy_lang']),
                'a_date_as' => $row['a_date_as'],
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function account_settings()
    {
        $u_id = $this->request->getVar('u_id');
        $data =  $this->UsersModel->where(['u_id' => $u_id])->find();

        foreach ($data as $row) {

            $dataarr = array(
                'u_id' => $row['u_id'],
                'u_image' => base_url('uploads') . '/' . $row['u_image'],
                'u_name' => $row['u_name'],
                'u_email' => $row['u_email'],
                'u_password' => $row['u_password'],
                'u_faculty' => $row['u_faculty'],
                'u_major' => $row['u_major'],
                'u_year' => $row['u_year'],
                'u_phone' => $row['u_phone'],
                'u_birthday' => $row['u_birthday'],
                'u_address' => $row['u_address'],
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function update_account()
    {

        $msg = '';
        $bool = null;
        $u_id = $this->request->getVar('u_id');
        $img = $this->request->getVar('file');
        $u_name = $this->request->getVar('u_name');
        $u_email = $this->request->getVar('u_email');
        $u_password = $this->request->getVar('u_password');
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
                'rules'  => 'required|valid_email|is_unique[users.u_email,u_email,{u_email}]',
            ],
            'u_password' => [
                'label'  => 'Password',
                'rules'  => 'trim',
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
                'u_name' => $u_name,
                'u_email' => $u_email,
                'u_faculty' => $u_faculty,
                'u_major' => $u_major,
                'u_year' => $u_year,
                'u_phone' => $u_phone,
                'u_birthday' => $u_birthday,
                'u_address' => $u_address,
            ];


            $this->UsersModel->update(['u_id' => $u_id], $data);

            if ($u_password != "") {
                $hashed_password = password_hash($u_password, PASSWORD_DEFAULT);
                $data = [
                    'u_password' => $hashed_password
                ];
                $this->UsersModel->update(['u_id' => $u_id], $data);
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
                            'u_image' => $fileName,
                        ];
                        $this->UsersModel->update(['u_id' => $u_id], $data);

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
