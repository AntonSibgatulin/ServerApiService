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

include_once "../../../include/wall/WallModel.php";
$request = $_POST;
$param = array();
$param['type'] = "deleteWallById";

if(isset($request['id'])){
    $id = intval($request['id']);
    $param['code'] = 200;
    deleteWallById($id,$user->id);
    echo json_encode($param);
    exit();
}

$param['code'] = 404;
$param['description'] ="Wall not found";
echo json_encode($param);
exit();