<?php

use JetBrains\PhpStorm\Language;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

$mail->SMTPDebug = 2;

//От кого письмо
$mail->setFrom('hack81644@gmail.com', 'АСУшники из МАДИ');
//Кому отправить
$mail->addAddress('andrewop66@mail.ru');
//Тема письма
$mail->Subject = 'Привет! Это новое письмо с сайта SmartEye';

//Тело письма
$body = '<h1>Встречайте супер письмо!</h1>';

if(trim(!empty($_POST['name']))){
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
    $body.='<p><strong>E-mail:</strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['message']))){
    $body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
}

//Прикрепить файл
if(!empty($_FILES['image']['tmp_name'])){
    //путь загрузки файла
    $filePath = __DIR__ . "/files/" . $_FILES['image']['name'];
    //грузим файл

    if(copy($_FILES['image']['tmp_name'], $filePath)){
        $fileAttach = $filePath;
        $body.='<p><strong>Фото в приложении</strong>';
        $mail->addAttachment($fileAttach);
    }
}

$mail->Body = $body;

//Отправляем
if(!$mail->send()){
    $message = 'Ошибка';
}else{
    $message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);

?>

