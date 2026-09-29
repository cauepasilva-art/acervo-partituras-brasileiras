<?php

require_once __DIR__ . '/../includes/functions.php';

$resultados = [];

$termo = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['termo'])) {

    $termo = trim($_GET['termo']);

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

        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buscar Partituras</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<main>

    <h1>Buscar Partituras</h1>

    <form method="GET" action="">

        <label for="termo">
            Título ou compositor:
        </label>

        <input
            type="text"
            name="termo"
            id="termo"
            value="<?= htmlspecialchars($termo) ?>"
            placeholder="Digite o título ou compositor"
        >

        <input
            type="submit"
            value="Pesquisar"
        >

    </form>

    <hr>

    <?php if ($termo !== ''): ?>

        <h2>
            Resultados para:
            <?= htmlspecialchars($termo) ?>
        </h2>

        <?php if (count($resultados) > 0): ?>

            <?php foreach ($resultados as $partitura): ?>

                <div>

                    <h3>
                        <?= htmlspecialchars($partitura['titulo']) ?>
                    </h3>

                    <p>
                        <strong>Compositor:</strong>
                        <?= htmlspecialchars($partitura['compositor']) ?>
                    </p>

                    <p>
                        <strong>Ano:</strong>
                        <?= htmlspecialchars($partitura['ano_composicao'] ?? '') ?>
                    </p>

                    <p>
                        <strong>Gênero:</strong>
                        <?= htmlspecialchars($partitura['genero']) ?>
                    </p>

                    <p>
                        <a href="/app/detalhe.php?id=<?= $partitura['id'] ?>">
                            Ver detalhes
                        </a>

                        |

                        <a
                            href="/app/download.php?id=<?= $partitura['id'] ?>"
                            target="_blank"
                        >
                            Abrir PDF
                        </a>
                    </p>

                </div>

                <hr>

            <?php endforeach; ?>

        <?php else: ?>

            <p>
                Nenhuma partitura encontrada.
            </p>

        <?php endif; ?>

    <?php else: ?>

        <p>
            Digite um título ou compositor para realizar a pesquisa.
        </p>

    <?php endif; ?>

</main>

<?php include '../includes/footer.php'; ?>

</body>

</html>