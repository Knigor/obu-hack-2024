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

// Функция для получения информации о месте по id места
function getPlaceInfoById($id_place) {
    global $db;
    try {
        // Подготовка запроса
        $stmt = $db->prepare("SELECT name_place, photo_place, desc_place, favorites_count FROM places WHERE id_place = :id_place");
        // Привязка параметров
        $stmt->bindParam(':id_place', $id_place);
        // Выполнение запроса
        $stmt->execute();
        // Получение результатов
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Возвращение результата в формате JSON
        return json_encode($result);
    } catch(PDOException $e) {
        return json_encode(array('error' => 'Ошибка выполнения запроса: ' . $e->getMessage()));
    }
}

// Проверка наличия параметра id_place в POST запросе
if(isset($_POST['id_place'])) {
    $id_place = $_POST['id_place'];
    // Получение информации о месте по id места и вывод в формате JSON
    echo getPlaceInfoById($id_place);
} else {
    // Если параметр id_place отсутствует, выводим ошибку
    echo json_encode(array('error' => 'Параметр id_place отсутствует'));
}
?>
