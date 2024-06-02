<?php
header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Methods: GET');
// Настройки подключения к базе данных
$dbhost = 'postgres-db';
$dbname = 'obu-hack-2024';
$dbuser = 'user';
$dbpass = 'user';

try {
    $pdo = new PDO("pgsql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (\PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}

// Получите id_user из POST-запроса
$id_user = isset($_POST['id_user']) ? $_POST['id_user'] : null;

if ($id_user) {
    try {
        // Подготовьте SQL-запрос для получения информации из двух таблиц
        $query = "
            SELECT
                rh.view_date,
                r.position_request,
                r.positionto_request,
                r.date_arr_request,
                r.date_dep_request
            FROM
                ml_request_history rh
            JOIN
                ml_request r ON rh.id_ml_request = r.id_ml_request
            WHERE
                rh.id_user = :id_user
                AND r.id_user = :id_user
        ";

        // Подготовьте запрос к выполнению
        $statement = $pdo->prepare($query);

        // Привяжите значение id_user к параметру запроса
        $statement->bindParam(':id_user', $id_user, PDO::PARAM_INT);

        // Выполните запрос
        $statement->execute();

        // Получите результаты запроса
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // Выведите результаты в формате JSON
        echo json_encode($results);
    } catch (PDOException $e) {
        // Обработка ошибок запроса
        die("Ошибка выполнения запроса: " . $e->getMessage());
    }
} else {
    // В случае отсутствия id_user в POST-запросе выведите сообщение об ошибке
    echo "Ошибка: id_user не указан.";
}
?>
