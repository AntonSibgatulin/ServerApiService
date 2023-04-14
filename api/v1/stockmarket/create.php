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
$param['type'] = "CreateStockMarket";



try {
    $request['userId'] = $user->id;
    $request['block'] = 0;
    $request['delete'] = 0;
    
    $wall = new WallModel($request);
    $wall->description = $mysqli->escape_string($wall->description);
    $wall->name = $mysqli->escape_string($wall->name);
    if ($wall->price < 500 || $wall->price > 300000) {
        $wall->price = 500;
    }
    if ($wall->maxprice > 300000 || $wall->maxprice) {
        $wall->maxprice = $wall->price;
    }

    $param['wall'] = createWall($wall);

    $param['code'] = 200;
    echo json_encode($param);
    exit();
} catch (Exception $e) {

    $param['code'] = 400;
    $param['description'] = 'Unvalivable data';

    echo json_encode($param);
    exit();
}
