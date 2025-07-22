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
    <title>Agregar Cliente - La Rubia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4 w-100" style="max-width: 600px;">
            <h3 class="mb-4 text-center">Agregar Nuevo Cliente</h3>

            <?php
            if (isset($_GET['success'])) {
                echo '<div class="alert alert-success">Cliente agregado correctamente.</div>';
            }

            if (isset($_GET['error']) && $_GET['error'] == 'duplicado') {
                echo '<div class="alert alert-danger">El código del cliente ya está registrado. Intenta con otro.</div>';
            }

            if (isset($_GET['error']) && $_GET['error'] == 'db') {
                echo '<div class="alert alert-danger">Ocurrió un error al guardar el cliente. Inténtalo nuevamente.</div>';
            }
            ?>

            <form action="guardar_cliente.php" method="POST">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código del Cliente</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Guardar Cliente</button>
                <a href="../dashboard/dashboard.php" class="btn btn-secondary w-100 mt-2">Volver al Panel</a>
            </form>
        </div>
    </div>
</body>
</html>
