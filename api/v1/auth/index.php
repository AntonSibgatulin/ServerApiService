<?php

include_once "../../../include/user/User.php";
include_once "../../../include/user/UserExt.php";
include_once "../../../include/money/MoneyModel.php";
include_once "../../../include/wall/WallModel.php";
include_once "../../../include/wall/UserWallModel.php";
include_once "../../../include/user/TokenUser.php";
include_once "../../../include/user/Account.php";
include_once "../../../database/connection.php";
include_once "../../../include/subject/UserSubjectModel.php";



$request = $_POST;
$param = array();


if (!isset($request['number']) && !isset($request['login'])) {
    $param['code'] = 400;
    $param['description'] = "Enter number or login";
}
if (!isset($request['password'])) {
    $param['code'] = 400;
    $param['description'] = "Enter password";
}
/*
if(isset($request['number'])){
    if(!User::checkPhoneNumberValid($request['number'])){
        $param['code']=400;
        $param['description']="Unvalivable phone";
    }
}
*/
if (isset($request["login"])) {
    if (!User::checkLoginValid($request["login"])) {
        $param['code'] = 400;
        $param['description'] = "Unvalivable login";
    }
}

if (isset($request['code'])) {
    echo json_encode($param);
    exit(400);
}






$user = getUserByLogin($request['login'], $request['password']);


if ($user == null) {
    $param = array();
    $param['code'] = 404;
    $param['description'] = "User not found";
    $param['type'] = "auth";
    echo json_encode($param);
    exit(404);
}

$payment = getAllPayment($user);
$account = get_account($user);
$money = getMoneyByUserId($user);
$subjects = getAllSubjectUser($user);
$user->subjectsModel = $subjects;
$user->accountModel = $account;
$user->moneyModel = $money;
$paramUser = $user->toArray();
$user->payment = $payment;

$param = array();
$param['code'] = 200;
$param["type"] = "auth";
$param['user'] = $paramUser;
$param['token'] = getToken($user);

echo json_encode($param);
exit();
