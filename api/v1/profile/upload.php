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
$param['type'] = "upload";


if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    if ($fileSize <= 6000000) {
        $fileType = $_FILES['uploadedFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $allowedfileExtensions = array('jpg', 'gif', 'png');

        $maxDim = 96;
        list($width, $height, $type, $attr) = getimagesize($fileTmpPath);

        // if ( $width > $maxDim || $height > $maxDim ) {

        $ratio = $width / $height;
        if ($ratio > 1) {
            $new_width = $maxDim;
            $new_height = $maxDim / $ratio;
        } else {
            $new_width = $maxDim * $ratio;
            $new_height = $maxDim;
        }
        $src = imagecreatefromstring(file_get_contents($fileTmpPath));
        $dst = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        imagedestroy($src);
        imagepng($dst, $target_filename); // adjust format as needed
        imagedestroy($dst);
        //}



        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = '../../../files/';
            $dest_path = $uploadFileDir . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                save_photo_profile($user, $newFileName);

                $message = 'File is successfully uploaded.';
                $param['code'] = 200;
            } else {
                $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                $param['code'] = 400;
            }
        }
    }
}
$param['description'] = $message;


echo json_encode($param);
exit();


?>