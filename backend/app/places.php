<?php

// Параметры подключения к базе данных PostgreSQL
$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

// Подключение к базе данных
try {
    $db = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
    exit;
}

// Функция для получения информации о местах по id города
function getPlacesInfo($id_city) {
    global $db;
    try {
        // Подготовка запроса
        $stmt = $db->prepare("SELECT photo_place, desc_place, favorites_count FROM places WHERE id_city = :id_city");
        // Привязка параметров
        $stmt->bindParam(':id_city', $id_city);
        // Выполнение запроса
        $stmt->execute();
        // Получение результатов
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Возвращение результатов в формате JSON
        return json_encode($results);
    } catch(PDOException $e) {
        return json_encode(array('error' => 'Ошибка выполнения запроса: ' . $e->getMessage()));
    }
}

// Проверка наличия параметра id_city в POST запросе
if(isset($_POST['id_city'])) {
    $id_city = $_POST['id_city'];
    // Получение информации о местах по id города и вывод в формате JSON
    echo getPlacesInfo($id_city);
} else {
    // В случае отсутствия параметра id_city выдаем ошибку
    echo json_encode(array('error' => 'Параметр id_city отсутствует'));
}
?>