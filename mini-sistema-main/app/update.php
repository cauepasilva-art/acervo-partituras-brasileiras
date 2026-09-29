<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

$mensagem = '';
$partitura = null;


// =====================================================
// SALVAR ALTERAÇÕES
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verifica se o formulário está enviando um ID.
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {

        $id = (int) $_POST['id'];

        // Recebe os dados do formulário.
        $titulo = trim($_POST['titulo'] ?? '');
        $compositor = trim($_POST['compositor'] ?? '');
        $ano_composicao = $_POST['ano_composicao'] ?? null;
        $genero = trim($_POST['genero'] ?? '');
        $instrumentacao = trim($_POST['instrumentacao'] ?? '');
        $tonalidade = trim($_POST['tonalidade'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $fonte_procedencia = trim($_POST['fonte_procedencia'] ?? '');
        $situacao_direitos = $_POST['situacao_direitos'] ?? 'pendente';
        $titular_licenca = trim($_POST['titular_licenca'] ?? '');
        $visivel = isset($_POST['visivel']);


        // Atualiza a partitura.
        atualizar(
            $conexao,
            $id,
            $titulo,
            $compositor,
            $ano_composicao,
            $genero,
            $instrumentacao,
            $tonalidade,
            $descricao,
            $fonte_procedencia,
            $situacao_direitos,
            $titular_licenca,
            $visivel
        );


        // Redireciona para os detalhes da partitura.
        header('Location: /app/detalhe.php?id=' . $id);
        exit;
    }


    // =================================================
    // PROCURAR PARTITURA PELO NOME
    // =================================================

    $nome_busca = trim($_POST['nome_busca'] ?? '');

    if ($nome_busca !== '') {

        $sql = "SELECT *
                FROM partituras
                WHERE LOWER(titulo) = LOWER(:titulo)
                LIMIT 1";

        $stmt = $conexao->prepare($sql);

        $stmt->bindParam(':titulo', $nome_busca);

        $stmt->execute();

        $partitura = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!$partitura) {

            $mensagem =
                "Nenhuma partitura encontrada com esse nome.";
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

    <title>Atualizar Partitura</title>

</head>


<body>

<?php include '../includes/header.php'; ?>


<main>

    <h1>Atualizar Partitura</h1>


    <?php if (!$partitura): ?>

        <!-- =========================================
             PESQUISAR PARTITURA
        ========================================== -->

        <p>
            Informe o nome da partitura que deseja atualizar.
        </p>


        <form
            action=""
            method="post"
        >

            <label for="nome_busca">
                Nome da partitura:
            </label>

            <input
                type="text"
                name="nome_busca"
                id="nome_busca"
                required
            >

            <br><br>

            <button type="submit">
                Procurar
            </button>

        </form>


        <?php if ($mensagem !== ''): ?>

            <p>
                <?= htmlspecialchars($mensagem) ?>
            </p>

        <?php endif; ?>


    <?php else: ?>

        <!-- =========================================
             FORMULÁRIO DE ATUALIZAÇÃO
        ========================================== -->

        <p>
            Altere os dados da partitura abaixo.
        </p>


        <form
            action=""
            method="post"
        >

            <!-- ID escondido -->

            <input
                type="hidden"
                name="id"
                value="<?= $partitura['id'] ?>"
            >


            <!-- Título -->

            <label for="titulo">
                Título:
            </label>

            <input
                type="text"
                id="titulo"
                name="titulo"
                value="<?= htmlspecialchars($partitura['titulo']) ?>"
                required
            >

            <br><br>


            <!-- Compositor -->

            <label for="compositor">
                Compositor:
            </label>

            <input
                type="text"
                id="compositor"
                name="compositor"
                value="<?= htmlspecialchars($partitura['compositor']) ?>"
                required
            >

            <br><br>


            <!-- Ano -->

            <label for="ano_composicao">
                Ano de composição:
            </label>

            <input
                type="number"
                id="ano_composicao"
                name="ano_composicao"
                value="<?= htmlspecialchars($partitura['ano_composicao'] ?? '') ?>"
            >

            <br><br>


            <!-- Gênero -->

            <label for="genero">
                Gênero:
            </label>

            <input
                type="text"
                id="genero"
                name="genero"
                value="<?= htmlspecialchars($partitura['genero'] ?? '') ?>"
            >

            <br><br>


            <!-- Instrumentação -->

            <label for="instrumentacao">
                Instrumentação:
            </label>

            <input
                type="text"
                id="instrumentacao"
                name="instrumentacao"
                value="<?= htmlspecialchars($partitura['instrumentacao'] ?? '') ?>"
            >

            <br><br>


            <!-- Tonalidade -->

            <label for="tonalidade">
                Tonalidade:
            </label>

            <input
                type="text"
                id="tonalidade"
                name="tonalidade"
                value="<?= htmlspecialchars($partitura['tonalidade'] ?? '') ?>"
            >

            <br><br>


            <!-- Descrição -->

            <label for="descricao">
                Descrição:
            </label>

            <br>

            <textarea
                id="descricao"
                name="descricao"
                rows="5"
                cols="50"
            ><?= htmlspecialchars($partitura['descricao'] ?? '') ?></textarea>

            <br><br>


            <!-- Fonte -->

            <label for="fonte_procedencia">
                Fonte/Procedência:
            </label>

            <input
                type="text"
                id="fonte_procedencia"
                name="fonte_procedencia"
                value="<?= htmlspecialchars($partitura['fonte_procedencia'] ?? '') ?>"
            >

            <br><br>


            <!-- Direitos -->

            <label for="situacao_direitos">
                Situação dos direitos:
            </label>

            <select
                id="situacao_direitos"
                name="situacao_direitos"
            >

                <option
                    value="dominio_publico"
                    <?= $partitura['situacao_direitos'] === 'dominio_publico' ? 'selected' : '' ?>
                >
                    Domínio público
                </option>

                <option
                    value="licenciado"
                    <?= $partitura['situacao_direitos'] === 'licenciado' ? 'selected' : '' ?>
                >
                    Licenciado
                </option>

                <option
                    value="pendente"
                    <?= $partitura['situacao_direitos'] === 'pendente' ? 'selected' : '' ?>
                >
                    Pendente
                </option>

            </select>

            <br><br>


            <!-- Titular -->

            <label for="titular_licenca">
                Titular da licença:
            </label>

            <input
                type="text"
                id="titular_licenca"
                name="titular_licenca"
                value="<?= htmlspecialchars($partitura['titular_licenca'] ?? '') ?>"
            >

            <br><br>


            <!-- Visibilidade -->

            <label>

                <input
                    type="checkbox"
                    name="visivel"
                    <?= $partitura['visivel'] ? 'checked' : '' ?>
                >

                Partitura visível

            </label>

            <br><br>


            <button type="submit">
                Salvar alterações
            </button>

        </form>


        <br>


        <a href="/app/update.php">
            Escolher outra partitura
        </a>

    <?php endif; ?>

</main>


<?php include '../includes/footer.php'; ?>

</body>

</html>