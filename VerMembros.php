<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    use Dompdf\Dompdf;
    $cont = 1;
    $ano = date('y');
    $dia = date('d');
    $mes = date('m');
    $factory = (new Factory())
        ->withServiceAccount('firebaseconfig.json')
        ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $tot_count = $database->getReference('Membros')->getSnapshot()->numChildren();
    $membros = $database->getReference('Membros')->getSnapshot();
    if (isset($_REQUEST["btn_imp"])) {
        $id = $_REQUEST["btn_imp"];
        $busca_membro = $database->getReference('Membros/'.$id)->getSnapshot()->getValue();
        $conteudo_pdf  = "<!DOCTYPE html>";
        $conteudo_pdf .= "<html lang='pt-br'>";
        $conteudo_pdf .= "<head>";
        $conteudo_pdf .= "<meta charset='UTF-8'>";
        $conteudo_pdf .= '<link rel="stylesheet" href="http://localhost/Projecto_Eunice/stylePdf.css">';
        $conteudo_pdf .= "</head>";
        $conteudo_pdf .= "<body>";
        $conteudo_pdf .= "<section id='Cabecalho'>";
        $conteudo_pdf .= "<div class='img'>
                            <img src='http://localhost/Projecto_Eunice/img/logo.png' alt=''>
                        </div>
                        <div class='texto'>
                            <p>IGREJA METODISTA UNIDA</p>
                            <p>ANUAL DO ESTE DE ANGOLA</p>
                            <p>DISTRITO ECLESIÁTICO DE LUANDA</p>
                            <p>INTENDENCIA VIANA-CACUACO</p>
                            <p>CARGO PASTORIAL REV. LUIS CORREIA KIZEMBE</p>
                            <p>ROL DE MEMBRO DA IGREJA</p>
                        </div>";
        $conteudo_pdf .= "</section>";
        $conteudo_pdf .= "<div id='fic-mem'>
                            <p>FICHEIRO INDIVIDUAL SE MEMBROS Nº ".($busca_membro["ID"]+1)."</p>
                            <div></div>
                        </div>
                        <div id='Passo1'>
                            <div>
                                <p class='p1'> <b>Nome:</b>".$busca_membro["Nome"]."</p>
                            </div>
                            <div>
                                <p class='p2'> <b>Filiação:</b>  ".$busca_membro["Nome_do_Pai"]."</p>
                                <p class='p3'> <b>e de:</b>  ".$busca_membro["Nome_da_Mae"]."</p>
                            </div>
                            <div>
                                <p class='p4'> <b>Data de Nascimento:</b>   ".$busca_membro["Data_de_Nascimento"]."</p>
                                <p class='p5'> <b>Sexo:</b>  ".$busca_membro["Genero"]."</p>
                                <p class='p6'> <b>Estado civil:</b>   ".$busca_membro["Estado_civil"]."</p>
                            </div>
                            <div>
                                <p class='p7'> <b>Natural:</b>    ".$busca_membro["Naturalidade"]."</p>
                                <p class='p8'> <b>Província:</b>    ".$busca_membro["Provincia"]."</p>
                            </div>
                        </div>
                        <div id='Passo2'>
                            <div>
                                <p class='p1'> <b>Batizado:</b>    ".$busca_membro["Batismo"]."</p>
                                <p class='p2'> <b>Em:</b>      ".$busca_membro["Data_do_batismo"]."</p>
                            </div>
                            <div>
                                <p class='p3'> <b>Categoria:</b>   ".$busca_membro["Categoria"]."</p>
                            </div>
                            <div>
                                <p class='p4'> <b>Classe:</b>   ".$busca_membro["Classe_do_membro"]."</p>
                            </div>
                            <div>           
                                <p class='p5'> <b>Pertence a alguma organização:</b> ".$busca_membro["Organização"]."</p>
                                <p class='p6'> <b>Cargo:</b>   ".$busca_membro["Cargo_na_igreja"]."</p>
                            </div>
                            <div>
                                <p class='p7'> <b>Pertence a algum grupo coral ou musical:</b>  ".$busca_membro["Pertence_a_um_Grupo"]."</p>
                                <p class='p8'> <b>Qual grupo:</b> ".$busca_membro["Grupo_coral"]."</p>
                            </div>
                        </div>
                        <div id='Passo3'>
                            <div>
                                <p class='p1'> <b>Habilitações Literárias:</b>   ".$busca_membro["Habilitacoes_Literarias"]."</p>
                            </div>
                            <div>
                                <p class='p2'> <b>Área de Formação:</b> ".$busca_membro["Area_Formacao"]."</p>
                            </div>
                            <div>
                                <p class='p3'> <b>Área de Actuação:</b>  ".$busca_membro["Area_Actuacao"]."</p>
                            </div>
                            <div>
                                <p class='p4'> <b>Residência Actual:</b> ".$busca_membro["Res_act"]."</p>
                                <p class='p5'> <b>Bairro:</b> ".$busca_membro["Bairro"]."</p>
                            </div>
                            <div>
                                <p class='p6'> <b>Telefone:</b>  ".$busca_membro["Contacto"]."</p>
                            </div>
                        </div>
                        <div id='Ld-Data'>
                            <p>Luanda aos ".$dia." de ".$mes." de 20".$ano."/20".($ano+1)."</p>
                        </div>
                        <div id='Ass-Pres'>
                            <p><b>A Presidente</b></p>
                            <p>Eunice Tchihunda Ikuma</p>
                        </div>";
        $conteudo_pdf .= "</body>";
        $conteudo_pdf .= "</html>";

        /*Instaciar e usar classe dompdf */
        $dompdf = new Dompdf(['enable_remote' => true]);

        /*Carregar o conteúdo HTML a ser impresso */
        $dompdf->loadHtml($conteudo_pdf);

        /*Configurar o tamanho e a horientação do papel */
        $dompdf->setPaper('A4', 'portrait');

        /*Renderizando o HTML */
        $dompdf->render();

        /*Gerar o PDF */
        $dompdf->stream($busca_membro["Nome"].".pdf",  ["Attachment" => 1]);

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
    <title>Ver Membros</title>
</head>
<body>
    <section id="Ver-Membros">
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
                    <h2>Lista dos membros cadatrados</h2>
                    <p> </p>
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <th>Nº</th>
                                <th>Nome do Membro</th>
                                <th>Nome do Pai</th>
                                <th>Nome da Mãe</th>
                                <th>Data de nascimento</th>
                                <th>Género</th>
                                <th>Naturalidade</th>
                                <th>Provincia</th>
                                <th>Estado civil</th>
                                <th>Batismo</th>
                                <th>Data do batismo</th>
                                <th>Categoria</th>
                                <th>Classe</th>
                                <th>Organização</th>
                                <th>Cargo na Igreja</th>
                                <th>Pertence a um Grupo</th>
                                <th>Nome do grupo coral</th>
                                <th>Habilitações literárias</th>
                                <th>Área de formação</th>
                                <th>Área de actuação</th>
                                <th>Residência actual</th>
                                <th>Bairro</th>
                                <th>Contacto</th>
                                <th>Data do registro</th>
                                <th>Imprimir</th>
                            </thead>
                            <tbody>
                                <?php if($tot_count!=0){ ?>
                                <?php foreach( $membros->getValue() as $membro){?>
                                    <td><?php echo $cont++?></td>
                                    <td><?php echo $membro["Nome"]?></td>
                                    <td><?php echo $membro["Nome_do_Pai"]?></td>
                                    <td><?php echo $membro["Nome_da_Mae"]?></td>
                                    <td><?php echo $membro["Data_de_Nascimento"]?></td>
                                    <td><?php echo $membro["Genero"]?></td>
                                    <td><?php echo $membro["Naturalidade"]?></td>
                                    <td><?php echo $membro["Provincia"]?></td>
                                    <td><?php echo $membro["Estado_civil"]?></td>
                                    <td><?php echo $membro["Batismo"]?></td>
                                    <td><?php echo $membro["Data_do_batismo"]?></td>
                                    <td><?php echo $membro["Categoria"]?></td>
                                    <td><?php echo $membro["Classe_do_membro"]?></td>
                                    <td><?php echo $membro["Organização"]?></td>
                                    <td><?php echo $membro["Cargo_na_igreja"]?></td>
                                    <td><?php echo $membro["Pertence_a_um_Grupo"]?></td>
                                    <td><?php echo $membro["Grupo_coral"]?></td>
                                    <td><?php echo $membro["Habilitacoes_Literarias"]?></td>
                                    <td><?php echo $membro["Area_Formacao"]?></td>
                                    <td><?php echo $membro["Area_Actuacao"]?></td>
                                    <td><?php echo $membro["Res_act"]?></td>
                                    <td><?php echo $membro["Bairro"]?></td>
                                    <td><?php echo $membro["Contacto"]?></td>
                                    <td><?php echo $membro["Data_do_Registro"]?></td>
                                    <td>
                                        <?php echo '<form action="" method="post">
                                                <button type="submit" name="btn_imp" value="'.$membro["ID"].'">Imprimir</button>
                                            </form>' ?>
                                    </td>
                                    <?php } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <td colspan="25">Total de membros cadastrados: <?php echo $tot_count?> </td>
                            </tfoot>
                        </table>
                    </div>
                    <a href="Perfil.php">Ver Perfil</a>
                </div>
            </div> 
        </div>
    </section>
    <script src="all.js"></script>
</body>
</html>