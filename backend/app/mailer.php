<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$pdo = new PDO("pgsql:host=postgres-db;dbname=obu-hack-2024", "user", "user");

// 1. Выбор пользователей для рассылки
$sql_select_users = $pdo->prepare("SELECT email_user, full_name_user FROM users WHERE news_mailing = true AND date_mail <= NOW() - INTERVAL '2 days'");
$sql_select_users->execute();
$users_to_email = $sql_select_users->fetchAll(PDO::FETCH_ASSOC);

// 2. Рассылка сообщений
$mail = new PHPMailer(true);
$success_count = 0; // счетчик успешно отправленных сообщений

try {
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->isSMTP();
    $mail->Host = 'ssl://smtp.gmail.com';
    $mail->Port = 465;
    $mail->Username = 'maximwork19@gmail.com';
    $mail->Password = 'uvrwkhhpxolxchlg';

    $mail->CharSet = 'UTF-8';
    $mail->setFrom('maximwork19@gmail.com');

    foreach ($users_to_email as $user) {
        $email = $user['email_user'];
        $full_name = $user['full_name_user'];
        
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Акция от авиакомпании';
        $mail->Body = "
            <p>Уважаемый(ая) $full_name,</p>
            <p>Мы рады предложить вам эксклюзивную акцию от нашей авиакомпании!</p>
            <p>Только сегодня вы можете приобрести билеты со скидкой до 50% на множество направлений по всему миру.</p>
            <p>Не упустите возможность путешествовать по лучшим ценам!</p>
            <p>Желаем вам приятного путешествия с нашей авиакомпанией!</p>
            <p><img src='cid:samolet' alt='Самолет'></p>
        ";
   
    
        
        if ($mail->send()) {
            $success_count++;
            // 3. Обновление поля date_mail
            $update_date_stmt = $pdo->prepare("UPDATE users SET date_mail = NOW() WHERE email_user = ?");
            $update_date_stmt->execute([$email]);
        }

        // Очищаем адресата для следующего сообщения
        $mail->clearAddresses();
    }

    if ($success_count > 0) {
        echo "Рассылка успешно выполнена. Отправлено сообщений: $success_count";
    } else {
        echo "Никому не удалось отправить сообщение.";
    }

} catch (Exception $e) {
    echo "Ошибка при отправке письма: {$mail->ErrorInfo}";
}
?>
