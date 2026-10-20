
<?php

require_once __DIR__ . '/../includes/functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $usuario = consulta_user($conexao, $email);

    if (
        $usuario &&
        password_verify($senha, $usuario['senha_hash'])
    ) {
        // Renova o identificador da sessão após o login.
        session_regenerate_id(true);

        // Guarda os dados do usuário.
        $_SESSION['id'] = $usuario['id'];
        $_SESSION['email'] = $usuario['email'];

        // Identifica se o usuário é administrador.
        $valorAdmin = $usuario['eh_admin'] ?? false;

        $_SESSION['eh_admin'] =
            $valorAdmin === true ||
            $valorAdmin === 1 ||
            in_array(
                strtolower(trim((string) $valorAdmin)),
                ['1', 't', 'true', 'yes'],
                true
            );

        // Redireciona para a página inicial.
        header('Location: ../index.php');
        exit();
    }

    $erro = 'E-mail ou senha inválidos.';
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <title>Login</title>
</head>
<body>

    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main>
        <h1>Faça seu login</h1>

        <?php if ($erro !== ''): ?>
            <p>
                <?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form action="" method="POST">
            <label for="email">E-mail:</label>
            <input
                type="email"
                name="email"
                id="email"
                required
                autocomplete="email"
            >

            <br>

            <label for="senha">Senha:</label>
            <input
                type="password"
                name="senha"
                id="senha"
                required
                autocomplete="current-password"
            >

            <br>

            <input type="submit" value="Entrar">

            <p>
                Não possui uma conta?
                <a href="cadastrar.php">Cadastre-se</a>
            </p>
        </form>
    </main>

    <?php include __DIR__ . '/../includes/footer.php'; ?>

</body>
</html>
