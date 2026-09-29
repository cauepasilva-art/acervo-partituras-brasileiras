<?php

require 'includes/functions.php';

$stmt = $conexao->query("SELECT COUNT(*) FROM partituras");

$total = $stmt->fetchColumn();

echo "Total de partituras: " . $total . PHP_EOL;

$stmt = $conexao->query("
    SELECT
        id,
        titulo,
        compositor,
        nome_arquivo_original,
        caminho_arquivo
    FROM partituras
    ORDER BY id DESC
");

$partituras = $stmt->fetchAll(PDO::FETCH_ASSOC);

print_r($partituras);