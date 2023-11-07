<!-- Modal -->
<div class="modal fade" id="modalFormConsulta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Nueva consulta</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formConsulta" name="formConsulta" class= "form-horizontal">
				<input type="hidden" id="idConsulta" name="idConsulta" value="">
				<p class="text-primary">Todos loss campos son obligatorios</p>
				<div class="form-row">
				  	<div class="form-group col-md-6">
                    <label for="listDuenoId">Dueño <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId" onchange="fntMascotas();" required >
                    </select>
                </div>
                 <div class="form-group col-md-6">
                    <label for="listPaciente">Paciente <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente" required >
                    </select>
                </div>
                </div>
              	<div class="form-row">
				  	<div class="form-group col-md-6">
                    <label for="listMedico">Medico <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listMedicoId" name="listMedicoId" required >
                    </select>
                </div>
                </div>

				  <div class="form-group">
                      <label class="control-label">Descripción Consulta <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción Consulta" required=""></textarea>
            </div>
				<div class="form-row">
				   <div class="form-group col-md-6">
		              <label for="txtFecha">Fecha Consulta <span class="required">*</span></label>
		              <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Seleccionar fecha" required="">
	               </div>
                 <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtHora">Hora <span class="required">*</span></label>
				  <input type="text" class="form-control valid validHora" id="txtHora" name="txtHora" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
				</div>
                </div>
         		<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
						 <label for="txtPrecio">Precio <span class="required">*</span></label>
				 		 <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" required="">
					</div>
				</div>
                <br></br>
				<head>
			<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		</head>
		<body>


		<div id="detallesContainer">
		<!-- Aquí se agregarán los detalles dinámicos -->
		<button id="btnAgregarDetalle" class="btn btn-success" type="button">
		<i class="fa fa-fw fa-lg fa-plus-circle"></i>Agregar Detalle
		</button>
		</div>


         </body>
				<div class="tile-footer">
				  <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;

				  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>

				</div>
			  </form>
			
	  </div>
	</div>
  </div>
</div>




<!-- Modal -->
<div class="modal fade" id="modalViewConsulta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog ">
	<div class="modal-content">
	  <div class="modal-header header-primary">
		<h5 class="modal-title" id="titleModal">Datos Consulta</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  <table class="table table-bordered">
		  	<tbody>
		  		<tr>
		  			<td>Dueño:</td>
		  			<td id="celNombreDueno"></td>
		  		</tr>
		  		<tr>
		  			<td>Paciente:</td>
		  			<td id="celPaciente"></td>
		  		</tr>
		  		<tr>
		  			<td>Especie:</td>
		  			<td id="celEspecie"></td>
		  		</tr>
		  		<tr>
		  			<td>Raza:</td>
		  			<td id="celRaza"></td>
		  		</tr>
		  		<tr>
		  			<td>Descripcion:</td>
		  			<td id="celDescripcion"></td>
		  		</tr>
		  		<tr>
		  			<td>Fecha de Consulta:</td>
		  			<td id="celFecha"></td>
		  		</tr>
		  		<tr>
		  			<td>Hora:</td>
		  			<td id="celHora"></td>
		  		</tr>
		  	   <tr>
		  			<td>Precio:</td>
		  			<td id="celPrecio"></td>
		  		</tr>
		  	</tbody>
		  </table>
	  </div>
	  <div class="modal-footer">
	  	<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	  </div>
	</div>
  </div>
</div>