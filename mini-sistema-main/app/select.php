<?php

require_once __DIR__ . '/../includes/functions.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lista de Partituras</title>

    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

<?php include '../includes/header.php'; ?>

<main>

    <h1>Lista de Partituras</h1>

    <p>
        Confira as partituras cadastradas no acervo.
    </p>

    <?php listar($conexao); ?>

</main>

<?php include '../includes/footer.php'; ?>

</body>

</html>