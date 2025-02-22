const form = document.getElementById('register-form');

/* Los mensajes de error */
const errorMessage = document.getElementsByClassName('empty-input-message');
/* Inputs del usuario */
const input = document.getElementsByClassName('no-empty-input');

/* Inputs necesarias para enviar correo */
const sendMail = document.getElementById('sendMailSection');
const mailRequirements = document.getElementsByClassName('required-for-mail');
const errorMailMessage = document.getElementsByClassName('required-for-mail-message');

/*  Expresiones */
const expressions = {
	user: /^[a-zA-Z0-9\_\-]{3,20}$/, // Letras, numeros, guion y guion_bajo
	name: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	mail: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, //Formato correo
	phone: /^[\+]?\d{7,14}$/, // 7 a 14 numeros.
  device: /[^;]{1,40}$/ // Formato nombre del dispositivo
}

/* Funcion para remover clases */
function removeClass(component, message, removeItem){
  component.classList.remove(removeItem);
  message.classList.remove(removeItem);
}

/* Funcion para agregar clases */
function addClass(component, message, removeItem){
  component.classList.add(removeItem);
  message.classList.add(removeItem);
}

/* Funcion revisar que las entradas tengan datos correctos */ 
function validateInputs(component, message){
  switch(component.name){
    case 'user':
      if(!expressions.user.test(component.value)){
        message.setAttribute('data-error', 'Nombre de usuario invalido');
        addClass(component, message, 'error');
      }
      else
        removeClass(component, message, 'error');
    break;

    case 'pass':
      if(!expressions.password.test(component.value)){
        message.setAttribute('data-error', 'Contraseña invalida');
        addClass(component, message, 'error')
      }
      else
        removeClass(component, message, 'error');
    break;
    
    case 'name':
      if(!expressions.name.test(component.value)){
        message.setAttribute('data-error', 'No caracteres numericos, ni especiales');
        addClass(component, message, 'error');
      }
      else
        removeClass(component, message, 'error');
    break;

    case 'company':
      if(component.value.includes(";")){
        message.setAttribute('data-error', 'Compañia invalda');
        addClass(component, message, 'error');
      }
      else{
        removeClass(component,message, 'error');
      }
    break;

    case 'device':
        if(component.value.includes(";")){
          message.setAttribute('data-error', 'Dispositivo invalido');
          addClass(component, message, 'error');
        }
        else
          removeClass(component, message, 'error');
    break;

    case 'city':
      if(!expressions.name.test(component.value)){
        message.setAttribute('data-error', 'No caracteres numericos, ni especiales');
        addClass(component, message, 'error');
      }
      else
        removeClass(component, message, 'error');
    break;
    
    case 'email':
      if(!expressions.mail.test(component.value)){
        message.setAttribute('data-error', 'Correo invalido');
        addClass(component, message, 'error');
      }
      else
        removeClass(component, message, 'error');
    break;

    case 'phone':
      if(!expressions.phone.test(component.value)){
        message.setAttribute('data-error', 'Numero telefonico invalido');
        addClass(component, message, 'error');
      }
      else
        removeClass(component, message, 'error');
    break;

    case 'admitted':
      removeClass(component, message, 'error');
    break;
  }
}

/* Al ingresar datos se eliminan los mensajes de error */
for(let i = 0; i < input.length; i++)
{
  input[i].addEventListener('input', ()=>{
    if (input[i].value != '' && input[i].value != null){
      validateInputs(input[i],errorMessage[i]);
    }
    else{
      removeClass(input[i], errorMessage[i], 'error');
    }
  })
}

/* Al ingresar datos se eliminan los mensajes de error */
for(let i = 0; i < mailRequirements.length; i++)
{
  mailRequirements[i].addEventListener('input', ()=>{
    if(mailRequirements[i].value != '' && mailRequirements[i].value != null){
      validateInputs(mailRequirements[i], errorMailMessage[i]);
    }
    else{
      removeClass(mailRequirements[i], errorMailMessage[i], 'error');
    }
  })
}

/* EventListener para verificar que los campso de correo esten correctos */
if(sendMail){
  sendMail.addEventListener('click', (e)=>{
    let errorCount = 0;
    
    for(var i = 0; i < mailRequirements.length; i++)
    {
      if(mailRequirements[i].value  === '' || mailRequirements[i].value == null || (mailRequirements[i].type == "checkbox" && mailRequirements[i].checked == false)){
        errorMailMessage[i].setAttribute('data-error', 'Campo requerido para enviar correo')
        addClass(mailRequirements[i], errorMailMessage[i], 'error')
        
        errorCount++;
      }
    }
    
    if(errorCount > 0)
      sendMail.checked = null;
  });
}