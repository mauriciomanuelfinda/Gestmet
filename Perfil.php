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
        $id = $_SESSION["id"];
        if (!isset($_SESSION["logado"])) {
            header("Location: login.php");
        }
        $user = $database->getReference('Users/'.$id)->getSnapshot()->getValue();
    } catch (Exception $ex) {
        echo ex->getMessage();
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Meu Perfil</title>
</head>
<body>
    <section id="Perfil">
        <div class="img">
            <h2>Meu Perfil</h2>
            <?php 
                if ($_SESSION["name"]!="") {
                    echo '<img src="img/'.$_SESSION["name"].'" alt="Foto de Perfil">';
                } else {
                    echo '<img src="img/images.png" alt="Foto de Perfil">';
                }
            ?>
        </div>
        <div class="main">
            <div class="all">
                <label for="">Nome</label>
                <label for="">Sobrenome</label>
                <label for="">Email</label>
                <label for="">Género</label>
            </div>
            <div class="all">
                <p><?php echo $user["nome"]?></p>
                <p><?php echo $user["sobrenome"]?></p>
                <p><?php echo $user["email"]?></p>
                <p><?php echo $user["genero"]?></p>
            </div>
        </div>
        <div class="main1">
            <label for="">Nome</label>
            <p><?php echo $user["nome"]?></p>
            <label for="">Sobrenome</label>
            <p><?php echo $user["sobrenome"]?></p>
            <label for="">Email</label>
            <p><?php echo $user["email"]?></p>
            <label for="">Género</label>
            <p><?php echo $user["genero"]?></p>
        </div>
        <a href="EditarPerfil.php">Editar Perfil</a>
    </section>
</body>
</html>