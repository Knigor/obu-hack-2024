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
    // Начало транзакции
    $pdo->beginTransaction();

    try {
        // Подготовка и выполнение SQL-запроса на добавление в избранное
        $sqlAddToFavorites = "INSERT INTO favorites (id_place, id_user) VALUES (:id_place, :id_user)";
        $stmtAddToFavorites = $pdo->prepare($sqlAddToFavorites);
        $stmtAddToFavorites->execute(['id_place' => $id_place, 'id_user' => $id_user]);

        // Обновление счетчика favorites_count в таблице places
        $sqlUpdateCount = "UPDATE places SET favorites_count = favorites_count + 1 WHERE id_place = :id_place";
        $stmtUpdateCount = $pdo->prepare($sqlUpdateCount);
        $stmtUpdateCount->execute(['id_place' => $id_place]);

        // Подтверждение транзакции
        $pdo->commit();

        echo json_encode(['status' => 'success', 'message' => 'Favorite added successfully']);
    } catch (\PDOException $e) {
        // Откат в случае ошибки
        $pdo->rollBack();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing id_place or id_user']);
}
?>
