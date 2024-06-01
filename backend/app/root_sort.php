<?php

// Подключение к базе данных
$host = 'postgres-db';
$dbname = 'obu-hack-2024';
$username = 'user';
$password = 'user';

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Получение параметров запроса
$sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : null;
$amount_stops = isset($_POST['amount_stops']) ? $_POST['amount_stops'] : null;
$selected_airline = isset($_POST['selected_airline']) ? $_POST['selected_airline'] : null;

// Запрос к базе данных
$query = "
    SELECT c.id_city, c.name_city, c.amount_views_city, f.from_flight, f.date_dep_flight,
           f.airline_flight, f.time_taken_flight, f.price, f.amount_stops, f.date_arr_flight, f.econom_class
    FROM city c
    LEFT JOIN flight f ON c.id_city = f.id_city
    WHERE 1=1
";

// Добавление фильтрации по количеству остановок, если указано
if ($amount_stops !== null) {
    $query .= " AND f.amount_stops = :amount_stops";
}

// Добавление фильтрации по выбранной авиалинии, если указана
if (!empty($selected_airline)) {
    $query .= " AND f.airline_flight = :selected_airline";
}

// Сортировка по популярности направлений
$query .= " ORDER BY c.amount_views_city DESC";

// Добавление дополнительной сортировки, если указана
switch ($sort_by) {
    case 'cheap':
        $query .= ", f.price ASC";
        break;
    case 'exp':
        $query .= ", f.price DESC";
        break;
    case 'arr':
        $query .= ", f.date_dep_flight ASC";
        break;
    case 'dep':
        $query .= ", f.date_arr_flight ASC";
        break;
}

try {
    $statement = $pdo->prepare($query);

    // Установка параметров запроса
    $params = array();

    // Добавление параметра количества остановок, если указано
    if ($amount_stops !== null) {
        $params['amount_stops'] = $amount_stops;
    }

    // Добавление параметра выбранной авиалинии, если указана
    if (!empty($selected_airline)) {
        $params['selected_airline'] = $selected_airline;
    }

    $statement->execute($params);
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Вывод результатов в формате JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
