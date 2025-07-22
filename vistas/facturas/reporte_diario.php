<?php
require_once '../../config.php';

$hoy = date('Y-m-d');

$stmt = $conn->prepare("SELECT * FROM facturas WHERE DATE(fecha) = :fecha");
$stmt->execute(['fecha' => $hoy]);
$facturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_diario = 0;
foreach ($facturas as $factura) {
    $total_diario += $factura['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Diario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container py-5">

    <h2 class="mb-4 text-center">Reporte Diario - <?= date('d/m/Y') ?></h2>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Número Recibo</th>
                <th>Cliente</th>
                <th>Total</th>
                <th>Comentario</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($facturas) === 0): ?>
                <tr>
                    <td colspan="5" class="text-center">No se han generado facturas hoy.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($facturas as $index => $factura): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $factura['numero_recibo'] ?></td>
                        <td><?= $factura['nombre_cliente'] ?></td>
                        <td>$<?= number_format($factura['total'], 2) ?></td>
                        <td><?= $factura['comentario'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="text-end mt-3">
        <h4>Total generado hoy: <strong class="text-success">$<?= number_format($total_diario, 2) ?></strong></h4>
    </div>

    <div class="text-center mt-4">
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Volver al Menú Principal</a>
    </div>

</body>
</html>
