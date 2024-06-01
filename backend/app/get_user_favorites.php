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

// Получение id_user из POST-запроса
$id_user = $_POST['id_user'] ?? null;

// Проверка, что id_user был передан
if ($id_user) {
    // Подготовка и выполнение SQL-запроса
    $sql = "
        SELECT 
            p.id_place, 
            p.name_place, 
            p.desc_place, 
            p.photo_place,
            p.favorites_count, 
            p.id_city
        FROM 
            favorites f
        JOIN 
            places p ON f.id_place = p.id_place
        WHERE 
            f.id_user = :id_user
    ";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute(['id_user' => $id_user]);
        $results = $stmt->fetchAll();

   if ($results) {
    $total_count = count($results); // Подсчет количества объектов
    echo json_encode(['status' => 'success', 'total_count' => $total_count, 'data' => $results]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No favorites found for this user']);
}
    } catch (\PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Missing id_user']);
}
