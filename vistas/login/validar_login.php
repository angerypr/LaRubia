<?php
session_start();
require '../../config.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        header("Location: login.php?error=Debe llenar todos los campos");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario) {
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['username'];
            header("Location: ../dashboard/dashboard.php");
            exit;
        } else {
            header("Location: login.php?error=Contraseña incorrecta");
            exit;
        }
    } else {
        header("Location: login.php?error=Usuario no encontrado");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
