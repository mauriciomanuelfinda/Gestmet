<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory; 
    try {
        $factory = (new Factory())
        ->withServiceAccount('firebaseconfig.json')
        ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $tot_count = $database->getReference('Users')->getSnapshot()->numChildren();
        $users = $database->getReference('Users')->getSnapshot();
        $achado = false;
        $num_Sort = rand(100,999).'-'.rand(100,999);
        if (isset($_REQUEST["nome"])) {
            $ficheiro = $_FILES["foto"];
            if ($tot_count > 0) {
                foreach ($users->getValue() as $user) {
                    if ($user["nome"] == $_REQUEST["nome"] && $user["sobrenome"] == $_REQUEST["sobrenome"]) {
                        $achado = true;
                        break;
                    }
                }
                if ($achado) {
                    $_SESSION["statusCadastro"] = "Já existe uma conta com estes dados";
                }
                else{
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
                                setcookie("codeCount",$num_Sort,time()+60*60*24, "/");
                                move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
                                header("Location: Getcode.php");
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
                        $_SESSION["novo_user"] = true;
                        $_SESSION["name"] = $ficheiro["name"];
                        $_SESSION["tmp_name"] = $ficheiro["tmp_name"];
                        setcookie("codeCount",$num_Sort,time()+60*60*24, "/");
                        move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
                        header("Location: Getcode.php");
                    }
                
                }
            }
            else{
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
                            $_SESSION["tmp_name"] = $ficheiro["tmp_name"];
                            setcookie("codeCount",$num_Sort,time()+60*60*24, "/");
                            move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
                            header("Location: Getcode.php");
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
                    $_SESSION["novo_user"] = true;
                    $_SESSION["name"] = $ficheiro["name"];
                    $_SESSION["tmp_name"] = $ficheiro["tmp_name"];
                    setcookie("codeCount",$num_Sort,time()+60*60*24, "/");
                    move_uploaded_file($ficheiro["tmp_name"], "img/".$ficheiro["name"]);
                    header("Location: Getcode.php");
                }
            }
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Cadastro</title>
</head>
<body>
    <div id="Erro">
        <p>
            <?php 
                if (isset($_SESSION["statusCadastro"])) {
                    echo $_SESSION["statusCadastro"];
                }
            ?>
        </p>
    </div>
    <section id="Cadastro">
        <a href="login.php">Fazer login</a>
        <form action="cadastro.php" method="post" enctype="multipart/form-data" id="formCadastro">
            <div class="all">
                <div>
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" autocomplete="off">
                    <label for="sobrenome">Sobrenome</label>
                    <input type="text" name="sobrenome" id="sobrenome" autocomplete="off">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" autocomplete="off">
                </div>
                <div>
                    <label for="Masculino">Informe o seu género</label>
                    <div class="radios">
                        <label for="Masculino">Masculino</label>
                        <input type="radio" name="sexo" id="Masculino" value="Masculino">
                        <label for="Femenino">Femenino</label>
                        <input type="radio" name="sexo" id="Femenino" value="Femenino">
                    </div>
                    <label for="senha">Insira a sua senha</label>
                    <input type="password" name="senha" id="senha">
                    <label for="foto">Selecionar a sua imagem</label>
                    <input type="hidden" name="MAX_FILE_SIZE" value="5242880">
                    <label for="foto" class="file">Escolher a imagem</label>
                    <input type="file" name="foto" id="foto" autocomplete="off">
                </div>
            </div>
            <small>Tamanho máximo da imagem 5MB</small>
            <input type="submit" value="Cadastrar" name="btn_cad">
        </form>
    </section>
    <script src="cadastro.js"></script>
</body>
</html>