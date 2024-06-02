<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');

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

// Проверка формата даты
$date_format = 'Y-m-d';
$d = DateTime::createFromFormat($date_format, $date_dep_flight);
if (!$d || $d->format($date_format) !== $date_dep_flight) {
    echo json_encode(array('error' => 'Неправильный формат даты. Используйте YYYY-MM-DD.'));
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
            ORDER BY c.amount_views_city DESC
        ";

        $statement = $pdo->prepare($query);
        $statement->execute(array(
            'from_flight' => $from_flight,
            'id_city' => $id_city,
            'date_dep_flight' => $date_dep_flight
        ));
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
