<?php

require_once __DIR__ . '/../includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Partitura não encontrada.');
}

$id = (int) $_GET['id'];

$partitura = consultar($conexao, $id);

if (!$partitura) {
    die('Partitura não encontrada.');
}

// Pega somente o nome do arquivo salvo no banco
$nome_arquivo = basename($partitura['caminho_arquivo']);

// Monta o caminho físico correto
$caminho = __DIR__ . '/../uploads/' . $nome_arquivo;

if (!file_exists($caminho)) {
    die('Arquivo da partitura não encontrado.');
}

header('Content-Type: ' . $partitura['mime_type']);

header(
    'Content-Disposition: inline; filename="' .
    basename($partitura['nome_arquivo_original']) .
    '"'
);

header('Content-Length: ' . filesize($caminho));

readfile($caminho);

exit;