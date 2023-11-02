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
            background-color: #3498db ;
            font-size: 18px;
        }

        /* Centrar el encabezado horizontalmente y verticalmente */
        .header {
            text-align: center;
            vertical-align: middle;
        }
        header {
            text-align: center;
        }
        header img {
            width: 100px;
            float: left;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h2>CLINICA VETERINARIA EL GATO</h2>
            <br>
            <p>
                Teléfono: +505 5824 5488
                <br>
                Dirección: Barrio Central, contiguo a la entrada municipal, El Rama.
            </p>
            <br>
            <br>
            <br>
            <img src="../../Assets/Images/logoVeterina.png" alt="Logotipo de la clínica veterinaria" >
        </div>
    </header>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <table>
        <tr>
            <th colspan="7" class="header">INFORME DE VACUNAS</th>
        </tr>
        <tr>
            <th>Cliente</th>
            <th>Mascota</th>
            <th>Vacuna</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Precio</th>
        </tr>
        <?php
            if($result > 0) {
                while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <td><?= $row['Dueño']; ?></td>
            <td><?= $row['NombreMascota']; ?></td>
            <td><?= $row['NombreVacuna']; ?></td>
            <td><?= $row['Descripcion']; ?></td>
            <td><?= $row['fechaVacunacion']; ?></td>
            <td><?= $row['Hora']; ?></td>
            <td><?= $row['Precio']; ?></td>
        </tr>
        <?php
                }
            }
        ?>
    </table>   
</body>
</html>
