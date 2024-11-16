<!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <title>Top 10 Platillos Menos Vendidos</title>
            <style>
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                th { background-color: #f2f2f2; }
            </style>
        </head>
        <body>
            <h2>Top 10 Platillos Menos Vendidos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Nombre del Platillo</th>
                        <th>Precio</th>
                        <th>Total Vendido</th>
                        <th>Total Generado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($platillos as $platillo): ?>
                        <tr>
                            <td><?= htmlspecialchars($platillo['NombrePlatillo']) ?></td>
                            <td>$<?= number_format($platillo['PrecioPlatillo'], 2) ?></td>
                            <td><?= $platillo['Ventas'] ?></td>
                            <td>$<?= number_format($platillo['TotalGenerado'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </body>
        </html>
