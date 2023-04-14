<?php

class User
{
    public $id = null;
    public $login;
    public $password;
    public $email;
    public $number;
    public $name;
    public $surname;
    public $typeUser;
    public $type = 0;
    public $timeReg = 0;
    public $timeLastOnline = 0;

    public $lessonModel = null;
    public $moneyModel = null;
    public $accountModel = null;
    public $subjectsModel = null;
    public $payment = array();

    /*
    public function __construct($id,  $login,  $password, $email, $number,  $name,  $surname,  $typeUser,  $type, $timeReg, $timeLastOnline)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->email = $email;
        $this->number = $number;
        $this->name = $name;
        $this->surname = $surname;
        $this->typeUser = $typeUser;
        $this->type = $type;
        $this->timeReg = $timeReg;
        $this->timeLastOnline = $timeLastOnline;
    }
    */


    public function __construct($param)
    {
        $this->id = $param['id'];
        $this->login = $param['login'];
        $this->password = $param['password'];
        $this->email = $param['email'];
        $this->number = $param['number'];
        $this->name = $param['name'];
        $this->surname = $param['surname'];
        $this->typeUser = $param['typeUser'];
        $this->type = $param['type'];
        $this->timeReg = $param['timeReg'];
        $this->timeLastOnline = $param['timeLastOnline'];
    }


    public function setLessonModel(LessonModel $lessonModel)
    {
        $this->lessonModel = $lessonModel;
    }

    public function __toString()
    {
        return "[USER]: ID " . $this->id . " LOGIN " . $this->login;
    }

    public function toQuery()
    {
        $id = "NULL";
        if($this->id !=null){
            $id = $this->id;
        }
        return ("({$id},'{$this->login}','{$this->password}','{$this->email}','{$this->number}','{$this->name}','{$this->surname}',{$this->typeUser},{$this->type},{$this->timeReg},{$this->timeLastOnline})");
    }



    public static function checkLoginValid($login)
    {
        if (!preg_match(
            '/^(?=[a-z]{2})(?=.{4,26})(?=[^.]*\.?[^.]*$)(?=[^_]*_?[^_]*$)[\w.]+$/iD',
            $login
        )) {
            return false;
        } else {
            return true;
        }
    }

   
    public static function checkPhoneNumberValid($number)
    {
        return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }


    public function toJSON()
    {
        $param = array();
        $param['id'] = $this->id;
        $param['login'] = $this->login;
        //$param['password'] = $this->password;
        $param['email'] = $this->email;
        $param['number'] = $this->number;
        $param['name'] = $this->name;
        $param['surname'] = $this->surname;
        $param['typeUser'] = $this->typeUser;
        $param['type'] = $this->type;
        $param['timeReg'] = $this->timeReg;
        $param['timeLastOnline'] = $this->timeLastOnline;
        $param['type']="";
        if($this->moneyModel!=null){
            $param['money'] = json_decode($this->moneyModel->toJSON());
        }
        if($this->subjectsModel!=null){
            
            $param['subjects'] = $this->subjectsModel;

        }

       
        return json_encode($param);
    }

    
    public function toArray()
    {
        $param = array();
        $param['id'] = $this->id;
        $param['login'] = $this->login;
        //$param['password'] = $this->password;
        $param['email'] = $this->email;
        $param['number'] = $this->number;
        $param['name'] = $this->name;
        $param['surname'] = $this->surname;
        $param['typeUser'] = $this->typeUser;
        $param['type'] = $this->type;
        $param['timeReg'] = $this->timeReg;
        $param['timeLastOnline'] = $this->timeLastOnline;
        if($this->moneyModel!=null){
            $param['money'] = ($this->moneyModel->toArray());
        }

        if($this->accountModel!=null){
            $param['account'] = ($this->accountModel->toArray());
        }
        if($this->subjectsModel!=null){
            
            $param['subjects'] = $this->subjectsModel;

        }
        if($this->payment!=null){
            $param['payment'] = $this->payment;
        }
        return ($param);
    }
}



function format_phone($phone = '')
    {
        $phone = preg_replace('/[^0-9]/', '', $phone); // вернет 79851111111

        if (strlen($phone) != 11 and ($phone[0] != '7' or $phone[0] != '8')) {
            return null;
        }
        if($phone[0]=="8"){
            $phone="7".substr($phone,1,10);
        }
        
        $phone_number['dialcode'] = substr($phone, 0, 1);
        $phone_number['code']  = substr($phone, 1, 3);
        $phone_number['phone'] = substr($phone, -7);
        $phone_number['phone_arr'][] = substr($phone_number['phone'], 0, 3);
        $phone_number['phone_arr'][] = substr($phone_number['phone'], 3, 2);
        $phone_number['phone_arr'][] = substr($phone_number['phone'], 5, 2);        

        $format_phone = '+' . $phone_number['dialcode'] . ' ('. $phone_number['code'] .') ' . implode('-', $phone_number['phone_arr']);

        return $format_phone;
    }
