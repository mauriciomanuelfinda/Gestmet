<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    $status = "";
    if (isset($_REQUEST["email"])) {
        $logado = false;
        $email = $_REQUEST["email"];
        $factory = (new Factory())
            ->withServiceAccount('firebaseconfig.json')
            ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $users = $database->getReference('Users')->getSnapshot();
        foreach ($users as $user) {
            if ($user["email"] == $email) {
                $_SESSION["name"]= $user["name"];
                $_SESSION["nome_completo"]=$user["nome"].' '.$user["sobrenome"];
                $_SESSION["id"]=$user["id"];
                $_SESSION["logado"] = true;
                $logado = true;
                break;
            }
        }
        if ($logado) {
            header("Location: AddMembros.php");
        }
        else{
            $status = "O seu email não está cadastro";
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
    <title>Esqueci a minha senha</title>
</head>
<body>
    <div id="Erro">
        <p><?php echo $status?></p>
    </div>
    <section id="EsqSenha">
        <img src="img/logo.png" alt="">
        <form action="" method="post" id="EsqSenhaForm" >
            <div class="all">
                <label for="email">Insira o seu email</label>
                <input type="email" name="email" id="email" placeholder="xxxxxxxx@xxx.com" autocomplete="off">
                <input type="submit" value="Enviar">
            </div>
        </form>
    </section>
    <script src="EsqSenha.js"></script>
</body>
</html>