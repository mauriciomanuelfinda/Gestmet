<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    $factory = (new Factory())
        ->withServiceAccount('firebaseconfig.json')
        ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $tot_count = $database->getReference('Membros')->getSnapshot()->numChildren();
    $id = "";
    $data_Reg;
    if (!isset($_SESSION["logado"])) {
        header("Location: login.php");
    }
    $busca_membro = "";
    $status = "";
    $statusBusca = "";
    if (isset($_REQUEST["text_pesq"])) {
        if ($tot_count!=0) {
            $busca = $_REQUEST["text_pesq"];
            $_SESSION["busca"] = $_REQUEST["text_pesq"];
            $membros = $database->getReference('Membros')->getSnapshot();
            foreach($membros->getValue() as $membro){
                if ($membro["Nome"] == $busca || $membro["ID"] == ($busca-1)) {
                    $id = $membro["ID"];
                    $data_Reg = $membro["Data_do_Registro"];
                    break;
                }
                else{
                    $statusBusca = "Membro não encontrado";
                }
            }
            $busca_membro = $database->getReference('Membros/'.$id)->getSnapshot()->getValue();
        }
        else {
            $statusBusca = "Membro não encontrado";
        }
    }
    if (isset($_REQUEST["nome"])) {
        if ($busca_membro!= "" && $id != "") {
            $novoMembro = [ 
                "ID"=>$id,
                "Nome" => $_REQUEST["nome"],
                "Nome_do_Pai" => $_REQUEST["nomePai"],
                "Nome_da_Mae"=> $_REQUEST["nomeMae"],
                "Data_de_Nascimento"=>$_REQUEST["data_nasc"],
                "Genero"=>$_REQUEST["sexo"],
                "Naturalidade"=>$_REQUEST["naturalidade"],
                "Provincia"=>$_REQUEST["provincia"],
                "Estado_civil"=>$_REQUEST["estado_civil"],
                "Batismo"=>$_REQUEST["Bat"],
                "Data_do_batismo"=>$_REQUEST["data_bat"],
                "Categoria"=>$_REQUEST["categ"],
                "Classe_do_membro"=>$_REQUEST["classe"],
                "Organização"=>$_REQUEST["Organizacao"],
                "Cargo_na_igreja"=>$_REQUEST["cargo"],
                "Pertence_a_um_Grupo"=>$_REQUEST["Esc"],
                "Grupo_coral"=>$_REQUEST["grupo_coral"],
                "Habilitacoes_Literarias"=>$_REQUEST["hab_liter"],
                "Area_Formacao"=>$_REQUEST["area_form"],
                "Area_Actuacao"=>$_REQUEST["area_act"],
                "Res_act"=>$_REQUEST["res_act"],
                "Bairro"=>$_REQUEST["bairro"],
                "Contacto"=>$_REQUEST["contacto"],
                "Data_do_Registro"=>$data_Reg
            ];
            $database->getReference('Membros/'.id)->set($novoMembro);
            $status = "Dados editado com sucesso";
        }
        else{
            $status = "Dados não editado";
        }
    }
    if (isset($_REQUEST["btn_elim"])) {
        if (isset($_SESSION["busca"])) {
            $tot_count = $database->getReference('Membros')->getSnapshot()->numChildren();
            if ($tot_count > 0) {
                $deletado = $database->getReference('Membros/'.$id)->remove();
                if ($deletado) {
                    $status = "Membro deletado com sucesso";
                } else {
                    $status = "Membro não deletado";
                }
            }
        }
        else{
            $status = "Precisa selecionar o membro primeiro";
        }
    }

       
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="all.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Pesquisar Membros</title>
</head>
<body>
    <section id="Pesq-Membros">
        <div class="main">
            <div class="all">
                <div class="all-in">
                    <img src="img/logo.png" alt="Logotipo da Igreja">
                </div>
                <div class="nome-perfil">
                    <?php 
                        if ($_SESSION["name"]!="") {
                            echo '<img src="img/'.$_SESSION["name"].'" alt="Foto de Perfil">';
                        } else {
                            echo '<img src="img/images.png" alt="Foto de Perfil">';
                        }
                    ?> 
                    <h2><b>Olá</b>, <?php echo $_SESSION['nome_completo']?></h2>
                    <a href="logout.php">Logout</a>
                </div> 
            </div>
            <div class="Dados">
                <div class="link">
                    <a href="AddMembros.php">Adicionar Membros</a>
                    <a href="VerMembros.php">Ver todos os membros</a>
                    <a href="PesquisarMembros.php">Pesquisar membros</a>
                </div>
                <div class="link1">
                    <a href="AddMembros.php" title="Adicionar Membros"><i class="fa-solid fa-user-plus"></i></a>
                    <a href="VerMembros.php" title="Ver todos os membros"><i class="fa-regular fa-eye"></i></a>
                    <a href="PesquisarMembros.php" title="Pesquisar membros"><i class="fa-solid fa-magnifying-glass-plus"></i></a>
                </div>
                <div class="in">
                    <h2>Pesquisar Membros</h2>
                    <p><?php echo  $status?></p>
                    <div class="card">
                        <form action="" method="post" id="formPesqMembros">
                            <label for="pesq">Insira o nome ou o número do membro</label>
                            <div>
                                <input type="search" name="text_pesq" id="pesq">
                                <input type="submit" value="Pesquisar">
                            </div>
                            <label for=""><?php echo $statusBusca?></label>
                        </form>
                        
                        <div class="wrap">
                            <div class="wrap-in">
                                <div class="div1">
                                    <div class="all">
                                        <?php if ($busca_membro != ""){?>
                                        <label for="">Nome do membro</label>
                                        <label for="">Nome do Pai</label>
                                        <label for="">Nome da Mãe</label>
                                        <label for="">Data de nascimento</label>
                                        <label for="">Género</label>
                                        <label for="">Naturalidade</label>
                                        <label for="">Provincia</label>
                                        <label for="">Estado civil</label>
                                        <label for="">Batismo</label>
                                        <label for="">Data do batismo</label>
                                        <label for="">Organização</label>
                                        <label for="">Classe</label>
                                        <label for="">Cargo na Igreja</label>
                                        <label for="">Grupo coral</label>
                                        <label for="">Nome do grupo coral</label>
                                        <label for="">Cargo no grupo coral</label>
                                        <label for="">Habilitações literárias</label>
                                        <label for="">Área de formação</label>
                                        <label for="">Área de actuação</label>
                                        <label for="">Residência actual</label>
                                        <label for="">Bairro</label>
                                        <label for="">Contacto</label>
                                        <?php }?>
                                    </div>
                                    <div class="all">
                                        <?php if ($busca_membro != ""){?>
                                        <p><?php echo $busca_membro["Nome"]?></p>
                                        <p><?php echo $busca_membro["Nome_do_Pai"]?></p>
                                        <p><?php echo $busca_membro["Nome_da_Mae"]?></p>
                                        <p><?php echo $busca_membro["Data_de_Nascimento"]?></p>
                                        <p><?php echo $busca_membro["Genero"]?></p>
                                        <p><?php echo $busca_membro["Naturalidade"]?></p>
                                        <p><?php echo $busca_membro["Provincia"]?></p>
                                        <p><?php echo $busca_membro["Estado_civil"]?></p>
                                        <p><?php echo $busca_membro["Batismo"]?></p>
                                        <p><?php echo $busca_membro["Data_do_batismo"]?></p>
                                        <p><?php echo $busca_membro["Categoria"]?></p>
                                        <p><?php echo $busca_membro["Classe_do_membro"]?></p>
                                        <p><?php echo $busca_membro["Organização"]?></p>
                                        <p><?php echo $busca_membro["Cargo_na_igreja"]?></p>
                                        <p><?php echo $busca_membro["Pertence_a_um_Grupo"]?></p>
                                        <p><?php echo $busca_membro["Grupo_coral"]?></p>
                                        <p><?php echo $busca_membro["Habilitacoes_Literarias"]?></p>
                                        <p><?php echo $busca_membro["Area_Formacao"]?></p>
                                        <p><?php echo $busca_membro["Area_Actuacao"]?></p>
                                        <p><?php echo $busca_membro["Res_act"]?></p>
                                        <p><?php echo $busca_membro["Bairro"]?></p>
                                        <p><?php echo $busca_membro["Contacto"]?></p>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="div2">
                                    <?php if ($busca_membro != ""){?>
                                    <label for="">Nome do membro</label>
                                    <p><?php echo $busca_membro["Nome"]?></p>
                                    <label for="">Nome do Pai</label>
                                    <p><?php echo $busca_membro["Nome_do_Pai"]?></p>
                                    <label for="">Nome da Mãe</label>
                                    <p><?php echo $busca_membro["Nome_da_Mae"]?></p>
                                    <label for="">Data de nascimento</label>
                                    <p><?php echo $busca_membro["Data_de_Nascimento"]?></p>
                                    <label for="">Género</label>
                                    <p><?php echo $busca_membro["Genero"]?></p>
                                    <label for="">Naturalidade</label>
                                    <p><?php echo $busca_membro["Naturalidade"]?></p>
                                    <label for="">Provincia</label>
                                    <p><?php echo $busca_membro["Provincia"]?></p>
                                    <label for="">Estado civil</label>
                                    <p><?php echo $busca_membro["Estado_civil"]?></p>
                                    <label for="">Batismo</label>
                                    <p><?php echo $busca_membro["Batismo"]?></p>
                                    <label for="">Data do batismo</label>
                                    <p><?php echo $busca_membro["Data_do_batismo"]?></p>
                                    <label for="">Categoria</label>
                                    <p><?php echo $busca_membro["Categoria"]?></p>
                                    <label for="">Classe</label>
                                    <p><?php echo $busca_membro["Classe_do_membro"]?></p>
                                    <label for="">Organização</label>
                                    <p><?php echo $busca_membro["Organização"]?></p>
                                    <label for="">Cargo na Igreja</label>
                                    <p><?php echo $busca_membro["Cargo_na_igreja"]?></p>
                                    <label for="">Grupo coral</label>
                                    <p><?php echo $busca_membro["Pertence_a_um_Grupo"]?></p>
                                    <label for="">Nome do grupo coral</label>
                                    <p><?php echo $busca_membro["Grupo_coral"]?></p>
                                    <label for="">Habilitações literárias</label>
                                    <p><?php echo $busca_membro["Habilitacoes_Literarias"]?></p>
                                    <label for="">Área de formação</label>
                                    <p><?php echo $busca_membro["Area_Formacao"]?></p>
                                    <label for="">Área de actuação</label>
                                    <p><?php echo $busca_membro["Area_Actuacao"]?></p>
                                    <label for="">Residência actual</label>
                                    <p><?php echo $busca_membro["Res_act"]?></p>
                                    <label for="">Bairro</label>
                                    <p><?php echo $busca_membro["Bairro"]?></p>
                                    <label for="">Contacto</label>
                                    <p><?php echo $busca_membro["Contacto"]?></p>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="inputs">
                            <form action="" method="post">
                                <input type="submit" name="btn_elim" value="Eliminar" >
                            </form>
                            <input type="submit" value="Editar" onclick="mostrarEditMembros()">
                        </div>
                    </div>
                    <a href="Perfil.php">Ver Perfil</a>
                </div>
            </div> 
        </div>
    </section>

    <section id="Edit-Membros" onload="Abrindo()">
        <p onclick="removerEditMembros()">X</p>
        <h2>Editar Membros</h2>
        <form action="" method="post" id="formEdit">
            <?php if ($busca_membro!="") {?>
                <div class="all" id="all1">
                <div class="hard">
                    <label for="nome">Insira o nome do membro</label>
                    <input type="text" name="nome" id="nome" autocomplete="off" value="<?php echo $busca_membro["Nome"]?>">
                    <label for="nomePai">Insira o nome do Pai do membro</label>
                    <input type="text" name="nomePai" id="nomePai" autocomplete="off" value="<?php echo $busca_membro["Nome_do_Pai"]?>">
                    <label for="nomeMae">Insira o nome do Mãe do membro</label>
                    <input type="text" name="nomeMae" id="nomeMae" autocomplete="off" value="<?php echo $busca_membro["Nome_da_Mae"]?>">
                    <label for="data_nasc">Data de Nascimento</label>
                    <input type="date" name="data_nasc" id="data_nasc" value="<?php echo $busca_membro["Data_de_Nascimento"]?>">
                </div>
                <div class="hard">
                    <label for="Masculino">Selecione o género</label>
                    <div class="radios">
                        <?php if ($busca_membro["Genero"] == "Masculino") {?>
                        <div>
                            <label for="Masculino">Masculino</label>
                            <input type="radio" name="sexo" id="Masculino" checked value="Masculino">
                        </div>
                        <div>
                            <label for="Femenino">Femenino</label>
                            <input type="radio" name="sexo" id="Femenino" value="Femenino">
                        </div>
                        <?php }else{?>
                            <div>
                            <label for="Masculino">Masculino</label>
                            <input type="radio" name="sexo" id="Masculino" value="Masculino">
                        </div>
                        <div>
                            <label for="Femenino">Femenino</label>
                            <input type="radio" name="sexo" id="Femenino" checked value="Femenino">
                        </div>
                        <?php }?>
                    </div>
                    <label for="naturalidade">Insira a naturalidade do membro</label>
                    <input type="text" name="naturalidade" id="naturalidade" autocomplete="off" value="<?php echo $busca_membro["Naturalidade"]?>">
                    <label for="provincia">Insira a Província do membro</label>
                    <input type="text" name="provincia" id="provincia" autocomplete="off" value="<?php echo $busca_membro["Provincia"]?>">
                    <label for="estado_civil">Selecione o estado civil do membro</label>
                    <select name="estado_civil" id="estado_civil" >
                        <option value="<?php echo $busca_membro["Estado_civil"]?>"><?php echo $busca_membro["Estado_civil"]?></option>
                        <option value="Solteiro">Solteiro</option>
                        <option value="Casado">Casado</option>
                        <option value="Viuvo">Viuvo</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Vive maritalmente">Vive maritalmente</option>
                    </select>
                </div>
            </div>
            <div class="all" id="all2">
                <div class="hard">
                    <label for="BatSim">Já foi batizado?</label>
                    <div class="radios">
                        <?php if ($busca_membro["Batismo"]=="Sim"){?>
                            <div>
                                <label for="BatSim">Sim</label>
                                <input type="radio" name="Bat" id="BatSim" checked value="Sim" onclick="dataBatismo()">
                            </div>
                            <div>
                                <label for="BatNao">Não</label>
                                <input type="radio" name="Bat" id="BatNao" value="Não" onclick="dataBatismo()">
                            </div>
                        <?php }else{?>
                            <div>
                                <label for="BatSim">Sim</label>
                                <input type="radio" name="Bat" id="BatSim" value="Sim" onclick="dataBatismo()">
                            </div>
                            <div>
                                <label for="BatNao">Não</label>
                                <input type="radio" name="Bat" id="BatNao" checked value="Não" onclick="dataBatismo()">
                            </div>
                        <?php }?>
                    </div>
                    <div class="data-batismo"  id="dataBatismo">
                        <label for="data_bat">Data do batismo</label>
                        <input type="date" name="data_bat" id="data_bat" value="<?php echo $busca_membro["Data_do_batismo"]?>">
                        <label for="categ">Selecione a sua categoria</label>
                        <select name="categ" id="categ">
                            <option value="<?php echo $busca_membro["Categoria"]?>"><?php echo $busca_membro["Categoria"]?></option>
                            <option value="Catecumeno">Catecumeno</option>
                            <option value="Aprova">Aprova</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <label for="classe">Seleccione a classe do membro</label>
                    <select name="classe" id="classe">
                        <option value="<?php echo $busca_membro["Classe_do_membro"]?>"><?php echo $busca_membro["Classe_do_membro"]?></option>
                        <option value="Betânia">Betânia</option>
                        <option value="Boa Esperança">Boa Esperança</option>
                        <option value="Lucas Virgínia">Lucas Virgínia</option>
                        <option value="Ruth">Ruth</option>
                        <option value="Miguel Simão">Miguel Simão</option>
                        <option value="Antónia Zeferino">Antónia Zeferino</option>
                        <option value="Perreira Humbi">Perreira Humbi</option>
                        <option value="Miranda Alfredo">Miranda Alfredo</option>
                        <option value="Domingos André Carlos">Domingos André Carlos</option>
                    </select>
                </div>
                <div class="hard">
                    <label for="Organizacao">Pertence a alguma organização?</label>
                    <select name="Organizacao" id="Organizacao">
                        <option value="<?php echo $busca_membro["Organização"]?>"><?php echo $busca_membro["Organização"]?></option>
                        <option value="Não">Não</option>
                        <option value="Criança">Criança</option>
                        <option value="Organização Juventude">Organização Juventude</option>
                        <option value="Organização Juventude Adulta">Organização Juventude Adulta</option>
                        <option value="Organização Mulheres">Organização Mulheres</option>
                        <option value="Organização Papas">Organização Papas</option>
                    </select>
                    <label for="cargo">Insira a cargo do membro</label>
                    <input type="text" name="cargo" id="cargo" autocomplete="off" value="<?php echo $busca_membro["Cargo_na_igreja"]?>">
                    <label for="Sim">Pertence a um grupo coral ou musical?</label>
                    <div class="radios">
                        <?php if($busca_membro["Pertence_a_um_Grupo"]== "Sim"){?>
                            <div>
                            <label for="Sim">Sim</label>
                            <input type="radio" name="Esc" id="Sim" checked value="Sim" onclick="mostrarCoro()">
                            </div>
                            <div>
                                <label for="Nao">Não</label>
                                <input type="radio" name="Esc" id="Nao" value="Não" onclick="mostrarCoro()">
                            </div>
                        <?php }else{?>
                            <div>
                                <label for="Sim">Sim</label>
                                <input type="radio" name="Esc" id="Sim" value="Sim" onclick="mostrarCoro()">
                            </div>
                            <div>
                                <label for="Nao">Não</label>
                                <input type="radio" name="Esc" id="Nao" checked value="Não" onclick="mostrarCoro()">
                            </div>
                            
                        <?php }?>
                    </div>
                    <div class="Coral-Musical" id="Coral-Musical">
                        <div class="card">
                            <label for="grupo_coral">Insira o nome do grupo coral</label>
                            <input type="text" name="grupo_coral" id="grupo_coral" autocomplete="off" value="<?php echo $busca_membro["Grupo_coral"]?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="container" id="all4">
                <div class="all" id="all3">
                    <div class="hard">
                        <label for="hab_liter">Selecione as suas habilitações literárias</label>
                        <select name="hab_liter" id="hab_liter">
                            <option value="<?php echo $busca_membro["Habilitacoes_Literarias"]?>"><?php echo $busca_membro["Habilitacoes_Literarias"]?></option>
                            <option value="Ensino Base">Ensino Base</option>
                            <option value="Ciclo">Ciclo</option>
                            <option value="Ensino Médio">Ensino Médio</option>
                            <option value="Ensino Superior">Ensino Superior</option>
                            <option value="Licenciado">Licenciado</option>
                            <option value="Mestrado">Mestrado</option>
                            <option value="PHD">PHD</option>
                        </select>
                        <label for="area_form">Área de Formação</label>
                        <input type="text" name="area_form" id="area_form" autocomplete="off" value="<?php echo $busca_membro["Area_Formacao"]?>">
                        <label for="area_act">Área de Actuação</label>
                        <input type="text" name="area_act" id="area_act" autocomplete="off" value="<?php echo $busca_membro["Area_Actuacao"]?>">
                    </div>
                    <div class="hard">
                        <label for="res_act">Residência Actual</label>
                        <input type="text" name="res_act" id="res_act" autocomplete="off" value="<?php echo $busca_membro["Res_act"]?>">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" autocomplete="off" value="<?php echo $busca_membro["Bairro"]?>">
                        <label for="contacto">Insira o seu contactos</label>
                        <input type="text" name="contacto" id="contacto" maxlength="11" autocomplete="off" value="<?php echo $busca_membro["Contacto"]?>" oninput="inputing()">
                    </div>
                </div>
                <input type="submit" value="Editar membro">
            </div>

            <?php }else{?>
                <div class="all" id="all1">
                <div class="hard">
                    <label for="nome">Insira o nome do membro</label>
                    <input type="text" name="nome" id="nome" autocomplete="off" value="">
                    <label for="nomePai">Insira o nome do Pai do membro</label>
                    <input type="text" name="nomePai" id="nomePai" autocomplete="off" value="">
                    <label for="nomeMae">Insira o nome do Mãe do membro</label>
                    <input type="text" name="nomeMae" id="nomeMae" autocomplete="off" value="">
                    <label for="data_nasc">Data de Nascimento</label>
                    <input type="date" name="data_nasc" id="data_nasc">
                </div>
                <div class="hard">
                    <label for="Masculino">Selecione o género</label>
                    <div class="radios">
                        <div>
                            <label for="Masculino">Masculino</label>
                            <input type="radio" name="sexo" id="Masculino" value="Masculino">
                        </div>
                        <div>
                            <label for="Femenino">Femenino</label>
                            <input type="radio" name="sexo" id="Femenino" value="Femenino">
                        </div>
                    </div>
                    <label for="naturalidade">Insira a naturalidade do membro</label>
                    <input type="text" name="naturalidade" id="naturalidade" autocomplete="off" value="">
                    <label for="provincia">Insira a Província do membro</label>
                    <input type="text" name="provincia" id="provincia" autocomplete="off" value="">
                    <label for="estado_civil">Selecione o estado civil do membro</label>
                    <select name="estado_civil" id="estado_civil">
                        <option value=""></option>
                        <option value="Solteiro">Solteiro</option>
                        <option value="Casado">Casado</option>
                        <option value="Viuvo">Viuvo</option>
                        <option value="Divorciado">Divorciado</option>
                        <option value="Vive maritalmente">Vive maritalmente</option>
                    </select>
                </div>
            </div>
            <div class="all" id="all2">
                <div class="hard">
                    <label for="BatSim">Já foi batizado?</label>
                    <div class="radios">
                        <div>
                            <label for="BatSim">Sim</label>
                            <input type="radio" name="Bat" id="BatSim" value="Sim" onclick="dataBatismo()">
                        </div>
                        <div>
                            <label for="BatNao">Não</label>
                            <input type="radio" name="Bat" id="BatNao" value="Não" onclick="dataBatismo()">
                        </div>
                    </div>
                    <div class="data-batismo"  id="dataBatismo">
                        <label for="data_bat">Data do batismo</label>
                        <input type="date" name="data_bat" id="data_bat">
                        <label for="categ">Selecione a sua categoria</label>
                        <select name="categ" id="categ">
                            <option value=""></option>
                            <option value="Catecumeno">Catecumeno</option>
                            <option value="Aprova">Aprova</option>
                            <option value="Efectivo">Efectivo</option>
                        </select>
                    </div>
                    <label for="classe">Seleccione a classe do membro</label>
                    <select name="classe" id="classe">
                        <option value=""></option>
                        <option value="Betânia">Betânia</option>
                        <option value="Boa Esperança">Boa Esperança</option>
                        <option value="Lucas Virgínia">Lucas Virgínia</option>
                        <option value="Ruth">Ruth</option>
                        <option value="Miguel Simão">Miguel Simão</option>
                        <option value="Antónia Zeferino">Antónia Zeferino</option>
                        <option value="Perreira Humbi">Perreira Humbi</option>
                        <option value="Miranda Alfredo">Miranda Alfredo</option>
                        <option value="Domingos André Carlos">Domingos André Carlos</option>
                    </select>
                </div>
                <div class="hard">
                    <label for="Organizacao">Pertence a alguma organização?</label>
                    <select name="Organizacao" id="Organizacao">
                        <option value=""></option>
                        <option value="Não">Não</option>
                        <option value="Criança">Criança</option>
                        <option value="Organização Juventude">Organização Juventude</option>
                        <option value="Organização Juventude Adulta">Organização Juventude Adulta</option>
                        <option value="Organização Mulheres">Organização Mulheres</option>
                        <option value="Organização Papas">Organização Papas</option>
                    </select>
                    <label for="cargo">Insira a cargo do membro</label>
                    <input type="text" name="cargo" id="cargo" autocomplete="off" value="">
                    <label for="Sim">Pertence a um grupo coral ou musical?</label>
                    <div class="radios">
                        <div>
                            <label for="Sim">Sim</label>
                            <input type="radio" name="Esc" id="Sim" value="Sim" onclick="mostrarCoro()">
                        </div>
                        <div>
                            <label for="Nao">Não</label>
                            <input type="radio" name="Esc" id="Nao" value="Não" onclick="mostrarCoro()">
                        </div>
                    </div>
                    <div class="Coral-Musical" id="Coral-Musical">
                        <div class="card">
                            <label for="grupo_coral">Insira o nome do grupo coral</label>
                            <input type="text" name="grupo_coral" id="grupo_coral" autocomplete="off" value="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container" id="all4">
                <div class="all" id="all3">
                    <div class="hard">
                        <label for="hab_liter">Selecione as suas habilitações literárias</label>
                        <select name="hab_liter" id="hab_liter">
                            <option value=""></option>
                            <option value="Ensino Base">Ensino Base</option>
                            <option value="Ciclo">Ciclo</option>
                            <option value="Ensino Médio">Ensino Médio</option>
                            <option value="Ensino Superior">Ensino Superior</option>
                            <option value="Licenciado">Licenciado</option>
                            <option value="Mestrado">Mestrado</option>
                            <option value="PHD">PHD</option>
                        </select>
                        <label for="area_form">Área de Formação</label>
                        <input type="text" name="area_form" id="area_form" autocomplete="off" value="">
                        <label for="area_act">Área de Actuação</label>
                        <input type="text" name="area_act" id="area_act" autocomplete="off" value="">
                    </div>
                    <div class="hard">
                        <label for="res_act">Residência Actual</label>
                        <input type="text" name="res_act" id="res_act" autocomplete="off" value="">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" autocomplete="off" value="">
                        <label for="contacto">Insira o seu contactos</label>
                        <input type="text" name="contacto" id="contacto" maxlength="11" autocomplete="off" value="" oninput="inputing()">
                    </div>
                </div>
                <input type="submit" value="Editar membro">
            </div>
            <?php }?>
            
            <div class="manual-nav">
                <input type="radio" name="check" id="check1" checked onclick="Onchecking()">
                <input type="radio" name="check" id="check2" onclick="Onchecking()">
                <input type="radio" name="check" id="check3" onclick="Onchecking()">
            </div>
        </form>
    </section>
    <script src="all.js"></script>
    <script src="PesqMembros.js"></script>
    <script src="editMembros.js"></script>
</body>
</html>