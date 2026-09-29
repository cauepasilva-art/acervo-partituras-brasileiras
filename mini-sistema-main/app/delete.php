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

    <title>Excluir Partitura</title>

</head>

<body>

    <?php include '../includes/header.php'; ?>

    <h1>Excluir Partitura</h1>

    <form action="" method="post">

        <label for="id">ID da partitura:</label>

        <input type="number" name="id" id="id" required>

        <input type="submit" value="Excluir">

    </form>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        deletar($conexao, $_POST['id']);

    }

    ?>

    <br>

    <a href="select.php">Consultar partituras</a>

    <?php include '../includes/footer.php'; ?>

</body>

</html>