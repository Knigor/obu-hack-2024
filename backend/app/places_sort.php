<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');

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

// Функция для получения информации о местах по id города с возможной фильтрацией
function getPlacesInfo($id_city, $sort_by, $filter_type) {
    global $db;
    try {
        if ($filter_type === 'fav') {
            // Фильтрация по избранным местам
            $order = $sort_by === 'up' ? 'ASC' : 'DESC';
            $stmt = $db->prepare("SELECT p.id_place, p.photo_place, p.name_place, p.url_place, p.favorites_count, p.id_city, p.desc_place
                                FROM public.places p
                                INNER JOIN public.favorites f ON p.id_place = f.id_place
                                WHERE f.id_user = 2 AND p.id_city = :id_city
                                ORDER BY favorites_count $order");
        } elseif ($filter_type === 'nofav') {
            // Фильтрация по неизбранным местам
            $order = $sort_by === 'up' ? 'ASC' : 'DESC';
            $stmt = $db->prepare("SELECT p.id_place, p.photo_place, p.name_place, p.url_place, p.favorites_count, p.id_city, p.desc_place
                                FROM public.places p
                                LEFT JOIN public.favorites f ON p.id_place = f.id_place AND f.id_user = 2
                                WHERE p.id_city = :id_city AND f.id_favorites IS NULL
                                ORDER BY favorites_count $order");
        } else {
            // Без фильтрации
            $order = $sort_by === 'up' ? 'ASC' : 'DESC';
            $stmt = $db->prepare("SELECT photo_place, desc_place, favorites_count FROM places WHERE id_city = :id_city ORDER BY favorites_count $order");
        }

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

// Проверка наличия параметров id_city, sort_by и filter_type в POST запросе
if(isset($_POST['id_city']) && isset($_POST['sort_by']) && isset($_POST['filter_type'])) {
    $id_city = $_POST['id_city'];
    $sort_by = $_POST['sort_by'];
    $filter_type = $_POST['filter_type'];
    // Получение информации о местах по id города с сортировкой и возможной фильтрацией и вывод в формате JSON
    echo getPlacesInfo($id_city, $sort_by, $filter_type);
} else {
    // В случае отсутствия параметров id_city, sort_by или filter_type выдаем ошибку
    echo json_encode(array('error' => 'Параметры id_city, sort_by или filter_type отсутствуют'));
}
?>
