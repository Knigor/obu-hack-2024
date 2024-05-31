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

// Запрос к базе данных
$query = "
    SELECT c.id_city, c.name_city, c.amount_views_city, f.from_flight, f.date_dep_flight,
           f.airline_flight, f.time_taken_flight, f.price, f.amount_stops, f.date_arr_flight
    FROM city c
    LEFT JOIN flight f ON c.id_city = f.id_city
    ORDER BY c.amount_views_city DESC
";

try {
    $statement = $pdo->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Вывод результатов в формате JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} catch (PDOException $e) {
    echo json_encode(array('error' => $e->getMessage()));
}
?>
