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

        .header {
            text-align: center;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            background-color: white;
        }
    </style>
</head>
<body>
    <div>
    <table>
        <tr>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Hora</th>
        </tr>
        <?php
			if($result > 0) {
				while ($row = mysqli_fetch_assoc($query)) {
		?>
        <tr>
			<td><?= $row['Dueño']; ?></td>
            <td><?= $row['NombreMascota']; ?></td>
			<td><?= $row['Descripcion']; ?></td>
			<td><?= $row['fechaconsulta']; ?></td>
			<td><?= $row['hora']; ?></td>
        </tr>
        <?php
                }
            }
        ?>

        <!-- Puedes agregar más filas según sea necesario -->
    </table>   
    </div>

</body>
</html>
