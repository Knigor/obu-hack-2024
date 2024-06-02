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

// Обработка POST-запроса
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка наличия всех необходимых параметров
    $required_fields = ['price_request', 'class_request', 'position_request', 'positionTo_request', 'amount_stops_request', 'date_arr_request', 'date_dep_request', 'id_user'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            die("Отсутствует обязательный параметр: $field");
        }
    }

    // Подготовка и выполнение запроса на вставку данных
    $sql = "INSERT INTO ml_request (price_request, class_request, position_request, positionTo_request, amount_stops_request, date_arr_request, date_dep_request, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['price_request'],
            $_POST['class_request'],
            $_POST['position_request'],
            $_POST['positionTo_request'],
            $_POST['amount_stops_request'],
            $_POST['date_arr_request'],
            $_POST['date_dep_request'],
            $_POST['id_user']
        ]);
        echo "Данные успешно добавлены";
    } catch (PDOException $e) {
        die("Ошибка при выполнении запроса: " . $e->getMessage());
    }
} else {
    echo "Данные принимаются только методом POST";
}
?>
