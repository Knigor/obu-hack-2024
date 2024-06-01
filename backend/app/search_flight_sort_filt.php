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
$from_flight = $_POST['from_flight'];
$name_city = $_POST['name_city'];
$date_dep_flight = $_POST['date_dep_flight'];
$amount_passengers = $_POST['amount_passengers'];
$sort_by = $_POST['sort_by'];
$amount_stops = isset($_POST['amount_stops']) ? $_POST['amount_stops'] : null;
$airlines = isset($_POST['airlines']) ? $_POST['airlines'] : null;

// Проверка формата даты
$date_format = 'Y-m-d';
$d = DateTime::createFromFormat($date_format, $date_dep_flight);
if (!$d || $d->format($date_format) !== $date_dep_flight) {
    echo json_encode(array('error' => 'Неправильный формат даты. Используйте YYYY-MM-DD.'));
    exit;
}

// Проверка сортировки
$allowed_sort = array('cheap', 'exp', 'arr', 'dep');
if (!in_array($sort_by, $allowed_sort)) {
    echo json_encode(array('error' => 'Неправильный критерий сортировки.'));
    exit;
}

try {
    // Получаем id_city по name_city из таблицы city
    $stmt_city = $pdo->prepare("SELECT id_city FROM public.city WHERE name_city = :name_city");
    $stmt_city->execute(array('name_city' => $name_city));

    if ($stmt_city->rowCount() > 0) {
        $city_result = $stmt_city->fetch(PDO::FETCH_ASSOC);
        $id_city = $city_result['id_city'];

        // Увеличиваем значение amount_views_city для этого id_city
        $stmt_update_views = $pdo->prepare("UPDATE public.city SET amount_views_city = amount_views_city + 1 WHERE id_city = :id_city");
        $stmt_update_views->execute(array('id_city' => $id_city));

        // Запрос к базе данных с учетом параметров from_flight, id_city и date_dep_flight
        $query = "
            SELECT c.id_city, c.name_city, c.amount_views_city, f.from_flight, f.date_dep_flight,
                   f.airline_flight, f.time_taken_flight, f.price, f.amount_stops, f.date_arr_flight
            FROM city c
            LEFT JOIN flight f ON c.id_city = f.id_city
            WHERE f.from_flight = :from_flight AND c.id_city = :id_city AND f.date_dep_flight = :date_dep_flight
        ";

        // Добавление фильтрации по количеству остановок, если указано
        if ($amount_stops !== null) {
            $query .= " AND f.amount_stops = :amount_stops";
        }

        // Добавление фильтрации по авиалиниям, если указаны
        if (!empty($airlines)) {
            $query .= " AND f.airline_flight = :airline_flight";
        }

        // Добавление сортировки
        switch ($sort_by) {
            case 'cheap':
                $query .= " ORDER BY f.price ASC";
                break;
            case 'exp':
                $query .= " ORDER BY f.price DESC";
                break;
            case 'arr':
                $query .= " ORDER BY f.date_dep_flight ASC";
                break;
            case 'dep':
                $query .= " ORDER BY f.date_arr_flight ASC";
                break;
        }

        $statement = $pdo->prepare($query);

        // Установка параметров запроса
        $params = array(
            'from_flight' => $from_flight,
            'id_city' => $id_city,
            'date_dep_flight' => $date_dep_flight
        );

        // Добавление параметра количества остановок, если указано
        if ($amount_stops !== null) {
            $params['amount_stops'] = $amount_stops;
        }

        // Добавление параметра авиалиний, если указаны
        if (!empty($airlines)) {
            $params['airline_flight'] = $airlines;
        }

        $statement->execute($params);
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Если есть результаты, вычисляем стоимость с учетом количества пассажиров
        if ($results) {
            foreach ($results as &$row) {
                $row['total_price'] = $row['price'] * $amount_passengers;
            }
        }

        // Вывод результатов в формате JSON
        header('Content-Type: application/json');
        echo json_encode($results);
    } else {
        echo json_encode(array('error' => 'Город не найден'));
    }
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
