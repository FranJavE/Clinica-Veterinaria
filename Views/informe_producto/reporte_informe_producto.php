<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Consultas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-size: 18px;
        }

        /* Centrar el encabezado horizontalmente y verticalmente */
        .header {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="6" class="header">INFORME DE PRODUCTOS</th>
        </tr>
        <tr>
            <th>Nombre Producto</th>
            <th>Código</th>
            <th>Categoria</th>
            <th>Stock</th>
            <th>Precio</th>
            <th>Proveedor</th>
        </tr>
        <?php
            if($result > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
        ?>
                    <tr>
                        <td><?= $row['Nombre_producto']; ?></td>
                        <td><?= $row['Codigo']; ?></td>
                        <td><?= $row['categoria']; ?></td>
                        <td><?= $row['stock']; ?></td>
                        <td><?= $row['Precio']; ?></td>
                        <td><?= $row['Nombre_proveedor']; ?></td>
                    </tr>   
        <?php
                }
            }
        ?>
    </table>   
</body>
</html>
