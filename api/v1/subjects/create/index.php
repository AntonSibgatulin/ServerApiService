<?php 


include_once "../../../../include/user/User.php";
include_once "../../../../include/user/UserExt.php";
include_once "../../../../include/money/MoneyModel.php";
include_once "../../../../include/wall/WallModel.php";
include_once "../../../../include/wall/UserWallModel.php";
include_once "../../../../include/user/TokenUser.php";
include_once "../../../../include/user/Account.php";
include_once "../../../../database/connection.php";
include_once "../../../../include/auth_token/index.php";
include_once "../../../../include/subject/UserSubjectModel.php";



$request = $_POST;
$request['id'] = null;
$request['block'] = 0;
$request['userId'] = $user->id;
$param = array();
$param['type'] = "create_subjects";
try{

    $userSubjectModel = new UserSubjectModel($request);

}catch(Exception $e){

    $param['code'] = 400;
    $param['description'] = "Invalid date";
    echo json_encode($param);
    exit();
}

$request['online'] = $request['online'] ==true?1:0;
$request['intramural'] = $request['intramural'] ==true?1:0;

$userSubjectModel = new UserSubjectModel($request);
$userSubjectModel->id = createUserSubjectModel($userSubjectModel,$user);

$param['code'] = 200;
$param['description']="OK";
$param['subject'] = $userSubjectModel->toArray();
echo json_encode($param);
exit();


?>