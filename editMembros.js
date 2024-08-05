function mostrarEditMembros(){
    let Edit_Membros = document.querySelector('#Edit-Membros')
    Edit_Membros.style.display = 'grid';
}
function removerEditMembros(){
    let Edit_Membros = document.querySelector('#Edit-Membros')
    Edit_Membros.style.display = 'none';
}

/*====================================================*/

let form = document.querySelector('#formEdit')
let nome = document.querySelector('#nome')
let nomePai = document.querySelector('#nomePai')
let nomeMae = document.querySelector('#nomeMae')
let data_nasc = document.querySelector('#data_nasc')
let Masculino = document.querySelector('#Masculino')
let Femenino = document.querySelector('#Femenino')
let naturalidade = document.querySelector('#naturalidade')
let provincia = document.querySelector('#provincia')
let estado_civil = document.querySelector('#estado_civil')
let BatSim = document.querySelector('#BatSim')
let BatNao = document.querySelector('#BatNao')
let data_bat = document.querySelector('#data_bat')
let categoria = document.querySelector('#categ')
let organizacao = document.querySelector('#Organizacao')
let classe = document.querySelector('#classe')
let cargo = document.querySelector('#cargo')
let Sim = document.querySelector('#Sim')
let Nao = document.querySelector('#Nao')
let grupoCoro = document.querySelector('#grupo_coral')
let hab_liter = document.querySelector('#hab_liter')
let area_form = document.querySelector('#area_form')
let area_act = document.querySelector('#area_act')
let res_act = document.querySelector('#res_act')
let bairro = document.querySelector('#bairro')
let contacto = document.querySelector('#contacto')

form.addEventListener("submit", (event) =>{
    event.preventDefault();

    //verificar se o nome está vázio
    if(nome.value === ""){
        alert("Por favor insira o nome do membro")
        return;
    }
     //verificar se o nome do pai está vázio
     if(nomePai.value === ""){
        alert("Por favor insira o nome do pai do membro")
        return;
    }
    // verificar se o nome da mãe está vazio
    if(nomeMae.value === ""){
        alert("Por favor insira o nome da mãe do membro")
        return;
    }
    // verificar se a data de nascimento está vazio
    if (data_nasc.value === "") {
        alert("Por favor informe a data de nascimento do membro");
        return;
    }
    // verificar se o género foi informado
    if(!Masculino.checked && !Femenino.checked){
        alert("Por favor informe o género do membro")
        return;
    }
    // verificar se a naturalidade está vazia
    if(naturalidade.value === ""){
        alert("Por favor insira a naturalidade do membro")
        return;
    }
    // verificar se a província está vazia
    if(provincia.value === ""){
        alert("Por favor insira a província do membro")
        return;
    }
    // verificar se o estado civil estado vazio
    if(estado_civil.value === ""){
        alert("Por favor informe o estado civil do membro")
        return;
    }
    // verificar se já informou o seu estado de membro
    if(!BatSim.checked && !BatNao.checked){
        alert("Por favor informe o se o membro é batizado")
        return;
    }
    else{
        if (BatSim.checked) {
            //Verificar se informou a categoria
            if (categoria.value === "") {
                alert("Por favor informe a sua categoria")
                return
            }
            //Verificar se informou a data do batismo
            if (data_bat.value === "") {
                alert("Por favor informe a data do seu batismo")
                return
            }
        }
    }
    // verificar se a classe está vazia
    if(classe.value === ""){
        alert("Por favor insira a classe do membro")
        return;
    }
    // verificar se pertence a alguma organização
    if(organizacao.value === ""){
        alert("Por favor informe a organização do membro")
        return;
    }
    // verificar se a cargo está vazia
    if(cargo.value === ""){
        alert("Por favor insira o cargo do membro")
        return;
    }
    // verificar se pertence a um grupo musical ou coral
    if(!Sim.checked && !Nao.checked){
        alert("Por favor informe se o membro pertence a um grupo")
        return;
    }
    else{
        if (Sim.checked) {
            //Verificar se o nome do grupo está vazia
            if (grupoCoro.value === "") {
                alert("Por favor informe o nome do grupo do membro")
                return
            }
        }
    }
    // verificar se habilatações literárias está vazia
    if(hab_liter.value === ""){
        alert("Por favor informe as habilitações literárias do membro")
        return;
    }
    // verificar se a área de formação está vazia
    if(area_form.value === ""){
        alert("Por favor insira a área de formação do membro")
        return;
    }
    // verificar se a área de actuação está vazia
    if(area_act.value === ""){
        alert("Por favor insira a área de actuação do membro")
        return;
    }
    // verificar se a residência actual está vazia
    if(res_act.value === ""){
        alert("Por favor insira a residência actual do membro")
        return;
    }
    // verificar se o bairro está vazia
    if(bairro.value === ""){
        alert("Por favor insira o bairro do membro")
        return;
    }
    // verificar se o contacto está vazia
    if(contacto.value === ""){
        alert("Por favor insira o contacto do membro")
        return;
    }
    // se todos os campos estiverem correctamente preenchidos, envie o form
    form.submit();
});

/*============================================================*/
let check1 = document.querySelector('#check1')
let check2 = document.querySelector('#check2')
let check3 = document.querySelector('#check3')
let all1 = document.querySelector('#all1')
let all2 = document.querySelector('#all2')
let all3 = document.querySelector('#all3')
let all4 = document.querySelector('#all4')
let flex = 'flex'
let grid = 'grid'
function Abrindo(){
    check1.checked = true;
}
function Onchecking () {
    let Coro = document.querySelector('#Coral-Musical')
    if (check1.checked) {
        all2.style.display = "none";
        all3.style.display = "none";
        all4.style.display = "none";
        Coro.style.display = 'none'
        if (document.body.offsetWidth <= 900) {
            all1.style.display = grid;
            all1.classList.remove('open2')
            all1.classList.add('open1')
        }
        if(document.body.offsetWidth > 900){
            all1.style.display = flex;
            all1.classList.remove('open1')
            all1.classList.add('open2')
        }
    }
    if (check2.checked){
        all1.style.display = "none";
        all3.style.display = "none";
        all4.style.display = "none";
        if (document.body.offsetWidth <= 900) {
            all2.style.display = grid;
            all2.classList.remove('open2')
            all2.classList.add('open1')
        }
        if(document.body.offsetWidth > 900){
            all2.style.display = flex;
            all1.classList.remove('open1')
            all1.classList.add('open2')
        }
        mostrarCoro()
    }
    if (check3.checked) {
        all1.style.display = "none";
        all2.style.display = "none";
        Coro.style.display = 'none'
        all4.style.display = "grid";
        if (document.body.offsetWidth <= 900) {
            all3.style.display = grid;
            all2.classList.remove('open2')
            all2.classList.add('open1')
        }
        if(document.body.offsetWidth > 900){
            all3.style.display = flex;
            all1.classList.remove('open1')
            all1.classList.add('open2')
        }
    }
}
function mostrarCoro(){
    let Sim = document.querySelector('#Sim')
    let Nao = document.querySelector('#Nao')
    let Coro = document.querySelector('#Coral-Musical')
    let Grupo = document.querySelector('#grupo_coral')
    if (Sim.checked) {
        Coro.style.display = grid;
    } else {
        Coro.style.display = 'none'
    }
    if (Nao.checked) {
        Grupo.value = ""
    }
}
function dataBatismo() {
    let BatSim = document.querySelector('#BatSim')
    let BatNao = document.querySelector('#BatNao')
    let dataBatismo = document.querySelector('#dataBatismo')
    let data_bat = document.querySelector('#data-bat')
    if (BatSim.checked) {
        dataBatismo.style.display = grid;
    } else {
        dataBatismo.style.display = 'none'
    }
    if (BatNao.checked) {
        data_bat.value = ""
        categoria.value = ""
    }
}
function inputing(){
    if (contacto.value.length == 0) {
        contacto.value = contacto.value.replace(/[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZÁÀÂÃÉÊÈÍÌÎÓÒÔÕÚÙÛáàâãéèêíìîóòôõúùû120345678" "]/gi,"")
    }
    else{
        if (contacto.value.length == 3) {
            contacto.value += "-";
        }
        if (contacto.value.length == 7) {
            contacto.value += "-";
        }
        contacto.value = contacto.value.replace(/[abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZÁÀÂÃÉÊÈÍÌÎÓÒÔÕÚÙÛáàâãéèêíìîóòôõúùû" "]/gi,"")

        }    
}