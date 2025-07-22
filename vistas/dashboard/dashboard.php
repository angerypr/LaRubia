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
    <title>Panel Principal - La Rubia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
        }
        .center-panel {
            height: 100vh;
        }
    </style>
</head>
<body class="bg-light d-flex justify-content-center align-items-center">
    <div class="container center-panel d-flex flex-column justify-content-center">
        <h1 class="mb-5 text-center">Bienvenido, <?= $_SESSION['usuario']; ?></h1>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col">
                <a href="../clientes/agregar_cliente.php" class="btn btn-primary w-100 py-3">Registrar Cliente Nuevo</a>
            </div>
            <div class="col">
                <a href="../productos/agregar_producto.php" class="btn btn-secondary w-100 py-3">Registrar Producto Nuevo</a>
            </div>
            <div class="col">
                <a href="../facturas/formulario_factura.php" class="btn btn-success w-100 py-3">Crear Nueva Factura</a>
            </div>
            <div class="col">
                <a href="../facturas/reporte_diario.php" class="btn btn-warning w-100 py-3">Ver Reporte Diario</a>
            </div>
            <div class="col">
                <a href="../facturas/listar_facturas.php" class="btn btn-info w-100 py-3">Listar Facturas</a>
            </div>
            <div class="col">
                <a href="logout.php" class="btn btn-danger w-100 py-3">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>
