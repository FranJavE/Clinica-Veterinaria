//Bloquea todas las teclas menos numeros
function controlTag(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	else if (tecla==0||tecla==9) return true;
	patron =/[0-9\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}
//Bloquea todas las teclas menos numeros y puntos
function controlhora(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	else if (tecla==0||tecla==9||tecla==":"||tecla=="A"||tecla=="P"||tecla=="M") return true;
	patron =/[0-9:AMP\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}
function controlFlotantes(e)
{
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==8) return true;
	else if (tecla==0||tecla==9||tecla==".") return true;
	patron =/[0-9.0-9\s]/;
	n = String.fromCharCode(tecla);
	return patron.test(n);
}


//Validar Nombres y apellidos
function testText(txtString)
{
	var stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚú\s]+$/);
	if (stringText.test(txtString))
	{
		return true;
	}else{
		return false;
	}
}

//Validar solo entero
function testEntero(intCant)
{
	var intCantidad = new RegExp(/^([0-9])*$/);
	if(intCantidad.test(intCant)){
		return true;
	}else{
		return false;
	}
}
//Validar flotante
function testFloat(flotCant)
{
	var flotCantidad = new RegExp(/^([0-9.0-9])*$/);
	if(flotCantidad.test(flotCant)){
		return true;
	}else{
		return false;
	}
}
//Validar formato hora
function testHora(txtString)
{
	var stringHora= new RegExp(/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/);
	if(stringHora.test(txtString)){
		return true;
	}else{
		return false;
	}
}

function fntEmailValidate(email)
{
	var stringEmail = new RegExp(/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/);
	if(stringEmail.test(email) == false){
		return false;
	}else{
		return true;
	}
}
function fntValidHora(){
	let validHora = document.querySelectorAll(".validHora");
	validHora.forEach(function(validHora){
		validHora.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testHora(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
function fntValidText(){
	let validText = document.querySelectorAll(".validText");
	validText.forEach(function(validText){
		validText.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testText(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
function fntValidNumber(){
	let validNumber = document.querySelectorAll(".validNumber");
	validNumber.forEach(function(validNumber){
		validNumber.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testEntero(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
function fntValidNumberFloat(){
	let validNumberFloat = document.querySelectorAll(".validNumberFloat");
	validNumberFloat.forEach(function(validNumberFloat){
		validNumberFloat.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!testFloat(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
function fntValidEmail(){
	let validEmail = document.querySelectorAll(".validEmail");
	validEmail.forEach(function(validEmail){
		validEmail.addEventListener('keyup', function(){
			let inputValue = this.value;
			if(!fntEmailValidate(inputValue)){
				this.classList.add('is-invalid');
			}else{
				this.classList.remove('is-invalid');
			}
		});
	});
}
window.addEventListener('load', function(){
	fntValidText();
	fntValidNumber();
	fntValidEmail();
	fntValidHora();
	fntValidNumberFloat();
}, false);
