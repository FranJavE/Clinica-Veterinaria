$('.login-content [data-toggle="flip"]').click(function() {
	$('.login-box').toggleClass('flipped');
	return false;
});

let divLoading = document.querySelector("#divLoading");
document.addEventListener('DOMContentLoaded', function(){
	if(document.querySelector("#formLogin"))
	{
		//La letiable indica que la letiable solo será utlilizada
		//dentro de la funcion
		let formLogin = document.querySelector("#formLogin");
		formLogin.onsubmit = function(e) {
			e.preventDefault();
			let strEmail = document.querySelector('#txtEmail').value;
			let strPassword = document.querySelector('#txtPassword').value;

			if( strEmail == "" || strPassword == "")
			{
				swal("Por favor", "Escribe Usuario y Contraseña", "error");
				return false;
			}else{
				divLoading.style.display= "flex";
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		        let ajaxUrl = base_url+'/Login/loginUser'; 
		        let formData = new FormData(formLogin);
		        request.open("POST",ajaxUrl,true);
		        request.send(formData);

		       request.onreadystatechange = function(){
			        if(request.readyState != 4) return;
			        if(request.status == 200){
			        	let objData = JSON.parse(request.responseText);
			        	if (objData.status){
			        		window.location = base_url+'/dashboard';
			        	}else{
			        		swal("ATENCION", objData.msg, "error");
			        		document.querySelector('#txtPassword').value = "";
			        	}
			        }else{
			       		swal("ATENCION","Error en el proceso","error");
			        }
			        divLoading.style.display= "none";
			        return false;
			        //console.log(request);
			    }
			}
		}
	}
	//Resert Password
	if(document.querySelector("#formRecetPass")){		
		let formRecetPass = document.querySelector("#formRecetPass");
		formRecetPass.onsubmit = function(e) {
			e.preventDefault();

			let strEmail = document.querySelector('#txtEmailReset').value;
			if(strEmail == "")
			{
				swal("Por favor", "Escribe tu correo electrónico.", "error");
				return false;
			}else{
				divLoading.style.display = "flex";
				let request = (window.XMLHttpRequest) ? 
								new XMLHttpRequest() : 
								new ActiveXObject('Microsoft.XMLHTTP');
								
				let ajaxUrl = base_url+'/login/resetPass'; 
				let formData = new FormData(formRecetPass);
				request.open("POST",ajaxUrl,true);
				request.send(formData);
				request.onreadystatechange = function(){
					if(request.readyState != 4) return;

					if(request.status == 200){
						let objData = JSON.parse(request.responseText);
						if(objData.status)
						{
							swal({
								title: "",
								text: objData.msg,
								type: "success",
								confirmButtonText: "Aceptar",
								closeOnConfirm: false,
							}, function(isConfirm) {
								if (isConfirm) {
									window.location = base_url;
								}
							});
						}else{
							swal("Atención", objData.msg, "error");
						}
					}else{
						swal("Atención","Error en el proceso", "error");
					}
					divLoading.style.display = "none";
					return false;
				}	
			}
		}
	}

	if(document.querySelector('#formCambiarPass')){
		let formCambiarPass = document.querySelector("#formCambiarPass");
		formCambiarPass.onsubmit = function(e) {
			e.preventDefault();

			let strPassword = document.querySelector('#txtPassword').value;
			let strPasswordConfirm = document.querySelector('#txtPasswordConfirm').value;
			let idUsuario = document.querySelector('#idUsuario').value;
			
			if(strPassword == "" || strPasswordConfirm == "" )
			{
				swal("Por favor", "Escribe la nueva contraseña.", "error");
				return false;
			}else{
				if(strPassword.length < 5)
				{
					swal("Atencion", "La contraseña debe ser mayor de 5 caracteres.", "info");
					return false;
				}
				if(strPassword != strPasswordConfirm){
					swal("Atencion", "Las contraseñas no son iguales.", "info");
					return false;
				}
			    divLoading.style.display= "flex";
				let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		        let ajaxUrl = base_url+'/Login/setPassword'; 
		        let formData = new FormData(formCambiarPass);
		        request.open("POST",ajaxUrl,true);
		        request.send(formData);
		        request.onreadystatechange = function(){
		            if(request.readyState != 4) return;
			        if(request.status == 200){
			        	let objData = JSON.parse(request.responseText);
			        	if (objData.status)
			        	{
			        		swal({
			        			title: "",
			        			text: objData.msg,
			        			type: "success",
			        			confirmButtonText: "Iniciar session",
			        			closeOnConfirm: false,

			        		}, function(isConfirm){
			        			if(isConfirm){
			        				window.location = base_url+'/login';
			        			}
			        		});
			        	}else{
			        		swal("Atencion", objData.msg, "error");
			        	}
			        }else{
			        	swal("Atencion", "Error en el proceso", "error");
			        }
			        divLoading.style.display= "none";

		        }
			}
		}
	}
	}, false);