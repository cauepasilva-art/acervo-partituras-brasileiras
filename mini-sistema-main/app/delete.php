<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

$mensagem = '';
$confirmacao = false;
$partitura = null;


// =====================================================
// EXCLUSÃO DA PARTITURA
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe o título informado.
    $titulo = trim($_POST['titulo'] ?? '');

    // Verifica se o título foi informado.
    if ($titulo === '') {

        $mensagem = "Informe o nome da partitura.";

    } else {

        // Procura a partitura pelo título.
        $sql = "SELECT *
                FROM partituras
                WHERE LOWER(titulo) = LOWER(:titulo)
                LIMIT 1";

        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':titulo', $titulo);

        $stmt->execute();

        $partitura = $stmt->fetch(PDO::FETCH_ASSOC);


        // Verifica se a partitura foi encontrada.
        if (!$partitura) {

            $mensagem = "Nenhuma partitura encontrada com esse nome.";

        } else {

            // Se ainda não confirmou, mostra a confirmação.
            if (
                !isset($_POST['confirmar']) ||
                $_POST['confirmar'] !== 'sim'
            ) {

                $confirmacao = true;

                $mensagem =
                    'Tem certeza que deseja excluir a partitura "' .
                    htmlspecialchars($partitura['titulo']) .
                    '"?';

            } else {

                // Exclui usando o ID encontrado.
                deletar($conexao, $partitura['id']);

                $mensagem =
                    'A partitura "' .
                    htmlspecialchars($partitura['titulo']) .
                    '" foi excluída com sucesso.';

                $partitura = null;
            }
        }
    }
}

?>


<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <link
        rel="stylesheet"
        href="../style/style.css"
    >

    <title>Excluir Partitura</title>

</head>


<body>

<?php include '../includes/header.php'; ?>


<main>

    <h1>Excluir Partitura</h1>

    <p>
        Informe o nome da partitura que deseja excluir.
    </p>


    <!-- Formulário para procurar a partitura -->

    <form
        action=""
        method="post"
    >

        <label for="titulo">
            Nome da partitura:
        </label>

        <input
            type="text"
            name="titulo"
            id="titulo"
            required
        >

        <br><br>

        <input
            type="submit"
            value="Procurar"
        >

    </form>


    <br>


    <?php if ($mensagem !== ''): ?>

        <p>
            <?= $mensagem ?>
        </p>

    <?php endif; ?>


    <?php if ($confirmacao && $partitura): ?>

        <!-- Formulário de confirmação -->

        <form
            action=""
            method="post"
        >

            <input
                type="hidden"
                name="titulo"
                value="<?= htmlspecialchars($partitura['titulo']) ?>"
            >

            <input
                type="hidden"
                name="confirmar"
                value="sim"
            >

            <button type="submit">
                Sim, excluir
            </button>

        </form>


        <br>


        <a href="/app/delete.php">
            Não, voltar
        </a>

    <?php endif; ?>


    <br>


    <a href="/app/select.php">
        Consultar partituras
    </a>

</main>


<?php include '../includes/footer.php'; ?>

</body>

</html>