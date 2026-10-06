<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./style/style.css">

    <title>Acervo Digital de Partituras Brasileiras</title>

</head>

<body>

    <?php include './includes/header.php'; ?>

    <main>

        <h1>Acervo Digital de Partituras Brasileiras</h1>

        <p>Bem-vindo ao acervo de partituras brasileiras.</p>

        <p>
            Aqui você pode cadastrar, consultar, atualizar e excluir partituras.
        </p>

        <p>
            <a href="./app/create.php">Cadastrar partitura</a>
        </p>

        <p>
            <a href="./app/select.php">Ver partituras</a>
        </p>

        <p>
            <a href="./app/select_where.php">Pesquisar partitura</a>
        </p>

        <p>
            <a href="./app/update.php">Atualizar partitura</a>
        </p>

        <p>
            <a href="./app/delete.php">Excluir partitura</a>
        </p>

    </main>

    <?php include './includes/footer.php'; ?>

</body>

</html>