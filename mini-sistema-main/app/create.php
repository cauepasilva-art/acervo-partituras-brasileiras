<?php

require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Cadastrar Partitura</title>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <h1>Cadastrar Partitura</h1>

    <form action="" method="POST" enctype="multipart/form-data">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" id="titulo" required>
        <br>

        <label for="compositor">Compositor:</label>
        <input type="text" name="compositor" id="compositor" required>
        <br>

        <label for="ano_composicao">Ano de composição:</label>
        <input type="number" name="ano_composicao" id="ano_composicao" min="1000" max="2100">
        <br>

        <label for="genero">Gênero:</label>
        <input type="text" name="genero" id="genero">
        <br>

        <label for="instrumentacao">Instrumentação:</label>
        <textarea name="instrumentacao" id="instrumentacao"></textarea>
        <br>

        <label for="tonalidade">Tonalidade:</label>
        <input type="text" name="tonalidade" id="tonalidade">
        <br>

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea>
        <br>

        <label for="fonte_procedencia">Fonte / Procedência:</label>
        <textarea name="fonte_procedencia" id="fonte_procedencia"></textarea>
        <br>

        <label for="situacao_direitos">Situação dos direitos:</label>
        <select name="situacao_direitos" id="situacao_direitos" required>
            <option value="pendente">Pendente</option>
            <option value="dominio_publico">Domínio público</option>
            <option value="licenca_autorizada">Licença autorizada</option>
            <option value="restrito">Restrito</option>
            <option value="desconhecido">Desconhecido</option>
        </select>
        <br>

        <label for="titular_licenca">Titular da licença:</label>
        <input type="text" name="titular_licenca" id="titular_licenca">
        <br>

        <label for="arquivo">Arquivo da partitura (PDF):</label>
        <input type="file" name="arquivo" id="arquivo" accept="application/pdf" required>
        <br>

        <label>Visível?</label>

        <input type="radio" name="visivel" id="sim" value="1" checked>
        <label for="sim">SIM</label>

        <input type="radio" name="visivel" id="nao" value="0">
        <label for="nao">NÃO</label>

        <br><br>

        <input type="reset" value="Limpar">
        <input type="submit" value="Cadastrar">

    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $arquivo = $_FILES['arquivo'];

        // Verifica se houve erro no envio
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            die('Erro ao enviar o arquivo.');
        }

        // Nome original do arquivo
        $nome_arquivo_original = $arquivo['name'];

        // Tipo MIME informado pelo navegador
        $mime_type = $arquivo['type'];

        // Tamanho do arquivo
        $tamanho_bytes = $arquivo['size'];

        // Verifica a extensão
        $extensao = strtolower(
            pathinfo($nome_arquivo_original, PATHINFO_EXTENSION)
        );

        if ($extensao !== 'pdf') {
            die('Erro: apenas arquivos PDF são permitidos.');
        }

        // Gera um nome único para o arquivo armazenado
        $nome_arquivo = uniqid('partitura_', true) . '.pdf';

        // Caminho que será salvo no banco
        $caminho_arquivo = '../uploads/' . $nome_arquivo;

        // Caminho físico no computador
        $caminho_fisico = __DIR__ . '/../uploads/' . $nome_arquivo;

        // Move o arquivo para a pasta uploads
        if (!move_uploaded_file($arquivo['tmp_name'], $caminho_fisico)) {
            die('Erro ao salvar o arquivo da partitura.');
        }

        // Cadastra os dados no banco
        cadastrar(
            $conexao,
            $_POST['titulo'],
            $_POST['compositor'],
            $_POST['ano_composicao'] !== '' ? $_POST['ano_composicao'] : null,
            $_POST['genero'],
            $_POST['instrumentacao'],
            $_POST['tonalidade'],
            $_POST['descricao'],
            $_POST['fonte_procedencia'],
            $_POST['situacao_direitos'],
            $_POST['titular_licenca'],
            $_POST['visivel'] === '1',
            $_SESSION['id'] ?? null,
            $nome_arquivo_original,
            $caminho_arquivo,
            $mime_type,
            $tamanho_bytes
        );
    }

    include '../includes/footer.php';

    ?>

</body>

</html>