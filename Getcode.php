<?php
    session_start();
    require __DIR__.'/vendor/autoload.php';
    use Kreait\Firebase\ServiceAccount;
    use Kreait\Firebase\Factory;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $statusCode = "";
    $statusMail = "";    
    try {
        $factory = (new Factory())
            ->withServiceAccount('firebaseconfig.json')
            ->withDatabaseUri('https://metodista-database-default-rtdb.firebaseio.com/');
        $database = $factory->createDatabase();
        $tot_count = $database->getReference('Users')->getSnapshot()->numChildren();
        $tmp_name = $_SESSION["tmp_name"];
        $name = $_SESSION["name"]; 
        $nome = $_SESSION["nome"];
        $sobrenome = $_SESSION["sobrenome"];
        $email = $_SESSION["email"];
        $genero = $_SESSION["sexo"];
        $senha = $_SESSION["senha"];
        if (isset($_REQUEST["code"])) { 
            $code = $_REQUEST["code"];  
            $novoUser = [ 
                "id" => $tot_count,
                "nome" => $nome,
                "sobrenome" => $sobrenome,
                "email"=> $email,
                "genero"=>$genero,
                "senha"=>$senha,
                "foto"=>$name
            ];
            if($code == $_COOKIE["codeCount"]){
                $database->getReference('Users/'.$tot_count)->set($novoUser);
                $_SESSION["logado"] = true;
                $_SESSION["nome_completo"] = $nome.' '.$sobrenome;
                $_SESSION["id"] = $tot_count;
                header("Location: AddMembros.php");
            }
            else{
                $statusCode = "Código de abertura de conta incorrecto";
            } 
        }
        $para = "eunicetchihundaikuma@gmail.com";
        $Assunto = "Código de Abertura de conta";
        $mensagem ="
            <html>
                <h2>Igreja Metodista Unida Luis Correia Kizembe</h2>
                <p><b>Código de abertura de conta</b></p>
                <div><center>".$_COOKIE["codeCount"]."</center></div>
                <small> para".$nome." ".$sobrenome."</small>
            </html>";
        $headers = "MIME-Version: 1.0 \n";
        $headers .= "Content-type=text/html; charset=utf-8 \n";
        $headers .= "From: luiskizembe12@gmail.com";
        if (mail($para, $Assunto, $mensagem, $headers)) {
           $statusMail = "Enviado para: eunicetchihundaikuma@gmail.com";
        } else {
            $statusMail = "Erro no envio do código de abertura de conta";
        }

        /*$mail = new PHPMailer(true);
        try {
            // Configurações do servidor
            #$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'mauriciomanuelfinda@gmail.com'; // Usuário SMTP
            $mail->Password = 'aborrecimento'; // Senha SMTP
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465; // Porta TCP para conectar

            // Destinatários
            $mail->setFrom('mauriciomanuelfinda@gmail.com', 'Mauricio Manuel Finda');
            $mail->addAddress('mauriciomanuelfinda@gmail.com', 'Mauricio Manuel Finda');
            $mail->addReplyTo('mauriciomanuelfinda@gmail.com', 'Mauricio Manuel Finda');

            // Conteúdo do E-mail
            $mail->isHTML(true);
            $mail->Subject = '"Código de Abertura de conta";';
            $mail->Body= "
                        <html>
                            <h2>Igreja Metodista Unida Luis Correia Kizembe</h2>
                            <p><b>Código de abertura de conta</b></p>
                            <div><center>".$_COOKIE["codeCount"]."</center></div>
                            <small> para".$nome." ".$sobrenome."</small>
                        </html>";
            $mail->AltBody = 'Este é o corpo da mensagem em texto puro para clientes que não suportam HTML';

            $mail->send();
            echo 'E-mail enviado com sucesso';
        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }*/
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
    if (!isset($_SESSION["novo_user"])) {
        header('Location: cadastro.php');
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <title>Obter o código</title>
</head>
<body> 
    <section id="Getcode">
        <div class="div">
            <p><?php echo $statusCode;?></p>
        </div>
        <img src="img/logo.png" alt="">
        <p><?php echo $statusMail;?></p>
        <form action="" method="post" id="GetcodeForm">
            <div class="all">
                <label for="code">Insira o seu código de abertura</label>
                <input type="text" name="code" id="code" placeholder="XXX-XXX" autocomplete="off" maxlength="7" oninput="inputing()">
                <input type="submit" value="Enviar" >
            </div>
            
        </form>
    </section>
    <script src="Getcode.js"></script>
</body>
</html>