<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../config.php'; 

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM clientes WHERE codigo = :codigo");
$stmt->execute(['codigo' => $codigo]);
$existe = $stmt->fetchColumn();

if ($existe > 0) {
    header("Location: agregar_cliente.php?error=duplicado");
    exit;
}

$stmt = $conn->prepare("INSERT INTO clientes (codigo, nombre) VALUES (:codigo, :nombre)");
$stmt->execute([
    'codigo' => $codigo,
    'nombre' => $nombre
]);

header("Location: agregar_cliente.php?success=1");
exit;
?>
