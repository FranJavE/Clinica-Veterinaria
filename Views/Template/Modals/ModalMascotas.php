<!-- Modal -->
<div class="modal fade" id="modalFormMascotas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Nueva mascota</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formMascotas" name="formMascotas" class= "form-horizontal">
				<input type="hidden" id="idMascota" name="idMascota" value="">
				<p class="text-primary">Todos loss campos son obligatorios</p>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtNombre">Nombre Mascota  <span class="required">*</span></label>
				  <input type="text" class="form-control" id="txtNombre" name="txtNombre" required="">
				</div>
				</div>
				  <div class="form-row">
				  	<div class="form-group col-md-6">
                    <label for="listEspecieId">Especie  <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listEspecieId" name="listEspecieId" onchange="fntRaza();" required >
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="listRazaid">Raza  <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listRazaid" name="listRazaid" required >
                    </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtPeso">Peso (Kg)  <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumberFloat" id="txtPeso" name="txtPeso" required="" onkeypress="return controlFlotantes(event);">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtAltura">Altura (Metros)  <span class="required">*</span></label>
                  <input type="text" class="form-control valid validNumberFloat" id="txtAltura" name="txtAltura" required="" onkeypress="return controlFlotantes(event);">
                </div>
              </div>
				<div class="form-row">
				<div class="form-group col-md-6">
                    <label for="listDuenoId">Dueño  <span class="required">*</span></label>
                    <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId" required >
                    </select>
                </div>
                 <div class="form-group col-md-6">
                    <label for="listStatus">Status  <span class="required">*</span></label>
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
<div class="modal fade" id="modalViewMascotas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog ">
	<div class="modal-content">
	  <div class="modal-header header-primary">
		<h5 class="modal-title" id="titleModal">Datos Mascota</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  <table class="table table-bordered">
		  	<tbody>
		  		<tr>
		  			<td>Nombre:</td>
		  			<td id="celNombre"></td>
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
		  			<td>Peso:</td>
		  			<td id="celPeso"></td>
		  		</tr>
		  		<tr>
		  			<td>Altura:</td>
		  			<td id="celAltura"></td>
		  		</tr>
		  		<tr>
		  			<td>Dueño:</td>
		  			<td id="celDueno"></td>
		  		</tr>
		  		<tr>
		  			<td>Estado:</td>
		  			<td id="celEstado"></td>
		  		</tr>
		  		<tr>
		  			<td>Fecha Registro:</td>
		  			<td id="celFechaRegistro"></td>
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

<!-- Modal Predecir-->
<!-- Modal -->
<div class="modal fade" id="modalFormPrediccion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerRegister">
		<h5 class="modal-title" id="titleModal">Prediccion</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Mascota</th>
                    <th>Enfermedades Probables</th>
                    <th>Porcentaje</th>
                    <th>Gravedad</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Ranger</td>
                    <td>Cancer en los riñones</td>
                    <td>60%</td>
                    <td>Alta</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

			
	  </div>
	</div>
  </div>
</div>
