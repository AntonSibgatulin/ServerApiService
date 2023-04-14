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

function base64url_decode( $data ){
    return base64_decode( strtr( $data, '-_', '+/') . str_repeat('=', 3 - ( 3 + strlen( $data )) % 4 ));
  }


$request = $_POST;
$param = array();
$param['type'] = "upload";


if (isset($request['base64'])) {
    $base64 = str_replace(" ","+",$request['base64']);
    $fileName = "tmp/".md5("random_name_".time()).".png";
    file_put_contents($fileName , base64_decode(str_replace(" ","+",$request['base64'])));



   $fileTmpPath = imagecreatefromstring(base64_decode($base64));
    
    $fileSize = strlen($request['base64']);

    if ($fileSize <= 6000000) {
      
        $newFileName = md5(time() . $fileName) . '.png';
        $maxDim = 128;
        list($width, $height, $type, $attr) = getimagesize($fileName );

        // if ( $width > $maxDim || $height > $maxDim ) {

        $ratio = $width / $height;
        if ($ratio > 1) {
            $new_width = $maxDim;
            $new_height = $maxDim / $ratio;
        } else {
            $new_width = $maxDim * $ratio;
            $new_height = $maxDim;
        }
        $src = imagecreatefromstring(base64_decode($base64));
        $dst = imagecreatetruecolor($new_width, $new_height);

        $uploadFileDir = '../../../files/';
        $dest_path = $uploadFileDir . $newFileName;


        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($src);
        imagepng($dst,$dest_path); // adjust format as needed
        imagedestroy($dst);

        save_photo_profile($user, $newFileName);
        unlink($fileName);
        //}



        /* 
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                save_photo_profile($user, $newFileName);

                $message = 'File is successfully uploaded.';
                $param['code'] = 200;
            } else {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                $param['code'] = 400;
            }
            */
        
    }
    
}
//$param['description'] = $message;


echo json_encode($param);
exit();