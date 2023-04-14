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

include_once "../../../include/subject/UserSubjectModel.php";

$request = $_POST;
$param = array();
$param['type'] = "home";

if(!isset($request['page'])){

    $param['code'] = 400;

    $param['description'] = "number page not found";
}

$page = intval($request['page']);

$param['subjects'] = getPage($page);

$param['code'] = 200;



echo json_encode($param);
exit();



