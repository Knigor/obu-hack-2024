<?php

// Проверяем, был ли отправлен POST запрос
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Установка соединения с базой данных
    $dbhost = 'postgres-db';
    $dbname = 'obu-hack-2024';
    $dbuser = 'user';
    $dbpass = 'user';

    try {
        $dbh = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }

    // Получение данных по id_user
    $id_user = isset($_POST['id_user']) ? $_POST['id_user'] : null;

    if ($id_user) {
        $stmt = $dbh->prepare("
            SELECT rh.view_date, f.from_flight, c.name_city AS to_city, f.date_dep_flight, f.date_arr_flight
            FROM request_history rh
            INNER JOIN flight f ON rh.id_flight = f.id_flight
            INNER JOIN city c ON f.id_city = c.id_city
            WHERE rh.id_user = :id_user
        ");

        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Формирование JSON ответа
        header('Content-Type: application/json');
        echo json_encode($data);
    } else {
        echo "Please provide id_user parameter";
    }
} else {
    echo "Only POST requests are allowed";
}
?>
