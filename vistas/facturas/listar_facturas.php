<?php
require_once '../../config.php';

$stmt = $conn->query("SELECT * FROM facturas ORDER BY fecha DESC");
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Facturas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h2 class="mb-4 text-center">Listado de Facturas</h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Número Recibo</th>
                <th>Fecha</th>
                <th>Código Cliente</th>
                <th>Nombre Cliente</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($facturas) === 0): ?>
                <tr>
                    <td colspan="7" class="text-center">No hay facturas registradas</td>
                </tr>
            <?php else: ?>
                <?php foreach ($facturas as $index => $factura): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $factura['numero_recibo'] ?></td>
                        <td><?= $factura['fecha'] ?></td>
                        <td><?= $factura['codigo_cliente'] ?></td>
                        <td><?= $factura['nombre_cliente'] ?></td>
                        <td>$<?= number_format($factura['total'], 2) ?></td>
                        <td>
                            <a href="ver_recibo.php?id=<?= $factura['id'] ?>" class="btn btn-success btn-sm" target="_blank">
                                Ver Recibo
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-center mt-4">
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Volver al Menú Principal</a>
    </div>

</body>
</html>
