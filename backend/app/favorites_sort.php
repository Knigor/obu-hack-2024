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
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Получение параметра id_city из POST-запроса
$id_city = isset($_POST['id_city']) ? (int)$_POST['id_city'] : 0;

if ($id_city > 0) {
    // Запрос к базе данных
    $stmt = $pdo->prepare('SELECT photo_place, name_place, url_place, favorites_count, desc_place
                           FROM places
                           WHERE id_city = :id_city
                           ORDER BY favorites_count DESC');
    $stmt->execute(['id_city' => $id_city]);
    $places = $stmt->fetchAll();

    // Возврат результата в формате JSON
    header('Content-Type: application/json');
    echo json_encode($places);
} else {
    // Возврат ошибки, если id_city не указан или неверен
    header('HTTP/1.1 400 Bad Request');
    echo json_encode(['error' => 'Invalid or missing id_city']);
}
?>
