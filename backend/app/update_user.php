<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');

$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

header('Content-Type: application/json');

$response = array();

try {
    $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    $response['error'] = "Ошибка подключения к базе данных: " . $e->getMessage();
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из POST-запроса
    $id_user = $_POST["id_user"];

    // Проверяем, был ли передан пароль для обновления
    $password = null;
    if (isset($_POST["old_password"]) && isset($_POST["new_password"])) {
        $old_password = $_POST["old_password"];
        $new_password = $_POST["new_password"];
        // Проверяем, совпадает ли введенный старый пароль с тем, что есть в базе данных
        if (verifyOldPassword($id_user, $old_password)) {
            $password = hash("sha256", $new_password); // Хешируем новый пароль
        } else {
            $response['error'] = "Введен неправильный старый пароль.";
            echo json_encode($response);
            exit;
        }
    }

    // Получаем остальные данные для обновления
    $full_name = $_POST["full_name"] ?? null;
    $email = $_POST["email"] ?? null;
    $photo = $_FILES["photo"] ?? null;
    $news_mailing = $_POST["news_mailing"] ?? null;
    $phone = $_POST["phone"] ?? null;
    $birth = $_POST["birth"] ?? null;

    // Проверяем, был ли передан файл для загрузки
    if ($photo && $photo["error"] == UPLOAD_ERR_OK) {
        $photo_name = uploadImage($photo);
        if (!$photo_name) {
            $response['error'] = "Ошибка при загрузке изображения.";
            echo json_encode($response);
            exit;
        }
        // Добавляем слеш перед именем файла
        $photo_name = '/'.$photo_name;
    } else {
        $photo_name = null;
    }

    // Обновляем данные пользователя
    if (updateUser($id_user, $full_name, $email, $password, $photo_name, $news_mailing, $phone, $birth)) {
        $response['message'] = "Данные пользователя успешно обновлены.";
    } else {
        $response['error'] = "Ошибка при обновлении данных пользователя.";
    }
    echo json_encode($response);
}

function updateUser($user_id, $full_name, $email, $password, $photo, $news_mailing, $phone, $birth)
{
    global $pdo;

    $update_fields = [];
    $params = [];

    if ($full_name !== null) {
        $update_fields[] = "full_name_user=?";
        $params[] = $full_name;
    }
    if ($email !== null) {
        $update_fields[] = "email_user=?";
        $params[] = $email;
    }
    if ($password !== null) {
        $update_fields[] = "password_user=?";
        $params[] = $password;
    }
    if ($photo !== null) {
        $update_fields[] = "photo_user=?";
        $params[] = $photo;
    }
    if ($news_mailing !== null) {
        $update_fields[] = "news_mailing=?";
        $params[] = $news_mailing;
    }
    if ($phone !== null) {
        $update_fields[] = "phone_user=?";
        $params[] = $phone;
    }
    if ($birth !== null) {
        $update_fields[] = "birth_user=?";
        $params[] = $birth;
    }

    $update_fields_str = implode(",", $update_fields);

    try {
        $stmt = $pdo->prepare("UPDATE users SET $update_fields_str WHERE id_user=?");
        $params[] = $user_id;
        $stmt->execute($params);
        return true;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}

function uploadImage($image)
{
    $target_dir = "img/";
    $imageFileType = strtolower(pathinfo(basename($image["name"]), PATHINFO_EXTENSION));
    $target_file = $target_dir . date("YmdHis") . "." . $imageFileType;
    $uploadOk = 1;
    // Проверка наличия файла
    if (file_exists($target_file)) {
        $uploadOk = 0;
    }
    // Проверка размера файла
    if ($image["size"] > 500000) {
        $uploadOk = 0;
    }
    // Разрешенные форматы файлов
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }
    // Попытка загрузки файла
    if ($uploadOk == 0) {
        die("Ошибка при загрузке изображения.");
    } else {
        if (move_uploaded_file($image["tmp_name"], $target_file)) {
            return basename($target_file);
        } else {
            die("Ошибка при загрузке изображения.");
        }
    }
}

function verifyOldPassword($user_id, $old_password)
{
    global $pdo;
    
    try {
        $stmt = $pdo->prepare("SELECT password_user FROM users WHERE id_user=?");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch();
        if (!$row) {
            die("Пользователь не найден.");
        }
        $stored_password = $row['password_user'];
        $old_password_hash = hash("sha256", $old_password);
        return $stored_password === $old_password_hash;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
?>
