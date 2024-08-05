<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    $status = "";   
    $factory = (new Factory())
        ->withServiceAccount('firebaseconfig.json')
        ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    //$users = $database->getReference('Users')->getSnapshot();
    $id = $_SESSION["id"];
    $user = $database->getReference('Users/'.$id)->getSnapshot()->getValue();
    if (!isset($_SESSION["logado"])) {
        header("Location: login.php");
    }
    if (isset($_REQUEST["nome"])) {
        $ficheiro = $_FILES["foto"];
        $EditUser = [ 
            "id" => $id,
            "nome" => $_REQUEST["nome"],
            "sobrenome" => $_REQUEST["sobrenome"],
            "email"=> $_REQUEST["email"],
            "genero"=>$_REQUEST["sexo"],
            "senha"=>$_REQUEST["senha"],
            "foto"=>$ficheiro["name"]
        ];
        if ($ficheiro["name"] != "") {
            if ($ficheiro["type"]=="image/jpeg" || $ficheiro["type"]=="image/jpg" || $ficheiro["type"]=="image/png") {
                if ($ficheiro["size"]<=5242880) {
                    $_SESSION["nome"] = $_REQUEST["nome"];
                    $_SESSION["sobrenome"] = $_REQUEST["sobrenome"];
                    $_SESSION["email"] = $_REQUEST["email"];
                    $_SESSION["sexo"] = $_REQUEST["sexo"];
                    $_SESSION["senha"] = $_REQUEST["senha"];
                    $_SESSION["novo_user"] = true;
                    $_SESSION["name"] = $ficheiro["name"];
                    move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
                    header("Location: Perfil.php");
                } else {
                    $_SESSION["statusCadastro"] = "O tamanho do ficheiro passou o limite";
                }   
            }
            else{
                $_SESSION["statusCadastro"] = "O formato do ficheiro está incorrecto";
            }
        }
        else{
            $_SESSION["nome"] = $_REQUEST["nome"];
            $_SESSION["sobrenome"] = $_REQUEST["sobrenome"];
            $_SESSION["email"] = $_REQUEST["email"];
            $_SESSION["sexo"] = $_REQUEST["sexo"];
            $_SESSION["senha"] = $_REQUEST["senha"];
            $_SESSION["name"] = $ficheiro["name"];
            move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
            header("Location: Perfil.php");
        }
    
    
        $database->getReference('Users/'.$id)->set($EditUser);

        header("Location: Perfil.php");   
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Editar Perfil</title>
</head>
<body>
    <section id="Edit-Perfil">     
        <form action="" method="post" id="formEditarPerfil" enctype="multipart/form-data">
        <?php 
            if ($_SESSION["name"]!="") {
                echo '<img src="img/'.$_SESSION["name"].'" alt="Foto de Perfil">';
            } else {
                echo '<img src="img/images.png" alt="Foto de Perfil">';
            }
        ?>
            <div class="all">
                <div>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" autocomplete="off" value="<?php echo $user["nome"] ?>">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" autocomplete="off" value="<?php echo $user["sobrenome"]?>">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" autocomplete="off" value="<?php echo $user["email"]?>">
                </div>
                <div>
                    <label for="Masculino">Informe o seu género</label>
                    <div class="radios">
                        <?php if($user["genero"]== "Masculino"){?>
                            <label for="Masculino">Masculino</label>
                            <input type="radio" name="sexo" id="Masculino" checked value="Masculino">
                            <label for="Femenino">Femenino</label>
                            <input type="radio" name="sexo" id="Femenino" value="Femenino">
                        <?php }else{?>
                            <label for="Masculino">Masculino</label>
                            <input type="radio" name="sexo" id="Masculino" value="Masculino">
                            <label for="Femenino">Femenino</label>
                            <input type="radio" name="sexo" id="Femenino" checked value="Femenino">
                        <?php }?>
                    </div>
                    <label for="senha">Insira a sua senha</label>
                    <input type="password" name="senha" id="senha" value ="<?php echo $user["senha"]?>">
                    <label for="foto">Selecionar a sua imagem</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
                    <label for="foto" class="file">Escolher a imagem</label>
                    <input type="file" name="foto" id="foto" autocomplete="off" value="<?php echo $user["foto"]?>" >
                </div>
            </div>
            <div class="input">
                <input type="submit" value="Guardar alterações">
                <a href="Perfil.php">Cancelar</a>
            </div>
        </form>
    </section>
    <script src="EditarPerfil.js"></script>
</body>
</html>