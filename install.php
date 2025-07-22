<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'la_rubia';

try {
    $conn = new PDO("mysql:host=$host", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $conn->exec("USE $dbname");

    $conn->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) UNIQUE,
        password VARCHAR(255)
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS productos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(100),
        precio DECIMAL(10,2)
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        codigo VARCHAR(50) UNIQUE,
        nombre VARCHAR(100)
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS facturas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        numero_recibo VARCHAR(20) UNIQUE,
        codigo_cliente VARCHAR(50),
        nombre_cliente VARCHAR(100),
        comentario TEXT,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
        total DECIMAL(10,2)
    )");

    $conn->exec("CREATE TABLE IF NOT EXISTS detalle_factura (
        id INT AUTO_INCREMENT PRIMARY KEY,
        factura_id INT,
        producto_id INT,
        cantidad INT,
        precio_unitario DECIMAL(10,2),
        subtotal DECIMAL(10,2),
        FOREIGN KEY (factura_id) REFERENCES facturas(id) ON DELETE CASCADE,
        FOREIGN KEY (producto_id) REFERENCES productos(id)
    )");

    $hash = password_hash("tareafacil25", PASSWORD_DEFAULT);
    $conn->exec("INSERT IGNORE INTO usuarios (username, password) VALUES ('demo', '$hash')");

    echo "Base de datos creada correctamente.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
