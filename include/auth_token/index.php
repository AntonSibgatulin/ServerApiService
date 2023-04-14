<?php


//print_r($_POST);
$request = $_POST;
if(!isset($request['token'])){
    $param = array();
    $param['code'] = 401;
    $param['description'] = "401 token not found";
    $param['type'] = "check_token";
    echo json_encode($param);
    exit();
}

$user = getUserByToken($request['token']);
if($user == null){
    $param = array();
    $param['code'] = 401;
    $param['description'] = "401 Unauthorized";
    $param['type'] = "check_token";
    echo json_encode($param);
    exit();
}

setOnline($user);






?>