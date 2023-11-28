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
		.nota{
			position: relative;
			top: 190px;
			font-size: 10pt;
}
		.label_gracias{
			position: relative;
			top: 220px;
			font-family: verdana;
			font-weight: bold;
			font-style: italic;
			text-align: center;
			margin-top: 20px;
		}

		.factura_consulta_detalle {
			position: relative;
			top :10px
		}

		.none {
        border: none;
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

	<table id="datos_mascotas">
    <tbody>
	<tr>
            <td>Datos Mascotas:</td>
        </tr>
        <tr>
            <td>Nombre Mascota:</td>
            <td><?= $configuracion['NombreMascota']; ?></td>
        </tr>
        <tr>
            <td>Raza:</td>
            <td><?= $configuracion['NombreRaza']; ?></td>
        </tr>
        <tr>
            <td>Especie:</td>
            <td><?= $configuracion['NombreEspecie']; ?></td>
        </tr>
        <tr>
            <td>Peso:</td>
            <td><?= $configuracion['Peso'].' '.'KG'; ?></td>
        </tr>
        <tr>
            <td>Altura:</td>
            <td><?= $configuracion['Altura'].' '.'Mts'; ?></td>
        </tr>  
    </tbody>
</table>

<table id="datos_cliente">
    <tbody>
	<tr>
            <td>Datos Cliente:</td>
        </tr>
        <tr>
            <td>Identificación:</td>
            <td><?= $configuracion['identificacion']; ?></td>
        </tr>
        <tr>
            <td>Nombre:</td>
            <td><?= $configuracion['Dueño']; ?></td>
        </tr>
        <tr>
            <td>Teléfono:</td>
            <td><?= $configuracion['Telefono']; ?></td>
        </tr>
        <tr>
            <td>Dirección:</td>
            <td><?= $configuracion['Direccion']; ?></td>
        </tr>
        <tr>
            <td>Email (Usuario):</td>
            <td><?= $configuracion['email_user']; ?></td>
        </tr>
    </tbody>
</table>


<table id="factura_consulta_detalle">
    <tr>
        <td class="factura_consulta_detalle">
            <div class="factura_consulta_detalle">
                <table class="factura_consulta_detalle">
                    <tbody>
					<tr>
            <td>Detalles de consulta:</td>
        </tr>
                        <tr>
                            <td>Descripcion:</td>
                            <td><?= $configuracion['Descripcion']; ?></td>
                        </tr>
                        <tr>
                            <td>Fecha de Consulta:</td>
                            <td><?= $configuracion['fechaconsulta']; ?></td>
                        </tr>
                        <tr>
                            <td>Hora:</td>
                            <td><?= $configuracion['hora']; ?></td>
                        </tr>
                        <tr>
                            <td>Precio:</td>
                            <td><?= $configuracion['Precio'].' '."$"; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </td>
    </tr>
</table>



	<div>
		<p class="nota">Si usted tiene preguntas sobre esta consulta, <br>pongase en contacto con nombre, teléfono y Email</p>
		<h4 class="label_gracias">¡Gracias por su visita!</h4>
	</div>
</body>
</html>
