```php
<?php

// Inclui as funções do sistema e a conexão com o banco de dados.
require_once __DIR__ . '/../includes/functions.php';

// Verifica se o ID foi informado na URL e se é numérico.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die('Partitura não encontrada.');
}

// Converte o ID para inteiro.
$id = (int) $_GET['id'];

// Busca a partitura no banco de dados.
$partitura = consultar($conexao, $id);

// Se a partitura não existir, mostra uma mensagem.
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

    <!-- Arquivo de estilos do sistema -->
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<main>

    <h1>Detalhes da Partitura</h1>

    <!-- Caixa com as informações da partitura -->
    <div class="detalhe-partitura">
        <div class="detalhe-preview">

    <iframe
        src="/app/download.php?id=<?= $partitura['id'] ?>"
        title="Prévia do PDF">
    </iframe>

</div>

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

    </div>

    <!-- Ações disponíveis para a partitura -->
    <div class="acoes-detalhe">

        <a
            href="/app/download.php?id=<?= $partitura['id'] ?>"
            target="_blank"
        >
            Abrir PDF
        </a>

        <a href="/app/select.php">
            Voltar para a lista
        </a>

    </div>

</main>

<?php include '../includes/footer.php'; ?>

</body>

</html>
```
