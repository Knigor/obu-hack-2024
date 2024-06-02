<?php
// Заголовки для разрешения CORS
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST, GET');

// Настройки подключения к базе данных PostgreSQL
$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

try {
    // Подключение к базе данных
    $dsn = "pgsql:host=$dbhost;dbname=$dbname";
    $pdo = new PDO($dsn, $dbuser, $dbpass);

    // Установка режима обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL-запрос для выборки данных с сортировкой по amount_views_city
    $sql = "SELECT id_city, name_city, amount_views_city, photo_city, desc_city FROM public.city ORDER BY amount_views_city DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Извлечение данных
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Установка заголовка Content-Type в JSON
    header('Content-Type: application/json');

    // Вывод данных в формате JSON
    echo json_encode($cities);

} catch (PDOException $e) {
    // Обработка ошибок подключения к базе данных
    echo 'Database error: ' . $e->getMessage();
}
?>
