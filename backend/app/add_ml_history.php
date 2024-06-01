<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');

// Настройки подключения к базе данных
$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

try {
    $dbh = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}


// Получение данных из POST запроса
$id_ml_request = $_POST['id_ml_request'];
$id_user = $_POST['id_user'];

// Текущая дата и время
$view_date = date('Y-m-d H:i:s');

// Подготовка и выполнение SQL запроса
$sql = "INSERT INTO ml_request_history (id_ml_request, id_user, view_date) VALUES (?, ?, ?)";
$stmt = $dbh->prepare($sql);

try {
    $stmt->execute([$id_ml_request, $id_user, $view_date]);
    $result = array("status" => "success", "message" => "Запись успешно добавлена");
    echo json_encode($result);
} catch (PDOException $e) {
    $result = array("status" => "error", "message" => "Ошибка добавления записи: " . $e->getMessage());
    echo json_encode($result);
}
?>
