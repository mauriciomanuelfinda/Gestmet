let form1 = document.querySelector('#formPesqMembros')
let Pesq = document.querySelector('#pesq')

form1.addEventListener("submit", (event) =>{
    event.preventDefault();

    //verificar se o nome está vázio
    if(Pesq.value === ""){
        alert("Por favor preencha o campo")
        return;
    }
    // se todos os campos estiverem correctamente preenchidos, envie o form
    form1.submit();
});

/*===========================================================================================*/

