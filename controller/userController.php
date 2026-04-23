<?php
session_start();

require_once "../models/user.php";
require_once "../config/shiftsys.php";


// =====================
// REGISTRER
// =====================

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {

    $name  = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $pass  = $_POST['pass'] ?? null;

    if (!$name || !$email || !$pass) {
        exit;
    }

    $hashedPass = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $stmt = $conn->prepare("INSERT INTO customer (name, email, pass) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hashedPass]);

        header("Location: ../views/log-in.php");
        exit;

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



// =====================
// LOGIN
// =====================
if ($_SERVER["REQUEST_METHOD"] === "POST" && !isset($_POST['name'])) {

    $email = $_POST['email'] ?? null;
    $pass  = $_POST['pass'] ?? null;

    if (!$email || !$pass) {
        exit("Faltan datos.");
    }

    try {

        $stmt = $conn->prepare("SELECT * FROM customer WHERE email = ?");
        $stmt->execute([$email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($pass, $user['pass'])) {

            $_SESSION['user_id']   = $user['id_customer'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role']; 

           header("Location: ../controller/profileController.php");

            exit;

        } else {
            echo "Email o contraseña incorrectos.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
