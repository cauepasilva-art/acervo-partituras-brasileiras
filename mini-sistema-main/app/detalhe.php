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

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalhes da Partitura</title>

    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<?php include '../includes/header.php'; ?>

<main>

    <h1>Detalhes da Partitura</h1>

    <hr>

    <p>
        <strong>ID:</strong>
        <?= htmlspecialchars($partitura['id']) ?>
    </p>

    <p>
        <strong>Título:</strong>
        <?= htmlspecialchars($partitura['titulo']) ?>
    </p>

    <p>
        <strong>Compositor:</strong>
        <?= htmlspecialchars($partitura['compositor']) ?>
    </p>

    <p>
        <strong>Ano de composição:</strong>
        <?= htmlspecialchars($partitura['ano_composicao'] ?? '') ?>
    </p>

    <p>
        <strong>Gênero:</strong>
        <?= htmlspecialchars($partitura['genero']) ?>
    </p>

    <p>
        <strong>Instrumentação:</strong>
        <?= htmlspecialchars($partitura['instrumentacao']) ?>
    </p>

    <p>
        <strong>Tonalidade:</strong>
        <?= htmlspecialchars($partitura['tonalidade']) ?>
    </p>

    <p>
        <strong>Descrição:</strong>
        <?= nl2br(htmlspecialchars($partitura['descricao'])) ?>
    </p>

    <p>
        <strong>Fonte/Procedência:</strong>
        <?= htmlspecialchars($partitura['fonte_procedencia']) ?>
    </p>

    <p>
        <strong>Situação dos direitos:</strong>
        <?= htmlspecialchars($partitura['situacao_direitos']) ?>
    </p>

    <p>
        <strong>Titular da licença:</strong>
        <?= htmlspecialchars($partitura['titular_licenca']) ?>
    </p>

    <p>
        <strong>Arquivo:</strong>
        <?= htmlspecialchars($partitura['nome_arquivo_original']) ?>
    </p>

    <p>
        <strong>Tipo do arquivo:</strong>
        <?= htmlspecialchars($partitura['mime_type']) ?>
    </p>

    <p>
        <strong>Tamanho:</strong>
        <?= htmlspecialchars($partitura['tamanho_bytes']) ?> bytes
    </p>

    <p>
        <strong>Visível:</strong>
        <?= $partitura['visivel'] ? 'Sim' : 'Não' ?>
    </p>

    <hr>

    <p>
        <a
            href="/app/download.php?id=<?= $partitura['id'] ?>"
            target="_blank"
        >
            Abrir PDF
        </a>
    </p>

    <p>
        <a href="/app/select.php">
            Voltar para a lista
        </a>
    </p>

</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>