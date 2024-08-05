<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    $statusReg = "";
    try {
        $factory = (new Factory())
            ->withServiceAccount('firebaseconfig.json')
            ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $achado = false;
        $Membros = $database->getReference('Membros')->getSnapshot();
        $tot_count = $database->getReference('Membros')->getSnapshot()->numChildren();
        if (isset($_REQUEST["nome"])) {
            $data_Reg = date('d/m/y');
            if ($tot_count > 0) {
                foreach ($Membros->getValue() as $membro) {
                    if ($membro["Nome"] == $_REQUEST["nome"] && $membro["Nome_do_Pai"] == $_REQUEST["nomePai"] && $membro["Nome_da_Mae"] == $_REQUEST["nomeMae"]) {
                        $achado = true;
                        break;
                    }
                }
                if ($achado) {
                    $statusReg = "Já existe um membro com estes dados";
                }
                else{
                    $novoMembro = [ 
                        "ID"=>$tot_count,
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
                    $database->getReference('Membros/'.$tot_count)->set($novoMembro);
                    $statusReg = "Membro cadastrado com sucesso";
                }
            } else {
                $novoMembro = [ 
                    "ID"=>$tot_count,
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
                $database->getReference('Membros/'.$tot_count)->set($novoMembro);
                $statusReg = "Membro cadastrado com sucesso";
            }
            
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    if (!isset($_SESSION["logado"])) {
        header("Location: login.php");
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
    <title>Adicionar Membros</title>
</head>
<body onload="AbrindoPage()">
    <section id="Add-Membros">
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
                    <h2>Adicionar Membros</h2>
                    <p> <?php echo $statusReg;?> </p>
                    <form action="" method="post" id="formAdd">
                        <div class="all" id="all1">
                            <div class="hard">
                                <label for="nome">Insira o nome do membro</label>
                                <input type="text" name="nome" id="nome" autocomplete="off">
                                <label for="nomePai">Insira o nome do Pai do membro</label>
                                <input type="text" name="nomePai" id="nomePai" autocomplete="off">
                                <label for="nomeMae">Insira o nome do Mãe do membro</label>
                                <input type="text" name="nomeMae" id="nomeMae" autocomplete="off">
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
                                <input type="text" name="naturalidade" id="naturalidade" autocomplete="off">
                                <label for="provincia">Insira a Província do membro</label>
                                <input type="text" name="provincia" id="provincia" autocomplete="off">
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
                                    <option value="Lucas Virgílio">Lucas Virgílio</option>
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
                                    <option value="Organização Juventude Adulta">Organização Jovem Adulto</option>
                                    <option value="Organização Mulheres">Organização Mulheres</option>
                                    <option value="Organização Papas">Organização Papas</option>
                                </select>
                                <label for="cargo">Insira a cargo do membro</label>
                                <input type="text" name="cargo" id="cargo" autocomplete="off">
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
                                        <input type="text" name="grupo_coral" id="grupo_coral" autocomplete="off">
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
                                    <input type="text" name="area_form" id="area_form" autocomplete="off">
                                    <label for="area_act">Área de Actuação</label>
                                    <input type="text" name="area_act" id="area_act" autocomplete="off">
                                </div>
                                <div class="hard">
                                    <label for="res_act">Residência Actual</label>
                                    <input type="text" name="res_act" id="res_act" autocomplete="off">
                                    <label for="bairro">Bairro</label>
                                    <input type="text" name="bairro" id="bairro" autocomplete="off">
                                    <label for="contacto">Insira o seu contactos</label>
                                    <input type="text" name="contacto" id="contacto" maxlength="11" autocomplete="off" oninput="inputing()">
                                </div>
                            </div>
                            <input type="submit" value="Cadastrar membro">
                        </div>
                        
                        <div class="manual-nav">
                            <input type="radio" name="check" id="check1" onclick="Onchecking()">
                            <input type="radio" name="check" id="check2" onclick="Onchecking()">
                            <input type="radio" name="check" id="check3" onclick="Onchecking()">
                        </div>
                    </form>
                    <a href="Perfil.php">Ver Perfil</a>
                </div>
            </div> 
        </div>
    </section>
    <script src="all.js"></script>
    <script src="AddMembros.js"></script>
</body>
</html>