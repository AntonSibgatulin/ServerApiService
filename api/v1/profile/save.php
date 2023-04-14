<?php
include_once "../../../include/user/User.php";
include_once "../../../include/user/UserExt.php";
include_once "../../../include/money/MoneyModel.php";
include_once "../../../include/wall/WallModel.php";
include_once "../../../include/wall/UserWallModel.php";
include_once "../../../include/user/TokenUser.php";
include_once "../../../include/user/Account.php";
include_once "../../../database/connection.php";
include_once "../../../include/auth_token/index.php";
$request = $_POST;
$param = array();
$param['type'] = "saveProfile";
try {

    $description = $mysqli->real_escape_string($request['description']);
    $minDescription = $mysqli->real_escape_string($request['minDescription']);
    $name = $mysqli->real_escape_string($request['name']);
    $surname = $mysqli->real_escape_string($request['surname']);
    $days = $mysqli->real_escape_string($request['days']);
    $start = intval($request['start']);
    $end = intval($request['end']);
    $city_id = intval($request['city']);
    $region_id = intval($request['region']);


    if ($start < 0)
        $start = 0;
    if ($start > 23)
        $start = 0;


    if ($end < 0)
        $end = 0;
    if ($end > 23)
        $end = 0;


    if($start>$end){
        $endd = $end;
        $end = $start;
        $start = $endd;
    }



    $param['description'] = $description;
    $param['minDescription'] = $minDescription;
    $param['name'] = $name;
    $param['surname'] = $surname;
    $param['days'] = $days;
    $param['start'] = $start;
    $param['end'] = $end;
    $param['city'] = $city_id;
    $param['region'] = $region_id;

    $param['code'] = 200;



    updateAccount($user, $param);


} catch (Exception $e) {


    $param['code'] = 400;
    $param['description'] = "INVALID DATA";
}

echo json_encode($param);
exit();