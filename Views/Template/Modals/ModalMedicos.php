<!-- Modal -->
<div class="modal fade" id="modalFormMedicos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Nuevo Medico</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formMedico" name="formMedico" class= "form-horizontal">
				<input type="hidden" id="idMedico" name="idMedico" value="">
				<p class="text-primary">Todos los campos son obligatorios</p>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtIdentificacion">Identificacion <span class="required">*</span></label>
				  <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" required="">
				</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtNombre">Nombres <span class="required">*</span></label>
				  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
				</div>
				<div class="form-group col-md-6">
				  <label for="txtApellido">Apellidos <span class="required">*</span></label>
				  <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" required="">
				</div>
				</div>

				<div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtTelefono">Teléfono <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtEmail">Email <span class="required">*</span></label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" required="">
                </div>
              </div>
				<div class="form-row">
                 <div class="form-group col-md-6">
                    <label for="listStatus">Status <span class="required">*</span></label>
                    <select class="form-control selectpicker" id="listStatus" name="listStatus" required >
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>
                </div>

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
<div class="modal fade" id="modalViewMedicos" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog ">
	<div class="modal-content">
	  <div class="modal-header header-primary">
		<h5 class="modal-title" id="titleModal">Datos Medico</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  <table class="table table-bordered">
		  	<tbody>
		  		<tr>
		  			<td>Identificacion:</td>
		  			<td id="celIdentificacion"></td>
		  		</tr>
		  		<tr>
		  			<td>Nombre:</td>
		  			<td id="celNombre"></td>
		  		</tr>
		  		<tr>
		  			<td>Apellido:</td>
		  			<td id="celApellido"></td>
		  		</tr>
		  		<tr>
		  			<td>Telefono:</td>
		  			<td id="celTelefono"></td>
		  		</tr>
		  		<tr>
		  			<td>Email (Usuario):</td>
		  			<td id="celEmail"></td>
		  		</tr>
		  		<tr>
		  			<td>Estado:</td>
		  			<td id="celEstado"></td>
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