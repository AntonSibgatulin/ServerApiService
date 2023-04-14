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
$param['type'] = "savePayment";
try {

    $card = $mysqli->real_escape_string($request['number']);
    $type = $mysqli->real_escape_string($request['type']);
    if($type==1){
        $card = format_phone($card);
    }


    if ($card != null) {
        $param['number'] = $card;
        $param['type'] = $type;


        $param['code'] = 200;






    }else{
        $param['code'] = 400;
        $param['description'] = "INVALID DATA";
    }


    insertAllPayment($user, $param);
    
  
} catch (Exception $e) {

    $param['code'] = 400;
    $param['description'] = "INVALID DATA";
   
}

echo json_encode($param);
exit();