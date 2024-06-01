<?php

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
    // Получаем id пользователя из POST-запроса
    if (isset($_POST["id_user"])) {
        $id_user = $_POST["id_user"];
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id_user = ?");
            $stmt->execute([$id_user]);
            $user = $stmt->fetch();
            if ($user) {
                unset($user['password_user']); // Удаляем пароль из данных пользователя
                $response = $user;
            } else {
                $response['error'] = "Пользователь не найден.";
            }
        } catch (PDOException $e) {
            $response['error'] = "Ошибка выполнения запроса: " . $e->getMessage();
        }
    } else {
        $response['error'] = "Не указан id пользователя.";
    }
    echo json_encode($response);
}
?>
