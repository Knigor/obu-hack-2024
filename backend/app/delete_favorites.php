<?php
// Настройки подключения к базе данных
$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

try {
    $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

// Получение данных из POST-запроса
$id_place = $_POST['id_place'] ?? null;
$id_user = $_POST['id_user'] ?? null;

// Проверка, что данные были переданы
if ($id_place && $id_user) {
    // Подготовка и выполнение SQL-запроса
    $sql = "DELETE FROM favorites WHERE id_place = :id_place AND id_user = :id_user";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['id_place' => $id_place, 'id_user' => $id_user]);
        echo json_encode(['status' => 'success', 'message' => 'Favorite removed successfully']);
    } catch (\PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing id_place or id_user']);
}
?>
