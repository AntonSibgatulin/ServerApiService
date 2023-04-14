<?php

include_once "../../../include/user/User.php";
include_once "../../../include/user/UserExt.php";
include_once "../../../include/money/MoneyModel.php";
include_once "../../../include/wall/WallModel.php";
include_once "../../../include/wall/UserWallModel.php";
include_once "../../../include/user/TokenUser.php";
include_once "../../../include/user/Account.php";
include_once "../../../database/connection.php";



$request = $_POST;

$param = array();


$number = null;

if (!isset($request['login'])) {
  
    $param['code'] = 400;
    $param['description'] = "Invalid login not found";
} else {

    if (!User::checkLoginValid($request['login'])) {
        $param['code'] = 400;
        $param['description'] = "Invalid login unvalivable";
    }
}

if (!isset($request['password'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid password not found";
} else {
    if (!User::checkLoginValid($request['password'])) {
        $param['code'] = 400;
        $param['description'] = "Invalid password unvalivable";
    }
}



if (!isset($request['email'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid email not found";
}else{
    if(!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $param['code'] = 400;
        $param['description'] = "Invalid email unvalivable";
   }
}

if (!isset($request['number'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid number not found";
}
else{
    $number = format_phone($request['number']);
    if(!User::checkPhoneNumberValid($request['number']) || $number==null){
        $param['code'] = 400;
        $param['description'] = "Invalid number unvalivable";
    }
}









if (!isset($request['name'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid name not found";
} else {
    if (strlen($request['name'])>15 || strlen($request['name'])<3 ) {
        $param['code'] = 400;
        $param['description'] = "Invalid name unvalivable";
    }
}

if (!isset($request['surname'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid surname not found";
} else {

    if (strlen($request['surname'])>15 || strlen($request['surname'])<3) {
        $param['code'] = 400;
        $param['description'] = "Invalid surname unvalivable";
    }
}



if (!isset($request['typeUser'])) {
    $param['code'] = 400;
    $param['description'] = "Invalid typeUser not found";
}else{
$num = intval($request['typeUser'],0);
   /* if () {
        $param['code'] = 400;
        $param['description'] = "Invalid typeUser unvalivable";
    }
    */
}



if (isset($param['code'])) {
    $json = json_encode($param);
    echo $json;
    exit(400);
}


$param['id'] = null;
$param['login'] = $mysqli->real_escape_string($request['login']);
$param['password'] = $mysqli->real_escape_string($request['password']);
$param['email'] = $mysqli->real_escape_string($request['email']);
$param['number'] = $mysqli->real_escape_string($number);
$param['name'] = $mysqli->real_escape_string($request['name']);
$param['surname'] = $mysqli->real_escape_string($request['surname']);
$param['typeUser'] = intval($request['typeUser']);
$param['type'] = 0;
$param['timeReg'] = time();
$param['timeLastOnline'] = time();

//include_once "database/connection.php";




$user = new User($param);
$user->id = saveUser($user);
$payment = getAllPayment($user);

$account = create_account($user);
$subjects = getAllSubjectUser($user);
$user->subjectsModel = $subjects;
$user->accountModel = $account;

$paramMoney = array();
$paramMoney['id'] = null;
$paramMoney['userId'] = $user->id;
$paramMoney['money'] = 0;

$money = new MoneyModel($paramMoney);
$money->id = saveMoney($money);
$user->moneyModel = $money;

$paramUser =  $user->toArray();
$param = array();
$param['code']=200;
$param["type"]="reg";
$param['user']=$paramUser;
$param['token'] = getToken($user);


echo json_encode($param);