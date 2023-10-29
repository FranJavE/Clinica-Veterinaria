<!-- Modal -->
<div class="modal fade" id="modalFormGuarderia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Nueva guarderia</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formGuarderia" name="formGuarderia" class= "form-horizontal">
				<input type="hidden" id="idGuarderia" name="idGuarderia" value="">
				<p class="text-primary">Todos loss campos son obligatorios</p>
				<div class="form-row">
					   <div class="col-md-3">
                    <div class="form-group">
                     <label for="listDuenoId">Dueño <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId" onchange="fntMascotas();" required >
                    </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <label for="listPaciente">Paciente <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente" required >
                    </select>
                    </div>
                    
                </div>
                 	<div class="col-md-3">
		              <label for="txtFechallegada">Fecha llegada <span class="required">*</span></label>
		              <input class="form-control" id="txtFechallegada" name="txtFechallegada" type="date" placeholder="Seleccionar fecha" required="">
	         	    </div>
	         		<div class="col-md-3"><!-- ocupara 6 columnas -->
						<label for="txtHorallegada">Hora Llegada <span class="required">*</span></label>
						<input type="text" class="form-control valid validHora" id="txtHorallegada" name="txtHorallegada" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
					</div>
                </div>
          <div class="form-row">
				  <div class="col-md-6"><!-- ocupara 6 columnas -->
					 	<label for="listJaula">Jaula <span class="required">*</span></label>
	                    <select class="form-control" data-live-search="true" id="listJaula" name="listJaula" required >
	                    </select>
					</div>
				   <div class="col-md-3">
		              <label for="txtFechaSalida">Fecha Salida <span class="required">*</span></label>
		              <input class="form-control" id="txtFechaSalida" name="txtFechaSalida" type="date" placeholder="Seleccionar fecha" required="">
	         	   </div>
	         		<div class="col-md-3"><!-- ocupara 6 columnas -->
					  <label for="txtHoraSalida">Hora Salida <span class="required">*</span></label>
					  <input type="text" class="form-control valid validHora" id="txtHoraSalida" name="txtHoraSalida" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
					</div>
					</div>
					<div class="form-row">
					 <div class="col-md-6">
                      <label class="control-label">Descripción Guarderia <span class="required">*</span></label>
                      <textarea class="form-control" id="txtDescripcion" name="txtDescripcion" rows="2" placeholder="Descripción guarderia" required=""></textarea>
             </div>
             	<div class="col-md-3"><!-- ocupara 6 columnas -->
						  <label for="txtPrecio">Precio <span class="required">*</span></label>
						  <input type="text" class="form-control" id="txtPrecio" name="txtPrecio" required="">
					</div>
					<div class="col-md-3">
	                    <label for="listStatus">Status <span class="required">*</span></label>
	                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
	                        <option value="1">Activo</option>
	                        <option value="2">Fuera</option>
	                        <option value="3">Retrasado</option>
	                    </select>
                	</div>
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
<div class="modal fade" id="modalViewGuarderia" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog  modal-xl">
	<div class="modal-content">
	  <div class="modal-header header-primary">
		<h5 class="modal-title" id="titleModal">Datos Guarderias</h5>
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
		  			<td>Jaula:</td>
		  			<td id="celJaula"></td>
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
		  			<td>Fecha de Llegada:</td>
		  			<td id="celFechaLlegada"></td>
		  		</tr>
		  		<tr>
		  			<td>Hora de Llegada:</td>
		  			<td id="celHoraLlegada"></td>
		  		</tr>
		  		<tr>
		  			<td>Fecha de Salida:</td>
		  			<td id="celFechaSalida"></td>
		  		</tr>
		  		<tr>
		  			<td>Hora de Salida:</td>
		  			<td id="celHoraSalida"></td>
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