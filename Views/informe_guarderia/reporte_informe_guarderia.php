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
            <th colspan="9" class="header">INFORME DE GUARDERIA</th>
        </tr>
        <tr>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Jaula</th>
            <th>Descripción</th>
            <th>Fecha Llegada</th>
            <th>Hora Llegada</th>
            <th>Fecha Salida</th>
            <th>Hora Salida</th>
            <th>Precio</th>
        </tr>
        <?php
            if($result > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?= $row['Dueño']; ?></td>
            <td><?= $row['NombreMascota']; ?></td>
            <td><?= $row['Numero_Jaula']; ?></td>
            <td><?= $row['Descripcion']; ?></td>
            <td><?= $row['fechainicio']; ?></td>
            <td><?= $row['Hora_lnicio']; ?></td>
            <td><?= $row['fechafin']; ?></td>
            <td><?= $row['Hora_salida']; ?></td>
            <td><?= $row['Precio']; ?></td>
        </tr>
        <?php
                }
            }
        ?>
    </table>   
</body>
</html>
