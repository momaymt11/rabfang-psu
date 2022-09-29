<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\PsychiatristModel;
use App\Models\SatisfactionModel;
use App\Models\MentalhealthFormModel;
use App\Models\SatisfactionFormModel;

class Admin extends BaseController
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
        $this->PsychiatristModel = new PsychiatristModel();
        $this->SatisfactionModel = new SatisfactionModel();
        $this->MentalhealthFormModel = new MentalhealthFormModel();
        $this->SatisfactionFormModel = new SatisfactionFormModel();
    }


    public function user_list()
    {

        $data = $this->UsersModel->findAll();

        foreach ($data as $row) {
            $dataarr[] = array(
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


    public function user_add()
    {

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
                'rules'  => 'required|valid_email|is_unique[users.u_email]',
            ],
            'u_password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',
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


    public function user_update()
    {

        $msg = '';
        $bool = null;
        $u_id = $this->request->getVar('u_id');
        $u_name = $this->request->getVar('u_name');
        $u_email = $this->request->getVar('u_email');
        $password = $this->request->getVar('password');
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

            if ($password != "") {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $data = [
                    'u_password' => $hashed_password
                ];
                $this->UsersModel->update(['u_id' => $u_id], $data);
            }

            $bool = true;
            $msg = 'success';
        }
        echo json_encode(array('status' => $bool, 'msg' => $msg), JSON_UNESCAPED_SLASHES);
    }







    public function user_delete()
    {
        $u_id = $this->request->getVar('u_id');

        $result =  $this->UsersModel->delete(['u_id' => $u_id]);
        if ($result) {
            echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function psy_list()
    {

        $data = $this->PsychiatristModel->findAll();

        foreach ($data as $row) {
            $dataarr[] = array(
                'psy_id' => $row['psy_id'],
                'psy_image' => base_url('uploads') . '/' . $row['psy_image'],
                'psy_name' => $row['psy_name'],
                'psy_email' => $row['psy_email'],
                'psy_password' => $row['psy_password'],
                'psy_lang' => $row['psy_lang'],
            );
        }

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $dataarr), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function  psy_add_account()
    {

        $psy_name = $this->request->getVar('psy_name');
        $psy_email = $this->request->getVar('psy_email');
        $password = $this->request->getVar('password');
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
            'password' => [
                'label'  => 'Password',
                'rules'  => 'trim|required',
            ],
            'psy_lang' => [
                'label'  => 'Language',
                'rules'  => 'required',
            ],
        ];


        if (!$this->validate($rules)) {
            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $data = [
                'psy_image' => 'no_image.jpg',
                'psy_name' => $psy_name,
                'psy_email' => $psy_email,
                'psy_password' => $hashed_password,
                'psy_lang' => $psy_lang,
            ];

            $result =   $this->PsychiatristModel->insert($data);
            if ($result) {
                echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
            }
        }
    }


    public function psy_update_account()
    {

        $msg = '';
        $bool = null;
        $psy_id = $this->request->getVar('psy_id');
        $psy_name = $this->request->getVar('psy_name');
        $psy_email = $this->request->getVar('psy_email');
        $password = $this->request->getVar('password');
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
            'password' => [
                'label'  => 'Password',
                'rules'  => 'trim',
            ],
            'psy_lang' => [
                'label'  => 'Language',
                'rules'  => 'required',
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

            if ($password != "") {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $data = [
                    'psy_password' => $hashed_password
                ];
                $this->PsychiatristModel->update(['psy_id' => $psy_id], $data);
            }

            $bool = true;
            $msg = 'success';
        }
        echo json_encode(array('status' => $bool, 'msg' => $msg), JSON_UNESCAPED_SLASHES);
    }


    public function psy_delete()
    {
        $psy_id = $this->request->getVar('psy_id');

        $result =  $this->PsychiatristModel->delete(['psy_id' => $psy_id]);
        if ($result) {
            echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function mental_healt_list()
    {
        $data = $this->MentalhealthFormModel->findAll();

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $data), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function  mental_healt_add()
    {

        $m_f_question = $this->request->getVar('m_f_question');
        $rules = [
            'm_f_question' => [
                'label'  => 'Question name',
                'rules'  => 'required',
            ],

        ];

        if (!$this->validate($rules)) {
            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $data = [
                'm_f_question' => $m_f_question,
            ];

            $result =   $this->MentalhealthFormModel->insert($data);
            if ($result) {
                echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
            }
        }
    }


    public function mental_healt_edit()
    {

        $m_f_id = $this->request->getVar('m_f_id');
        $m_f_question = $this->request->getVar('m_f_question');

        $rules = [
            'm_f_question' => [
                'label'  => 'Question Name',
                'rules'  => 'required',
            ],

        ];

        if (!$this->validate($rules)) {
            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $data = [
                'm_f_question' => $m_f_question,
            ];
            $result =   $this->MentalhealthFormModel->update(['m_f_id' => $m_f_id], $data);

            if ($result) {
                echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
            }
        }
    }


    public function mental_healt_delete()
    {
        $m_f_id = $this->request->getVar('m_f_id');

        $result =  $this->MentalhealthFormModel->delete(['m_f_id' => $m_f_id]);
        if ($result) {
            echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }

    public function satisfaction_list()
    {
        $data = $this->SatisfactionFormModel->findAll();

        if ($data) {
            echo json_encode(array('status' => true, 'data' => $data), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }




    public function satisfaction_add()
    {

        $s_f_question = $this->request->getVar('s_f_question');
        $rules = [
            's_f_question' => [
                'label'  => 'Question name',
                'rules'  => 'required',
            ],

        ];

        if (!$this->validate($rules)) {
            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $data = [
                's_f_question' => $s_f_question,
            ];

            $result =   $this->SatisfactionFormModel->insert($data);
            if ($result) {
                echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
            }
        }
    }


    public function satisfaction_edit()
    {

        $s_f_id = $this->request->getVar('s_f_id');
        $s_f_question = $this->request->getVar('s_f_question');

        $rules = [
            's_f_question' => [
                'label'  => 'Question Name',
                'rules'  => 'required',
            ],

        ];

        if (!$this->validate($rules)) {
            echo json_encode(array('status' => false, 'msg' => $this->validator->listErrors(),));
        } else {

            $data = [
                's_f_question' => $s_f_question,
            ];
            $result =   $this->SatisfactionFormModel->update(['s_f_id' => $s_f_id], $data);

            if ($result) {
                echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
            }
        }
    }

    public function satisfaction_delete()
    {
        $s_f_id = $this->request->getVar('s_f_id');

        $result =  $this->SatisfactionFormModel->delete(['s_f_id' => $s_f_id]);
        if ($result) {
            echo json_encode(array('status' => true, 'data' => []), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }


    public function satisfaction_result()
    {

        $data =  $this->SatisfactionModel
            ->select("*,DATE_FORMAT(s_datetime, '%W %e %M %Y %H:%i') as s_datetime_as ,SUM(s_a_q_value) as total")
            ->join('satisfaction_ans', 'satisfaction.s_id = satisfaction_ans.s_a_s_id')
            ->groupBy('s_id')
            ->orderBy('s_datetime', 'DESC')
            ->findAll();


        if ($data) {
            echo json_encode(array('status' => true, 'data' => $data), JSON_UNESCAPED_SLASHES);
        } else {
            echo json_encode(array('status' => false, 'data' => []), JSON_UNESCAPED_SLASHES);
        }
    }
}
