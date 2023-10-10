<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$sql_niveis = "SELECT id, nivel FROM niveis ORDER BY id";
$listar_niveis = $pdo->prepare($sql_niveis);
$listar_niveis->execute();

if (($listar_niveis) and ($listar_niveis->rowCount() != 0)) {
    while ($dados = $listar_niveis->fetch(PDO::FETCH_ASSOC)) {
        extract($dados);

        $lista_niveis[$id] = [
            'id' => $id,
            'nivel' => $nivel,
        ];
    }

    http_response_code(200);
    echo json_encode($lista_niveis);
}
