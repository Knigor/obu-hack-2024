<?php
// Параметры подключения к базе данных
$db_host = "postgres-db";
$db_name = "obu-hack-2024";
$db_user = "user";
$db_password = "user";

try {
    // Подключение к базе данных
    $pdo = new PDO("pgsql:host=$db_host;dbname=$db_name", $db_user, $db_password);
    
    // Установка режима обработки ошибок
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Получение параметров запроса
    $from_flight = $_POST['from_flight'];
    $name_city = $_POST['name_city'];
    
    // Получаем id_city по name_city из таблицы city
    $stmt_city = $pdo->prepare("SELECT id_city FROM public.city WHERE name_city = :name_city");
    $stmt_city->execute(array('name_city' => $name_city));
    
    // Проверяем, есть ли результаты
    if ($stmt_city->rowCount() > 0) {
        // Если есть, получаем результат
        $city_result = $stmt_city->fetch(PDO::FETCH_ASSOC);
        $id_city = $city_result['id_city'];
        
        // Подготовка и выполнение запроса
        $stmt = $pdo->prepare("SELECT * FROM public.flight WHERE from_flight = :from_flight AND id_city = :id_city");
        $stmt->execute(array('from_flight' => $from_flight, 'id_city' => $id_city));
        
        // Формирование результата в формате JSON
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($result);
    } else {
        // Если результатов нет, выводим сообщение об ошибке
        echo json_encode(array('error' => 'Город не найден'));
    }
} catch(PDOException $e) {
    // Обработка ошибок
    echo "Ошибка: " . $e->getMessage();
}

// Закрытие соединения
$pdo = null;
?>
