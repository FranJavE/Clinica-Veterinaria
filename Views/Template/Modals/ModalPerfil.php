<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header headerUpdate">
		<h5 class="modal-title" id="titleModal"> Perfil</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	  <div class="modal-body">
		  
		 <form id="formPerfil" name="formPerfil" class= "form-horizontal">
				<p class="text-primary">Los campos con asterisco(<span class="required">*</span>) son obligatorios</p>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtIdentificacion" span?>Identificacion</label>
				  <input type="text" class="form-control" id="txtIdentificacion" name="txtIdentificacion" value="<?= $_SESSION['userData']['identificacion']; ?>" required="">
				</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtNombre">Nombres</label>
				  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['Nombre']; ?>"required="">
				</div>
				<div class="form-group col-md-6">
				  <label for="txtApellido">Apellidos</label>
				  <input type="text" class="form-control valid validText" id="txtApellido" name="txtApellido" value="<?= $_SESSION['userData']['Apellido']; ?>" required="">
				</div>
				</div>

				<div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtTelefono">Teléfono</label>
                  <input type="text" class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['Telefono']; ?>" required="" onkeypress="return controlTag(event);">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtEmail">Email</label>
                  <input type="email" class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email_user']; ?>" required="" readonly disabled>
                </div>
              </div>

				<div class="form-row">
					<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtPassword">Password</label>
				  <input type="Password" class="form-control" id="txtPassword" name="txtPassword" >
				</div>
				<div class="form-group col-md-6"><!-- ocupara 6 columnas -->
				  <label for="txtPasswordConfirm">Confirmar Password</label>
				  <input type="Password" class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" >
				</div>
				</div>

				<div class="tile-footer">
				  <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;

				  <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>

				</div>
			  </form>
			
	  </div>
	</div>
  </div>
</div>


