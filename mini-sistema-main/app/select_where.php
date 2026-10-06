<?php
require_once __DIR__ . '/../includes/functions.php';

$termo = '';

if (isset($_GET['termo'])) {
    $termo = trim($_GET['termo']);
}

$partituras = [];

if ($termo !== '') {

    $sql = "SELECT *
            FROM partituras
            WHERE titulo ILIKE :termo
               OR compositor ILIKE :termo
            ORDER BY titulo ASC";

    $stmt = $conexao->prepare($sql);

    $busca = '%' . $termo . '%';

    $stmt->bindParam(':termo', $busca);
    $stmt->execute();

    $partituras = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pesquisar Partituras</title>

    <link rel="stylesheet" href="../style/style.css">
</head>

<body>

<?php include '../includes/header.php'; ?>

<main>

    <h1>Pesquisar Partituras</h1>

    <form method="GET" class="form-pesquisa">

        <input
            type="text"
            name="termo"
            placeholder="Digite o título ou compositor"
            value="<?= htmlspecialchars($termo) ?>"
        >

        <button type="submit">
            Pesquisar
        </button>

    </form>

    <?php if ($termo !== ''): ?>

        <h2>Resultados da pesquisa</h2>

        <?php if (count($partituras) === 0): ?>

            <p>Nenhuma partitura encontrada.</p>

        <?php else: ?>

            <?php foreach ($partituras as $partitura): ?>

                <div class="partitura-item">

                    <div class="partitura-preview">

                        <iframe
                            src="/app/download.php?id=<?= $partitura['id'] ?>"
                            title="Prévia do PDF">
                        </iframe>

                    </div>

                    <div class="partitura-info">

                        <h2>
                            <?= htmlspecialchars($partitura['titulo']) ?>
                        </h2>

                        <p>
                            <strong>Compositor:</strong>
                            <?= htmlspecialchars($partitura['compositor']) ?>
                        </p>

                        <?php if ($partitura['ano_composicao'] !== null): ?>

                            <p>
                                <strong>Ano:</strong>
                                <?= htmlspecialchars($partitura['ano_composicao']) ?>
                            </p>

                        <?php endif; ?>

                        <?php if (!empty($partitura['genero'])): ?>

                            <p>
                                <strong>Gênero:</strong>
                                <?= htmlspecialchars($partitura['genero']) ?>
                            </p>

                        <?php endif; ?>

                        <div class="partitura-acoes">

                            <a href="/app/detalhe.php?id=<?= $partitura['id'] ?>">
                                Ver detalhes
                            </a>

                            <a
                                href="/app/download.php?id=<?= $partitura['id'] ?>"
                                target="_blank">
                                Abrir PDF
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    <?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>

</body>
</html>