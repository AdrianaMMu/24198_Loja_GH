<?php
require "../api/auth.php";

// Verifica se os parâmetros 'email' e 'token' foram enviados via GET na URL
if(isset($_GET["email"]) && isset($_GET["token"])) {
    // Chama a função ativarConta para ativar a conta do usuário com base no email e token recebidos
    ativarConta($_GET["email"], $_GET["token"]);
        
    / Redireciona o usuário para a página de login após a ativação
    header("Location: login.php");
    exit(); // Encerra a execução do script para garantir o redirecionamento imediato
}

?>