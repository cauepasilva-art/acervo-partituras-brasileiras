<?php

require_once __DIR__ . '/../includes/functions.php';

// Verifica se foi informado um ID.
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID da partitura não informado.");
}

$id = (int) $_GET['id'];

// Busca a partitura no banco.
$partitura = consultar($conexao, $id);

// Verifica se a partitura existe.
if (!$partitura) {
    die("Partitura não encontrada.");
}


// =====================================================
// ATUALIZAÇÃO
// =====================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Recebe os dados enviados pelo formulário.
    $titulo = $_POST['titulo'] ?? '';
    $compositor = $_POST['compositor'] ?? '';
    $ano_composicao = $_POST['ano_composicao'] ?? null;
    $genero = $_POST['genero'] ?? '';
    $instrumentacao = $_POST['instrumentacao'] ?? '';
    $tonalidade = $_POST['tonalidade'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $fonte_procedencia = $_POST['fonte_procedencia'] ?? '';
    $situacao_direitos = $_POST['situacao_direitos'] ?? 'pendente';
    $titular_licenca = $_POST['titular_licenca'] ?? '';
    $visivel = isset($_POST['visivel']);


    // Atualiza os dados no banco.
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


    // Volta para a página de detalhes.
    header("Location: /app/detalhe.php?id=" . $id);
    exit;
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

    <title>Atualizar Partitura</title>

    <link
        rel="stylesheet"
        href="../style/style.css"
    >

</head>

<body>

<?php include '../includes/header.php'; ?>


<main>

    <h1>Atualizar Partitura</h1>

    <p>
        Altere os dados da partitura abaixo.
    </p>


    <form method="POST">


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


        <!-- Situação dos direitos -->

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


        <!-- Titular da licença -->

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


        <!-- Botão -->

        <button type="submit">
            Salvar alterações
        </button>


    </form>


    <br>


    <a href="/app/detalhe.php?id=<?= $id ?>">
        Cancelar
    </a>

</main>


<?php include '../includes/footer.php'; ?>

</body>

</html>