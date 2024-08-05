const form = document.querySelector('#EsqSenhaForm')
let email = document.querySelector('#email')
form.addEventListener('submit', (event) =>{
    event.preventDefault();
    // verificar se o código está vazio
    if(email.value === "" || !validar_email(email.value)){
        alert("Por favor insira o seu email")
        return;
    }
    // se todos os campos estiverem correctamente preenchidos, envie o form
    form.submit();
})

// email válido
function validar_email(email){
    // criar uma regex para validar o email
    const validar = new RegExp(
        //usuario@dominio.com
        /^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,}$/
    );

    if(validar.test(email)){
        return true;
    }
    else{
        return false;
    }
}