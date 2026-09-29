<?php

// Importa o arquivo functions.php.
// Esse arquivo contém a conexão com o banco e as funções
// utilizadas pelo sistema.
require_once __DIR__ . '/../includes/functions.php';


// Cria um array vazio para armazenar os resultados da busca.
$resultados = [];


// Guarda o termo que foi digitado pelo usuário.
// Inicialmente, ele fica vazio.
$termo = '';


// Verifica se o formulário foi enviado pelo método GET
// e se existe o parâmetro "termo" na URL.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['termo'])) {

    // trim() remove espaços desnecessários no começo e no final
    // do texto digitado pelo usuário.
    $termo = trim($_GET['termo']);


    // Verifica se o usuário realmente digitou alguma coisa.
    if ($termo !== '') {

        // SQL responsável pela pesquisa.
        //
        // ILIKE permite pesquisar sem diferenciar letras maiúsculas
        // de letras minúsculas.
        //
        // A pesquisa será feita em dois campos:
        // - titulo
        // - compositor
        //
        // O OR significa que basta o termo aparecer em um dos dois
        // campos para a partitura ser encontrada.
        $sql = "SELECT *
                FROM partituras
                WHERE titulo ILIKE :termo
                   OR compositor ILIKE :termo
                ORDER BY titulo ASC";


        // Prepara a consulta SQL antes de executá-la.
        //
        // Isso também ajuda a proteger o sistema contra
        // SQL Injection.
        $stmt = $conexao->prepare($sql);


        // Coloca "%" antes e depois do termo pesquisado.
        //
        // Por exemplo:
        // Se o usuário pesquisar "Aquarela",
        // o banco receberá "%Aquarela%".
        //
        // Assim, ele poderá encontrar:
        // "Aquarela do Brasil"
        //
        // e não somente um título exatamente igual a "Aquarela".
        $busca = '%' . $termo . '%';


        // Substitui o parâmetro :termo pelo valor pesquisado.
        $stmt->bindParam(':termo', $busca);


        // Executa a consulta no banco de dados.
        $stmt->execute();


        // Pega todos os resultados encontrados.
        //
        // PDO::FETCH_ASSOC faz com que cada resultado
        // seja retornado como um array associativo.
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

<!DOCTYPE html>

<!-- Define que o documento utiliza HTML5. -->
<html lang="pt-BR">

<head>

    <!-- Define a codificação dos caracteres.
         UTF-8 permite utilizar acentos normalmente. -->
    <meta charset="UTF-8">


    <!-- Faz a página se adaptar a diferentes tamanhos de tela. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Texto que aparece na aba do navegador. -->
    <title>Buscar Partituras</title>


    <!-- Importa o arquivo de estilos CSS do projeto. -->
    <link rel="stylesheet" href="../style/style.css">

</head>

<body>

<!-- Inclui o cabeçalho padrão do sistema. -->
<?php include '../includes/header.php'; ?>


<main>

    <!-- Título principal da página. -->
    <h1>Buscar Partituras</h1>


    <!--
        Formulário responsável pela pesquisa.

        method="GET" significa que o termo pesquisado
        será enviado pela URL.
    -->
    <form method="GET" action="">


        <!-- Texto que identifica o campo de pesquisa. -->
        <label for="termo">
            Título ou compositor:
        </label>


        <!--
            Campo onde o usuário digita sua pesquisa.

            name="termo":
            É o nome usado pelo PHP para acessar
            o valor através de $_GET['termo'].

            value:
            Mantém o texto pesquisado aparecendo
            no campo depois da pesquisa.

            htmlspecialchars():
            Protege a página contra a interpretação
            de HTML inserido no campo.
        -->
        <input
            type="text"
            name="termo"
            id="termo"
            value="<?= htmlspecialchars($termo) ?>"
            placeholder="Digite o título ou compositor"
        >


        <!-- Botão que envia o formulário. -->
        <input
            type="submit"
            value="Pesquisar"
        >

    </form>


    <!-- Linha horizontal para separar o formulário dos resultados. -->
    <hr>


    <?php if ($termo !== ''): ?>

        <!--
            Só mostra esta parte se o usuário
            tiver realizado uma pesquisa.
        -->

        <h2>

            <!-- Mostra o termo pesquisado. -->
            Resultados para:

            <?= htmlspecialchars($termo) ?>

        </h2>


        <?php if (count($resultados) > 0): ?>

            <!--
                Verifica se a pesquisa encontrou
                pelo menos uma partitura.
            -->

            <?php foreach ($resultados as $partitura): ?>

                <!--
                    Percorre cada partitura encontrada
                    e cria uma seção para ela.
                -->
                <div>


                    <!-- Mostra o título da partitura. -->
                    <h3>
                        <?= htmlspecialchars($partitura['titulo']) ?>
                    </h3>


                    <!-- Mostra o compositor. -->
                    <p>

                        <strong>Compositor:</strong>

                        <?= htmlspecialchars($partitura['compositor']) ?>

                    </p>


                    <!-- Mostra o ano da composição. -->
                    <p>

                        <strong>Ano:</strong>

                        <?= htmlspecialchars(
                            $partitura['ano_composicao'] ?? ''
                        ) ?>

                    </p>


                    <!-- Mostra o gênero musical. -->
                    <p>

                        <strong>Gênero:</strong>

                        <?= htmlspecialchars($partitura['genero']) ?>

                    </p>


                    <p>

                        <!--
                            Link para a página de detalhes.

                            O ID da partitura é enviado pela URL.
                            Exemplo:
                            /app/detalhe.php?id=3
                        -->
                        <a
                            href="/app/detalhe.php?id=<?= $partitura['id'] ?>"
                        >
                            Ver detalhes
                        </a>


                        |


                        <!--
                            Link para abrir o PDF.

                            target="_blank" faz o PDF abrir
                            em uma nova aba do navegador.
                        -->
                        <a
                            href="/app/download.php?id=<?= $partitura['id'] ?>"
                            target="_blank"
                        >
                            Abrir PDF
                        </a>

                    </p>

                </div>


                <!-- Separa uma partitura da outra. -->
                <hr>


            <?php endforeach; ?>


        <?php else: ?>

            <!--
                Se a pesquisa não encontrou nenhuma partitura,
                mostra esta mensagem.
            -->
            <p>
                Nenhuma partitura encontrada.
            </p>


        <?php endif; ?>


    <?php else: ?>

        <!--
            Essa mensagem aparece quando o usuário
            ainda não digitou nenhum termo de pesquisa.
        -->
        <p>
            Digite um título ou compositor para realizar a pesquisa.
        </p>


    <?php endif; ?>

</main>


<!-- Inclui o rodapé padrão do sistema. -->
<?php include '../includes/footer.php'; ?>


</body>

</html>