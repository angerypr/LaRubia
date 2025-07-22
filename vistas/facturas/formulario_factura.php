<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

require_once '../../config.php';

$stmt = $conn->query("SELECT id, nombre, precio FROM productos");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Factura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">Crear Nueva Factura</h2>

    <form action="guardar_factura.php" method="POST" id="facturaForm">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="codigo_cliente" class="form-label">Código Cliente</label>
                <input type="text" class="form-control" id="codigo_cliente" name="codigo_cliente" required>
            </div>
            <div class="col-md-6">
                <label for="nombre_cliente" class="form-label">Nombre Cliente</label>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" readonly>
            </div>
        </div>

        <div class="mb-3">
            <label for="comentario" class="form-label">Comentario (opcional)</label>
            <textarea class="form-control" id="comentario" name="comentario"></textarea>
        </div>

        <hr>
        <h5>Productos</h5>
        <table class="table table-bordered" id="productosTable">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="detalle">
                <tr>
                    <td>
                        <select name="producto_id[]" class="form-select producto-select" required>
                            <option value="">Seleccionar</option>
                            <?php foreach ($productos as $prod): ?>
                                <option value="<?= $prod['id'] ?>" data-precio="<?= $prod['precio'] ?>">
                                    <?= $prod['nombre'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="cantidad[]" class="form-control cantidad" min="1" required></td>
                    <td><input type="text" class="form-control precio" readonly></td>
                    <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminar">X</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-secondary mb-3" id="agregarFila">Agregar Otro Producto</button>

        <div class="mb-3">
            <label>Total:</label>
            <input type="text" name="total" id="totalGeneral" class="form-control" readonly>
        </div>

        <button type="submit" class="btn btn-success">Guardar e Imprimir</button>
        <a href="../dashboard/dashboard.php" class="btn btn-secondary">Volver</a>
    </form>
</div>

<script>
$(document).ready(function () {
    $("#codigo_cliente").on("blur", function () {
        var codigo = $(this).val();
        $.post("buscar_cliente.php", {codigo: codigo}, function (data) {
            $("#nombre_cliente").val(data || "No encontrado");
        });
    });

    $("#agregarFila").on("click", function () {
        var fila = $("#detalle tr:first").clone();
        fila.find("input, select").val("");
        $("#detalle").append(fila);
    });

    $(document).on("click", ".eliminar", function () {
        if ($("#detalle tr").length > 1) {
            $(this).closest("tr").remove();
            calcularTotal();
        }
    });

    $(document).on("change", ".producto-select, .cantidad", function () {
        var row = $(this).closest("tr");
        var precio = parseFloat(row.find(".producto-select option:selected").data("precio") || 0);
        var cantidad = parseFloat(row.find(".cantidad").val() || 0);
        var subtotal = precio * cantidad;
        row.find(".precio").val(precio.toFixed(2));
        row.find(".subtotal").val(subtotal.toFixed(2));
        calcularTotal();
    });

    function calcularTotal() {
        var total = 0;
        $(".subtotal").each(function () {
            total += parseFloat($(this).val() || 0);
        });
        $("#totalGeneral").val(total.toFixed(2));
    }
});
</script>
</body>
</html>
