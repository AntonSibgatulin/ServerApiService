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



$param = array();
$param['user'] = getUserInfo($user->id)->toArray();
$param['code'] = 200;
$param['type'] = "user";
$param['description'] = "Succ";

echo json_encode($param);
exit();

?>