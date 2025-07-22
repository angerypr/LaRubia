<?php
require_once '../../config.php';

if (!isset($_GET['id'])) {
    die('ID de factura no proporcionado');
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM facturas WHERE id = ?");
$stmt->execute([$id]);
$factura = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$factura) {
    die('Factura no encontrada');
}

$stmt = $conn->prepare("SELECT df.*, p.nombre AS nombre_producto
                        FROM detalle_factura df
                        JOIN productos p ON df.producto_id = p.id
                        WHERE df.factura_id = ?");
$stmt->execute([$id]);
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo <?= $factura['numero_recibo'] ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        .totales { text-align: right; font-weight: bold; }
        .comentario { margin-top: 20px; }
        .btn-print {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
            width: 120px;
        }
        @media print {
            .btn-print { display: none; }
        }
    </style>
</head>
<body>

    <h2>Recibo de Factura</h2>

    <p><strong>Número de Recibo:</strong> <?= $factura['numero_recibo'] ?></p>
    <p><strong>Fecha:</strong> <?= $factura['fecha'] ?></p>
    <p><strong>Código Cliente:</strong> <?= $factura['codigo_cliente'] ?></p>
    <p><strong>Nombre Cliente:</strong> <?= $factura['nombre_cliente'] ?></p>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio Unitario</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detalles as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nombre_producto']) ?></td>
                    <td><?= number_format($item['precio_unitario'], 2) ?></td>
                    <td><?= $item['cantidad'] ?></td>
                    <td><?= number_format($item['subtotal'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="totales">Total:</td>
                <td><strong><?= number_format($factura['total'], 2) ?></strong></td>
            </tr>
        </tfoot>
    </table>

    <?php if (!empty($factura['comentario'])): ?>
        <div class="comentario">
            <strong>Comentario:</strong>
            <p><?= nl2br(htmlspecialchars($factura['comentario'])) ?></p>
        </div>
    <?php endif; ?>

    <a href="#" onclick="window.print();" class="btn-print">Imprimir</a>

</body>
</html>
