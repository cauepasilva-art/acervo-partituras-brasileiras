<?php

// Inicia a sessão, caso ainda não esteja iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Limpa todos os dados da sessão
$_SESSION = array();

// Destrói a sessão
session_destroy();

// Redireciona para a página inicial
header("Location: ../index.php");
exit();

?>