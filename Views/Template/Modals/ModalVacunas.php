 <!-- Modal -->
<div class="modal fade" id="modalFormVacuna" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Nueva vacuna</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formVacuna" name="formVacuna" class= "form-horizontal">
				<input type="hidden" id="idVacuna" name="idVacuna" value="">
				<p class="text-primary">Todos loss campos son obligatorios</p>
				<div class="form-row">
				  	<div class="form-group col-md-6">
                    	<label for="listDuenoId">Dueño<span class="required">*</span></label>
                    	<select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId" onchange="fntMascotas();" required >
                    	</select>
                	</div>
                 	<div class="form-group col-md-6">
                    	<label for="listPaciente">Paciente<span class="required">*</span></label>
                    	<select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente" required >
                    	</select>
                	</div>
                </div>
                <div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
						<label for="listVacunas">Vacuna<span class="required">*</span></label>
                    	<select class="form-control" data-live-search="true" id="listVacunas" name="listVacunas" required >
                    	</select>	
				  	</div>
				  	<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
						<label for="txtPrecio">Precio<span class="required">*</span></label>
						<input type="text" class="form-control" id="txtPrecio" name="txtPrecio" required="">
				  	</div>
				</div>
				<div class="form-row">
				   <div class="form-group col-md-6">
		              <label for="txtFecha">Fecha<span class="required">*</span></label>
		              <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Seleccionar fecha" required="">
	               </div>
                 <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtHora">Hora<span class="required">*</span></label>
				  <input type="text" class="form-control valid validHora" id="txtHora" name="txtHora" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
				</div>
                </div>
				  <div class="form-group">
                <label class="control-label">Descripción Vacuna <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción Vacuna" required=""></textarea>
                </div>


 
         
                <br></br>
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
<div class="modal fade" id="modalViewVacuna" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog ">
	<div class="modal-content">
	  <div class="modal-header header-primary">
		<h5 class="modal-title" id="titleModal">Datos Vacunas</h5>
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
		  			<td>Tipo de Vacuna:</td>
		  			<td id="celVacuna"></td>
		  		</tr>
		  		<tr>
		  			<td>Descripcion:</td>
		  			<td id="celDescripcion"></td>
		  		</tr>
		  		<tr>
		  			<td>Precio:</td>
		  			<td id="celPrecio"></td>
		  		</tr>
		  		<tr>
		  			<td>Fecha de Vacuna:</td>
		  			<td id="celFecha"></td>
		  		</tr>
		  		<tr>
		  			<td>Hora:</td>
		  			<td id="celHora"></td>
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