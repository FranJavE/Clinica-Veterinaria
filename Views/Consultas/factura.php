<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<!-- <td class="logo_factura">
				<div>
					<img src="img/log.png">
				</div>
			</td> -->
			<td class="info_empresa">
				<div>
					<span class="h2">EL Gato</span>
					<p>Barrio Altagracia, De la racachaca 1/2 arriba 505 Managua, Nicaeagua</p>
					<p>Teléfono: +(502) 2222-3333</p>
					<p>Horario: Siempre abierto</p>
					<p>Correo: Veterinariaamigos@yahoo.com</p>
					<p>Telefono: 22681571</p>
				</div>
			</td>
	<!-- 		<td class="info_factura">
				<div class="round">
					<span class="h3">Medico</span>
					<p>Identificacion: <strong>000001</strong></p>
					<p>Nombre: Franklin</p>
					<p>Apellido: Aguilar</p>
					<p>Correo: Veterinariaamigos@yahoo.com</p>
					<p>Telefono: 22681571</p>
				</div>
			</td> -->
		</tr>
	</table>

	<table id="factura_cliente">
		<tr>
			<td class="info_empresa">
				<div class="round">
			<span class="h2">Datos Mascotas: </span>
			<table class="label_tbl">
              <tbody>
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

				</div>
			</td>
			<td class="info_empresa">
				<div class="round">
			<span class="h2">Datos Cliente: </span>
			<table class="label_tbl">
              <tbody>
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
                  <td>Direccion:</td>
                  <td><?= $configuracion['Direccion']; ?></td>
                </tr>
                <tr>
                  <td>Email (Usuario):</td>
                  <td><?= $configuracion['email_user']; ?></td>
                </tr>
  
			 </tbody>
            </table>

				</div>
			</td>
		</tr>
	</table>

		<table id="factura_cliente">
		<tr>
			<td class="info_empresa">
				<div class="round">
					<span class="h2">Detalles de consulta:</span>
					<table class="label_tbl">
		   	<tbody>
		  		<tr>
		  			<td>Tratamiento:</td>
		  			<td><?= $configuracion['NombreTratamiento']; ?></td>
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

</div>

</body>
</html>