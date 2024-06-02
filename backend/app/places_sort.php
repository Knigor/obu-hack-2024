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
function getPlacesInfo($name_city, $sort_by, $filter_type) {
    global $db;
    try {
        // Получаем id_city по названию города
        $stmt_city = $db->prepare("SELECT id_city FROM city WHERE name_city = :name_city");
        $stmt_city->bindParam(':name_city', $name_city);
        $stmt_city->execute();
        $city_info = $stmt_city->fetch(PDO::FETCH_ASSOC);

        if ($city_info) {
            $id_city = $city_info['id_city'];

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
                $stmt = $db->prepare("SELECT p.id_place, p.photo_place, p.name_place, p.url_place, p.favorites_count, p.id_city, p.desc_place
                                FROM public.places p
                                WHERE p.id_city = :id_city
                                ORDER BY favorites_count $order");
            }

            // Привязка параметров
            $stmt->bindParam(':id_city', $id_city);
            
            // Выполнение запроса
            $stmt->execute();
            
            // Получение результатов
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Возвращение результатов в формате JSON
            return json_encode($results);
        } else {
            return json_encode(array('error' => 'Город с таким названием не найден'));
        }
    } catch(PDOException $e) {
        return json_encode(array('error' => 'Ошибка выполнения запроса: ' . $e->getMessage()));
    }
}

// Проверка наличия параметров name_city, sort_by и filter_type в POST запросе
if(isset($_POST['name_city'])) {
    $name_city = $_POST['name_city'];
    
    // Проверка наличия параметров sort_by и filter_type, если они отсутствуют, устанавливаем значения по умолчанию
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'desc';
    $filter_type = isset($_POST['filter_type']) ? $_POST['filter_type'] : 'nofilter';
    
    // Получение информации о местах по названию города с сортировкой и возможной фильтрацией и вывод в формате JSON
    echo getPlacesInfo($name_city, $sort_by, $filter_type);
} else {
    // В случае отсутствия параметра name_city выдаем ошибку
    echo json_encode(array('error' => 'Параметр name_city отсутствует'));
}
?>
