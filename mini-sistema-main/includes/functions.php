<?php

require_once __DIR__ . '/../database/connect.php';

/*
 * Funções para o Acervo Digital de Partituras Brasileiras
 */

// =====================================================
// CADASTRAR PARTITURA
// =====================================================

function cadastrar(
    $conexao,
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
    $visivel,
    $criado_por,
    $nome_arquivo_original,
    $caminho_arquivo,
    $mime_type,
    $tamanho_bytes
) {
    $sql = "INSERT INTO partituras (
                titulo,
                compositor,
                ano_composicao,
                genero,
                instrumentacao,
                tonalidade,
                descricao,
                fonte_procedencia,
                situacao_direitos,
                titular_licenca,
                visivel,
                criado_por,
                nome_arquivo_original,
                caminho_arquivo,
                mime_type,
                tamanho_bytes
            ) VALUES (
                :titulo,
                :compositor,
                :ano_composicao,
                :genero,
                :instrumentacao,
                :tonalidade,
                :descricao,
                :fonte_procedencia,
                :situacao_direitos,
                :titular_licenca,
                :visivel,
                :criado_por,
                :nome_arquivo_original,
                :caminho_arquivo,
                :mime_type,
                :tamanho_bytes
            )";

    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':compositor', $compositor);
    $stmt->bindParam(':ano_composicao', $ano_composicao);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':instrumentacao', $instrumentacao);
    $stmt->bindParam(':tonalidade', $tonalidade);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':fonte_procedencia', $fonte_procedencia);
    $stmt->bindParam(':situacao_direitos', $situacao_direitos);
    $stmt->bindParam(':titular_licenca', $titular_licenca);
    $stmt->bindParam(':visivel', $visivel, PDO::PARAM_BOOL);
    $stmt->bindParam(':criado_por', $criado_por);
    $stmt->bindParam(':nome_arquivo_original', $nome_arquivo_original);
    $stmt->bindParam(':caminho_arquivo', $caminho_arquivo);
    $stmt->bindParam(':mime_type', $mime_type);
    $stmt->bindParam(':tamanho_bytes', $tamanho_bytes);

    $stmt->execute();

    echo "Partitura cadastrada com sucesso!";
}


// =====================================================
// DELETAR PARTITURA
// =====================================================

function deletar($conexao, $id)
{
    $sql = "DELETE FROM partituras WHERE id = :id";

    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    echo "Registro deletado.";
}


// =====================================================
// LISTAR PARTITURAS
// =====================================================

function listar($conexao)
{
    $sql = "SELECT * FROM partituras ORDER BY id DESC";

    $stmt = $conexao->prepare($sql);
    $stmt->execute();

    $partituras = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($partituras as $partitura) {

        echo "<hr>";

        echo "ID: " . htmlspecialchars($partitura['id']) . "<br>";
        echo "Título: " . htmlspecialchars($partitura['titulo']) . "<br>";
        echo "Compositor: " . htmlspecialchars($partitura['compositor']) . "<br>";
        echo "Ano: " . htmlspecialchars($partitura['ano_composicao'] ?? '') . "<br>";
        echo "Gênero: " . htmlspecialchars($partitura['genero']) . "<br>";
        echo "Instrumentação: " . htmlspecialchars($partitura['instrumentacao']) . "<br>";
        echo "Tonalidade: " . htmlspecialchars($partitura['tonalidade']) . "<br>";
        echo "Descrição: " . htmlspecialchars($partitura['descricao']) . "<br>";
        echo "Fonte/Procedência: " . htmlspecialchars($partitura['fonte_procedencia']) . "<br>";
        echo "Situação dos direitos: " . htmlspecialchars($partitura['situacao_direitos']) . "<br>";
        echo "Titular da licença: " . htmlspecialchars($partitura['titular_licenca']) . "<br>";

        echo "Arquivo original: " . htmlspecialchars($partitura['nome_arquivo_original']) . "<br>";
        echo "Tipo do arquivo: " . htmlspecialchars($partitura['mime_type']) . "<br>";
        echo "Tamanho: " . htmlspecialchars($partitura['tamanho_bytes']) . " bytes<br>";

        echo "Visível: " .
            ($partitura['visivel'] ? 'Sim' : 'Não') .
            "<br>";

        echo "<br>";

        echo '<a href="/app/detalhe.php?id=' . $partitura['id'] . '">
                Ver detalhes
              </a>';

        echo " | ";

        echo '<a href="/app/download.php?id=' . $partitura['id'] . '" target="_blank">
                Abrir PDF
              </a>';

        echo "<br>";
    }
}
// =====================================================
// CONSULTAR PARTITURA POR ID
// =====================================================

function consultar($conexao, $id)
{
    $sql = "SELECT *
            FROM partituras
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':id', $id);
    $stmt->execute();

    $partitura = $stmt->fetch(PDO::FETCH_ASSOC);

    return $partitura;
}


// =====================================================
// ATUALIZAR PARTITURA
// =====================================================

function atualizar(
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
) {
    $sql = "UPDATE partituras SET
                titulo = :titulo,
                compositor = :compositor,
                ano_composicao = :ano_composicao,
                genero = :genero,
                instrumentacao = :instrumentacao,
                tonalidade = :tonalidade,
                descricao = :descricao,
                fonte_procedencia = :fonte_procedencia,
                situacao_direitos = :situacao_direitos,
                titular_licenca = :titular_licenca,
                visivel = :visivel,
                atualizado_em = NOW()
            WHERE id = :id";

    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':compositor', $compositor);
    $stmt->bindParam(':ano_composicao', $ano_composicao);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':instrumentacao', $instrumentacao);
    $stmt->bindParam(':tonalidade', $tonalidade);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':fonte_procedencia', $fonte_procedencia);
    $stmt->bindParam(':situacao_direitos', $situacao_direitos);
    $stmt->bindParam(':titular_licenca', $titular_licenca);
    $stmt->bindParam(':visivel', $visivel, PDO::PARAM_BOOL);
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}


// =====================================================
// CADASTRAR USUÁRIO
// =====================================================

function cadastrar_user($conexao, $email, $senha)
{
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (email, senha_hash)
            VALUES (:email, :senha_hash)";

    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha_hash', $senha_hash);

    $stmt->execute();

    echo "Usuário cadastrado com sucesso!";
}


// =====================================================
// CONSULTAR USUÁRIO
// =====================================================

function consulta_user($conexao, $email)
{
    $sql = "SELECT id, email, senha_hash
            FROM usuarios
            WHERE email = :email";

    $stmt = $conexao->prepare($sql);

    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    return $usuario;
}

?>