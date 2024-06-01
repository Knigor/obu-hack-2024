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
    echo json_encode(array('error' => 'Ошибка подключения к базе данных: ' . $e->getMessage()));
    exit;
}

// Функция для получения информации о местах по id города с возможностью сортировки и фильтрации
function getPlacesInfo($id_city, $sort_by, $filter, $id_user) {
    global $db;
    try {
        // Подготовка запроса с сортировкой и фильтрацией
        $order = $sort_by === 'up' ? 'ASC' : 'DESC';
        $filter_condition = '';
        $filter_params = array(':id_city' => $id_city);
        
        if ($filter === 'fav') {
            $filter_condition = 'AND p.id_place IN (SELECT id_place FROM favorites WHERE id_user = :id_user)';
            $filter_params[':id_user'] = $id_user;
        } elseif ($filter === 'nofav') {
            $filter_condition = 'AND p.id_place NOT IN (SELECT id_place FROM favorites WHERE id_user = :id_user)';
            $filter_params[':id_user'] = $id_user;
        }
        
        $stmt = $db->prepare("SELECT photo_place, desc_place, favorites_count FROM places p WHERE id_city = :id_city $filter_condition ORDER BY favorites_count $order");
        
        // Привязка параметров
        foreach ($filter_params as $param => $value) {
            $stmt->bindParam($param, $value);
        }
        
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

// Проверка наличия параметров id_city и sort_by в POST запросе
if(isset($_POST['id_city']) && isset($_POST['sort_by'])) {
    $id_city = $_POST['id_city'];
    $sort_by = $_POST['sort_by'];
    $filter = isset($_POST['filter']) ? $_POST['filter'] : 'no'; // Параметр фильтрации
    $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : null; // ID пользователя для фильтрации по избранным местам
    // Получение информации о местах по id города с сортировкой, фильтрацией и вывод в формате JSON
    echo getPlacesInfo($id_city, $sort_by, $filter, $id_user);
} else {
    // В случае отсутствия параметров id_city или sort_by выдаем ошибку
    echo json_encode(array('error' => 'Параметры id_city и sort_by отсутствуют'));
}
?>
