<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto - La Rubia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 500px;">
            <h3 class="mb-4 text-center">Agregar Nuevo Producto</h3>
            <?php
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">Producto agregado correctamente.</div>';
            }
            ?>
            <form method="POST" action="guardar_producto.php">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar Producto</button>
                <a href="../dashboard/dashboard.php" class="btn btn-secondary w-100 mt-2">Volver al Panel</a>
            </form>
        </div>
    </div>
</body>
</html>
