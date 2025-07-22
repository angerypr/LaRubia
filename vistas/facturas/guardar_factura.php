<?php
require_once '../../config.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_cliente = $_POST['codigo_cliente'];
    $nombre_cliente = $_POST['nombre_cliente'];
    $comentario = $_POST['comentario'] ?? '';
    $productos = $_POST['producto_id']; 
    $cantidades = $_POST['cantidad'];  

    try {
        $conn->beginTransaction();

        $stmt = $conn->query("SELECT numero_recibo FROM facturas ORDER BY id DESC LIMIT 1");
        $ultimo = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($ultimo) {
            $num = (int) filter_var($ultimo['numero_recibo'], FILTER_SANITIZE_NUMBER_INT) + 1;
        } else {
            $num = 1;
        }
        $numero_recibo = 'REC-' . str_pad($num, 3, '0', STR_PAD_LEFT);

        $total = 0;
        $precios = [];
        for ($i = 0; $i < count($productos); $i++) {
            $producto_id = $productos[$i];
            $cantidad = $cantidades[$i];

            $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
            $stmt->execute([$producto_id]);
            $precio = $stmt->fetchColumn();

            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            $precios[] = [
                'producto_id' => $producto_id,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $subtotal
            ];
        }

        $stmt = $conn->prepare("INSERT INTO facturas (numero_recibo, codigo_cliente, nombre_cliente, comentario, total) 
                                VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$numero_recibo, $codigo_cliente, $nombre_cliente, $comentario, $total]);
        $factura_id = $conn->lastInsertId();

        foreach ($precios as $item) {
            $stmt = $conn->prepare("INSERT INTO detalle_factura (factura_id, producto_id, cantidad, precio_unitario, subtotal)
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $factura_id,
                $item['producto_id'],
                $item['cantidad'],
                $item['precio'],
                $item['subtotal']
            ]);
        }

        $conn->commit();

        header("Location: ver_recibo.php?id=$factura_id");
        exit;

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Error al guardar la factura: " . $e->getMessage();
    }
} else {
    header("Location: formulario_factura.php");
    exit;
}
