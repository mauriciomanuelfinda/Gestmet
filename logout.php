<?php
    session_start();
    unset($_SESSION["tmp_name"]);
    unset($_SESSION["name"]);
    unset($_SESSION["type"]);
    unset($_SESSION["nome"]);
    unset($_SESSION["sobrenome"]);
    unset($_SESSION["email"]);
    unset($_SESSION["sexo"]);
    unset($_SESSION["senha"]);
    unset($_SESSION["logado"]);
    unset($_SESSION["nome_completo"]);
    unset($_SESSION["id"]);
    unset($_SESSION["novo_user"]);

    header("Location: login.php");



?>