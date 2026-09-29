<?php
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../login/verifica_user.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Consulta de Partitura</title>
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <h3>Consulta de Partitura</h3>

    <form action="" method="post">

        <label for="id">Partitura ID</label>
        <input type="text" name="id" id="id" required>

        <input type="submit" value="Consultar">

    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $partitura = consultar($conexao, $_POST['id']);

        if ($partitura) {

            echo "<hr>";
            echo "ID: " . $partitura['id'] . "<br>";
            echo "Título: " . $partitura['titulo'] . "<br>";
            echo "Compositor: " . $partitura['compositor'] . "<br>";
            echo "Ano: " . $partitura['ano_composicao'] . "<br>";
            echo "Gênero: " . $partitura['genero'] . "<br>";
            echo "Instrumentação: " . $partitura['instrumentacao'] . "<br>";
            echo "Tonalidade: " . $partitura['tonalidade'] . "<br>";
            echo "Descrição: " . $partitura['descricao'] . "<br>";
            echo "Fonte / Procedência: " . $partitura['fonte_procedencia'] . "<br>";
            echo "Situação dos direitos: " . $partitura['situacao_direitos'] . "<br>";
            echo "Titular da licença: " . $partitura['titular_licenca'] . "<br>";
            echo "Visível: " . ($partitura['visivel'] ? 'Sim' : 'Não') . "<br>";

        } else {

            echo "Partitura não encontrada.";

        }
    }

    include '../includes/footer.php';

    ?>

</body>

</html>