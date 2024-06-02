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
    $required_fields = ['price_request', 'class_request', 'position_request', 'name_city', 'amount_stops_request', 'date_arr_request', 'date_dep_request', 'id_user'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Отсутствует обязательный параметр: $field"]);
            exit;
        }
    }

    // Поиск id_city по названию города
    $city_name = $_POST['name_city'];
    $city_sql = "SELECT id_city, amount_views_city FROM city WHERE name_city = ?";
    try {
        $city_stmt = $pdo->prepare($city_sql);
        $city_stmt->execute([$city_name]);
        $city = $city_stmt->fetch();
        
        if (!$city) {
            echo json_encode(['status' => 'error', 'message' => 'Город не найден']);
            exit;
        }
        
        $id_city = $city['id_city'];
        $amount_views_city = isset($city['amount_views_city']) ? $city['amount_views_city'] + 1 : 1;

        // Увеличение счетчика amount_views_city на 1
        $update_city_sql = "UPDATE city SET amount_views_city = ? WHERE id_city = ?";
        $update_city_stmt = $pdo->prepare($update_city_sql);
        $update_city_stmt->execute([$amount_views_city, $id_city]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при обновлении счетчика города: ' . $e->getMessage()]);
        exit;
    }

    // Подготовка и выполнение запроса на вставку данных
    $sql = "INSERT INTO ml_request (price_request, class_request, position_request, id_city, amount_stops_request, date_arr_request, date_dep_request, id_user) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['price_request'],
            $_POST['class_request'],
            $_POST['position_request'],
            $id_city,
            $_POST['amount_stops_request'],
            $_POST['date_arr_request'],
            $_POST['date_dep_request'],
            $_POST['id_user']
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Данные успешно добавлены']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Ошибка при выполнении запроса: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Данные принимаются только методом POST']);
}
?>
