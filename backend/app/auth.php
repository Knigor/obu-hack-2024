<?php

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: POST');
session_start();

$pdo = new PDO("pgsql:host=postgres-db; dbname=obu-hack-2024", "user", "user");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"])) {

        $email = $_POST["email"];
        $password = $_POST["password"];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email_user = ? AND password_user = ?");
        $stmt->execute([$email,  $password]);
        $user = $stmt->fetch();

        if ($user) {

            $_SESSION["user"] = $user;

            $role = $user['role_user'];
            $fullName = $user['full_name_user'];
            $photo = $user['photo_user']; // Add this line to fetch the photo

            header('Content-Type: application/json');
            echo json_encode(array('status' => 'success', 'id_user' => $user['id_user'], 'role' => $role, 'full_name' => $fullName, 'photo_user' => $photo)); // Include 'photo_user' in the array
            exit();
        } else {

            header('Content-Type: application/json');
            echo json_encode(array('status' => 'error', 'message' => 'Неверное имя пользователя или пароль.'));
            exit();
        }
    }
}
?>
