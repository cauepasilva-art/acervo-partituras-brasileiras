<?php

// Arquivo responsável pela conexão com o banco de dados PostgreSQL.
 
$host = "192.168.10.15";
$dbname = "acervo";
$user = "postgres";
$pass = "curry";
try {

    $conexao = new PDO(
        "pgsql:host=$host;dbname=$dbname",
        $user,
        $pass
    );

    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    echo "Erro na conexão com o banco de dados: " . $e->getMessage();

}

?>