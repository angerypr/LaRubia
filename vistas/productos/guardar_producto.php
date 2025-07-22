<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=la_rubia", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO productos (nombre, precio) VALUES (:nombre, :precio)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':precio' => $precio
        ]);

        header("Location: agregar_producto.php?success=1");
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
