<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas del Platillo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            position: relative; 
        }
        .container {
            max-width: 1000px;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .total {
            text-align: right;
            font-weight: bold;
            margin-top: 20px;
        }

        .top-right-image {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 150px; 
        }

        .bottom-right-date {
            position: absolute;
            bottom: 10px;
            right: 10px;
            font-size: 12px;
            color: #333;
        }
    </style>
</head>
<body>

<img src="../../images/almiranteNOBG.png" alt="Almirante" class="top-right-image">

<div class="container">
    <?php if (!empty($detalles)): ?>
        <h2>Ventas del Platillo: <?= $detalles[0]['nombre_producto'] ?></h2>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Id Venta</th>
                <th>Método de Pago</th>
                <th>Platillo</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí mostramos los detalles de cada venta -->
            <?php foreach ($detalles as $detalle): ?>
            <tr>
                <td><?= $venta['IdVenta'] ?></td>
                <td><?= $venta['TipoPago'] ?></td>
                <td><?= $detalle['nombre_producto'] ?></td>
                <td><?= $detalle['Cantidad'] ?></td>
                <td>$<?= $detalle['PrecioUnitario'] ?></td>
                <td>$<?= $detalle['Subtotal'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="total">
        <p>Total de Ventas: $<?= array_sum(array_column($detalles, 'Subtotal')) ?></p>
    </div>
</div>

<!-- Fecha y hora en la parte inferior derecha -->
<div class="bottom-right-date">
    <?php echo date("d/m/Y H:i:s"); ?>
</div>

</body>
</html>

