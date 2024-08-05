<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;     
    $_SESSION["status_login"] = ""; 
    $factory = (new Factory())
        ->withServiceAccount('firebaseconfig.json')
        ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
    $database = $factory->createDatabase();
    $logado = false;
    if (isset($_REQUEST["email"])) {
        $email = $_REQUEST["email"];
        $senha = $_REQUEST["senha"];
        $users = $database->getReference('Users')->getSnapshot();
        foreach($users->getValue() as $user){
            if ($user["email"] == $email && $user["senha"] == $senha) {
                $_SESSION["id"] = $user["id"];
                $_SESSION["nome_completo"] = $user["nome"].' '.$user["sobrenome"];
                $_SESSION["name"] = $user["foto"];
                $_SESSION["logado"] = true;
                $logado = true;
                break;
            }
            else{
                $_SESSION["status_login"] = "Administrador não cadastrado";
            }
        }
        if ($logado) {
            header("Location: AddMembros.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Login</title>
</head>
<body class="BodyLogin">
    <div id="Erro">
        <p><?php echo $_SESSION["status_login"]?></p>
    </div>
    <section id="Login">
        <form action="" method="post" id="formLogin">
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" autocomplete="off">
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" autocomplete="off">
            <a href="EsqSenha.php" class="EsqSenha">Esqueci a minha senha</a>
            <input type="submit" value="Entrar">
            <a href="cadastro.php">Tens uma conta? Criar Conta</a>
        </form>
    </section>
    <script src="login.js"></script>
</body>
</html>