const form = document.querySelector('#GetcodeForm')
let code = document.querySelector('#code')
form.addEventListener('submit', (event) =>{
    event.preventDefault();
    // verificar se o código está vazio
    if(code.value === "" ){
        alert("Por favor insira o seu código de abertura de conta")
        return;
    }
    // se todos os campos estiverem correctamente preenchidos, envie o form
    form.submit();
})
function inputing(){
    if (code.value.length <= 4) {
        if (code.value.length == 3) {
            code.value += "-";
        }
    }
    code.value = code.value.replace(/[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZÁÀÂÃÉÊÈÍÌÎÓÒÔÕÚÙÛáàâãéèêíìîóòôõúùû" "]/gi,"")
}