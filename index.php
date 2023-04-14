<?php

/*
$phoneCodes = Array(
    '+7'=>Array(
            'name'=>'Russia',
            'cityCodeLength'=>3,
            'zeroHack'=>false,
            'exceptions'=>Array(987,920,3004),
            'exceptions_max'=>3,
            'exceptions_min'=>1
        ),
    );

function phone($phone = '', $convert = true, $trim = true)
{
    global $phoneCodes; // только для примера! При реализации избавиться от глобальной переменной.
    if (empty($phone)) {
        return '';
    }
    // очистка от лишнего мусора с сохранением информации о «плюсе» в начале номера
    $phone=trim($phone);
    $plus = ($phone[ 0] == '+');
    $phone = preg_replace("/[^0-9A-Za-z]/", "", $phone);
    $OriginalPhone = $phone;
 
    // конвертируем буквенный номер в цифровой
    if ($convert == true && !is_numeric($phone)) {
        $replace = array('2'=>array('a','b','c'),
        '3'=>array('d','e','f'),
        '4'=>array('g','h','i'),
        '5'=>array('j','k','l'),
        '6'=>array('m','n','o'),
        '7'=>array('p','q','r','s'),
        '8'=>array('t','u','v'),
        '9'=>array('w','x','y','z'));
 
        foreach($replace as $digit=>$letters) {
            $phone = str_ireplace($letters, $digit, $phone);
        }
    }
 
    // заменяем 00 в начале номера на +
    if (substr($phone,  0, 2)=="00")
    {
        $phone = substr($phone, 2, strlen($phone)-2);
        $plus=true;
    }
 
    // если телефон длиннее 7 символов, начинаем поиск страны
    if (strlen($phone)>7)
    foreach ($phoneCodes as $countryCode=>$data)
    {
        $codeLen = strlen($countryCode);
        if (substr($phone,  0, $codeLen)==$countryCode)
        {
            // как только страна обнаружена, урезаем телефон до уровня кода города
            $phone = substr($phone, $codeLen, strlen($phone)-$codeLen);
            $zero=false;
            // проверяем на наличие нулей в коде города
            if ($data['zeroHack'] && $phone[ 0]=='0')
            {
                $zero=true;
                $phone = substr($phone, 1, strlen($phone)-1);
            }
 
            $cityCode=NULL;
            // сначала сравниваем с городами-исключениями
            if ($data['exceptions_max']!= 0)
            for ($cityCodeLen=$data['exceptions_max']; $cityCodeLen>=$data['exceptions_min']; $cityCodeLen--)
            if (in_array(intval(substr($phone,  0, $cityCodeLen)), $data['exceptions']))
            {
                $cityCode = ($zero? "0": "").substr($phone,  0, $cityCodeLen);
                $phone = substr($phone, $cityCodeLen, strlen($phone)-$cityCodeLen);
                break;
            }
            // в случае неудачи с исключениями вырезаем код города в соответствии с длиной по умолчанию
            if (is_null($cityCode))
            {
                $cityCode = substr($phone,  0, $data['cityCodeLength']);
                $phone = substr($phone, $data['cityCodeLength'], strlen($phone)-$data['cityCodeLength']);
            }
            // возвращаем результат
            return ($plus? "+": "").$countryCode.'('.$cityCode.')'.phoneBlocks($phone);
        }
    }
    // возвращаем результат без кода страны и города
    return ($plus? "+": "").phoneBlocks($phone);
}
 
// функция превращает любое число в строку формата XX-XX-... или XXX-XX-XX-... в зависимости от четности кол-ва цифр
function phoneBlocks($number){
    $add='';
    if (strlen($number)%2)
    {
        $add = $number[ 0];
        $add .= (strlen($number)<=5? "-": "");
        $number = substr($number, 1, strlen($number)-1);
    }
    return $add.implode("-", str_split($number, 2));
}
*/



if(isset($_FILES['uploadedFile']))
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
    $fileName = $_FILES['uploadedFile']['name'];
    $fileSize = $_FILES['uploadedFile']['size'];
    $fileType = $_FILES['uploadedFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $allowedfileExtensions = array('jpg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc');
    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = 'files/';
        $dest_path = $uploadFileDir . $newFileName;
        if(move_uploaded_file($fileTmpPath, $dest_path))
        {
          $message ='File is successfully uploaded.';
        }
        else
        {
          $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }
    }
}




?>
 <form method="POST" action="index.php" enctype="multipart/form-data">
    <div>
      <span>Upload a File:</span>
      <input type="file" name="uploadedFile" />
    </div>
    <input type="submit" name="uploadBtn" value="Upload" />
  </form>