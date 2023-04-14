<?php



$mysqli = mysqli_connect("localhost", "root", "Dert869$$", "repetitors");

if ($mysqli->connect_errno) {
    echo "Connection error " . $mysqli->connect_error;
    exit();
}

function getUserById($id)
{
    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `id` = {$id} LIMIT 1");
    return getUserFromQuery($result);
}


function getUserByToken($token)
{
    global $mysqli;
    $token = $mysqli->real_escape_string($token);
    $result = mysqli_query($mysqli, "SELECT * FROM `tokens` WHERE `token` = '{$token}' LIMIT 1 ");
    while ($row = mysqli_fetch_assoc($result)) {
        $token = new TokenUser($row['token'], $row['userId']);
        $user = getUserById($token->userId);
        return $user;
    }
    return null;
}

function getUserFromQuery($result)
{
    while ($row = mysqli_fetch_assoc($result)) {

        $user = new User($row);
        $user->moneyModel = getMoneyByUserId($user);

        return $user;
    }

    return null;
}


function getMoneyFromQuery($result)
{
    while ($row = mysqli_fetch_assoc($result)) {
        $money = new MoneyModel($row);
        return $money;
    }
    return null;
}


function getUserByLogin($login, $password)
{
    global $mysqli;
    $login = $mysqli->real_escape_string($login);


    $password = $mysqli->real_escape_string($password);


    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '{$login}' AND `password` = '{$password}' LIMIT 1");
    //echo ("SELECT * FROM `users` WHERE `login` = '{$login}' AND `password` = '{$password}' LIMIT 1");

    return getUserFromQuery($result);
}



function checkLogin($login)
{
    global $mysqli;
    $login = $mysqli->real_escape_string($login);
    $result = mysqli_query($mysqli, "SELECT * FROM `users` WHERE `login` = '{$login}' LIMIT 1");
    return getUserFromQuery($result);
}

function getMoneyByUserId($user)
{
    global $mysqli;

    $result = mysqli_query($mysqli, "SELECT * FROM `money` WHERE `userId` = '{$user->id}' LIMIT 1");
    return getMoneyFromQuery($result);
}


function saveUser($user)
{
    global $mysqli;
    mysqli_query($mysqli, "INSERT INTO `users`(`id`, `login`, `password`, `email`, `number`, `name`, `surname`, `typeUser`, `type`, `timeReg`, `timeLastOnline`) VALUES " . $user->toQuery());
    //echo "INSERT INTO `users`(`id`, `login`, `password`, `email`, `number`, `name`, `surname`, `typeUser`, `type`, `timeReg`, `timeLastOnline`) VALUES ".$user->toQuery();

    return mysqli_insert_id($mysqli);
}


function saveMoney($money)
{
    global $mysqli;
    mysqli_query($mysqli, "INSERT INTO `money`(`id`, `userId`, `money`) VALUES " . $money->toQuery());
    return mysqli_insert_id($mysqli);
}

function getToken($user)
{
    global $mysqli;
    $token = null;
    $gen = generateToken($user);
    mysqli_query($mysqli, "INSERT INTO `tokens` (`id`, `token`, `userId`) VALUES(NULL,'{$gen}',{$user->id})");

    return new TokenUser($gen, $user->id);
}
function generateToken($user)
{
    return base64_encode(time() . "ARAARASAOYNARA" . (time() / rand(0, 10000)) . "SATESATESATE" . (time()) . "{$user->login}OMAI{$user->id}");
}



function create_account($user)
{


    global $mysqli;


    $account = Account::create($user);

    mysqli_query($mysqli, "INSERT INTO `account` (`id`, `userId`, `minDescription`, `description`, `typePayment`, `phoneTrue`, `emailTrue`, `region`, `city`) VALUES " . $account->createQuerry());

    $account->id = mysqli_insert_id($mysqli);

    return $account;
}


function get_account($user)
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `account` WHERE `userId` = {$user->id} LIMIT 1");
    while ($row = mysqli_fetch_assoc($result)) {
        return new Account($row);
    }
    return null;
}



function getSubject()
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `subject`");
    $param = array();
    $param['code'] = 200;
    $param['type'] = 'subjects';
    $arr = array();
    $hash = array();

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($arr, $row);
        $hash[$row['id'] . '#id'] = $row['name'];
    }
    $param['hash'] = $hash;
    $param['subjects'] = $arr;
    return $param;
}


function createUserSubjectModel($userSubjectModel, $user)
{

    global $mysqli;

    $subjects = getSubject();
    $hash = $subjects['hash'];
    if (!isset($hash[$userSubjectModel->id_subject . "#id"])) {
        return 0;
    } else {

        if (strlen($userSubjectModel->information) > 500) {
            return 0;
        }


        if (getUserSubjectModelBySubjectId($user, $userSubjectModel->id_subject) != null) {

            deleteUserSubjectModelBySubjectId($user, $userSubjectModel->id_subject);
        }

        mysqli_query($mysqli, "INSERT INTO `usersubjects`(`id`,`userId`, `id_subject`, `price_on_hour`, `experience`, `information`, `online`, `intramural`,`oplata`, `block`) VALUES " . $userSubjectModel->toQuery($mysqli));

        return mysqli_insert_id($mysqli);
    }
}

function getUserSubjectModelBySubjectId($user, $subject_id)
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `usersubjects` WHERE `userId` = {$user->id} AND `id_subject` = {$subject_id}");
    while ($row = mysqli_fetch_assoc($result)) {
        $userSubjectModel = new UserSubjectModel($row);
        return $userSubjectModel;
    }
    return null;
}

function deleteUserSubjectModelBySubjectId($user, $subject_id)
{
    global $mysqli;
    mysqli_query($mysqli, "DELETE FROM `usersubjects` WHERE `userId` = {$user->id} AND `id_subject` = {$subject_id}");
}


function getAllUserSubjectByUserId($user)
{
    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `usersubjects` WHERE `userId` = {$user->id}");
    $arr = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $userSubjectModel = new UserSubjectModel($row);
        array_push($arr, $userSubjectModel->toArray());
    }
    return $arr;
}

function getUserInfo($id)
{

    $user = getUserById($id);
    
    if ($user == null) {
        return null;
    }
    $payment = getAllPayment($user);
    $account = get_account($user);
    $money = getMoneyByUserId($user);
    $subjects = getAllSubjectUser($user);
    $user->subjectsModel = $subjects;
    $user->accountModel = $account;
    $user->moneyModel = $money;
    $user->payment = $payment;
    return $user;
}

function getAllSubjectUser($user)
{

    global $mysqli;
    $result = mysqli_query($mysqli, "SELECT * FROM `usersubjects` WHERE `userId` = {$user->id} ");
    $arr = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $userSubjectModel = new UserSubjectModel($row);
        array_push($arr, $userSubjectModel);
    }
    return $arr;
}



function getAllPayment($user){
    global $mysqli;
    $result = mysqli_query($mysqli,"SELECT * FROM `payment` WHERE `userId` = {$user->id}");
    $arr = array();
    while($row = mysqli_fetch_assoc($result)){
        array_push($arr,$row);
    }

    return $arr;
}

function insertAllPayment($user,$request){
    global $mysqli;
    $type = intval($request['type']);
    if($type != 0 && $type != 1)return;
    delPayment($user,$type);
    $result = mysqli_query($mysqli,"INSERT INTO `payment` (`id`, `userId`, `number`, `type`) VALUES (NULL,{$user->id},'{$request["number"]}',{$type})");
}
function delPayment($user,$type){
    global $mysqli;
    mysqli_query($mysqli,"DELETE FROM `payment` WHERE `userId` = {$user->id} and `type` = {$type}");

}


function updateAccount ($user,$param){
    global $mysqli;

    mysqli_query($mysqli, "UPDATE `account` SET `minDescription`= '{$param['minDescription']}', `description`= '{$param['description']}' ,`days` = '{$param['days']}' ,`start` = {$param['start']} , `end` = {$param['end']} ,`city` = {$param['city']} , `region` = {$param['region']} WHERE `userId` = {$user->id}");
    mysqli_query($mysqli, "UPDATE `users` SET `name` = '{$param['name']}' , `surname` = '{$param['surname']}' WHERE `id` = {$user->id}");

}


function getAllCountry(){
    global $mysqli;

    $country = array();
    $region = array();
    $city = array();

    $result = mysqli_query($mysqli, "SELECT * FROM `country` WHERE `country_id` = 3159 ORDER BY `name` ASC");
    while($row = mysqli_fetch_assoc($result)){
        
        array_push($country, $row);

    }

    $result = mysqli_query($mysqli, "SELECT * FROM `region` WHERE `country_id` = 3159 ORDER BY `name` ASC");
    while($row = mysqli_fetch_assoc($result)){
        
        array_push($region, $row);

    }


    $result = mysqli_query($mysqli, "SELECT * FROM `city` WHERE `country_id` = 3159  ORDER BY `name` ASC");
    while($row = mysqli_fetch_assoc($result)){
        
        array_push($city, $row);

    }

    $param = array();
    $param['code'] = 200;
    $param['type'] = "location";
    $param['country'] = $country;
    $param['city'] = $city;
    $param['region'] = $region;
    return $param;
    

}




function save_photo_profile($user,$filename){
    global $mysqli;

    $time = time();
    mysqli_query($mysqli,"INSERT INTO `photo_profile`(`id`, `userId`, `timeload`, `file`) VALUES (NULL,{$user->id},{$time},'{$filename}')");


}



function resizeImage($filename, $max_width, $max_height)
{
    list($orig_width, $orig_height) = getimagesize($filename);

    $width = $orig_width;
    $height = $orig_height;

    # taller
    if ($height > $max_height) {
        $width = ($max_height / $height) * $width;
        $height = $max_height;
    }

    # wider
    if ($width > $max_width) {
        $height = ($max_width / $width) * $height;
        $width = $max_width;
    }

    $image_p = imagecreatetruecolor($width, $height);

    $image = imagecreatefromjpeg($filename);

    imagecopyresampled($image_p, $image, 0, 0, 0, 0,
                                     $width, $height, $orig_width, $orig_height);

    return $image_p;
}



function setOnline($user){

    global $mysqli;
    $time = time();
    $user -> timeLastOnline = $time;

    mysqli_query($mysqli,"UPDATE `users` SET `timeLastOnline` = {$time} WHERE `id` = {$user->id}");

}


function getPage($page){
    global $mysqli;

    $page = intval($page/10);
    $param = array();
    $result = mysqli_query($mysqli,"SELECT * FROM usersubjects ORDER BY RAND() LIMIT {$page},10");
    while($res = mysqli_fetch_assoc($result)){
        $element = new UserSubjectModel($res);
        $block = $element->toArray();

        array_push($param,$block);
    }

    return $param;
}



function createWall($wallModel){
    global $mysqli;
    mysqli_query($mysqli,"INSERT INTO `stock_market`(`id`, `name`, `description`, `price`, `maxprice`, `typeWall`, `countOffer`, `timeCreate`, `time`, `userId`,`deleted`,`block`) VALUES {$wallModel->toQuery()}");

    return $wallModel->toArray();
}


function getWallById($id){
    global $mysqli;
    $result = mysqli_query($mysqli,"SELECT * FROM `stock_market` WHERE `id` = {$id}");
    while($row = mysqli_fetch_assoc($result)){

        $wallModel = new WallModel($row);

        return $wallModel;
    }
    return array();
}


function deleteWallById($id,$userId){
    global $mysqli;
    mysqli_query($mysqli,"DELETE FROM `stock_market` WHERE `id` = {$id} and `userId` = {$userId}");
}



