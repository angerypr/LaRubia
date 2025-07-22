<?php
require_once '../../config.php';

if (isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $stmt = $conn->prepare("SELECT nombre FROM clientes WHERE codigo = ?");
    $stmt->execute([$codigo]);
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
    echo $cliente ? $cliente['nombre'] : '';
}
