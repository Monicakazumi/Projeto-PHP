<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

require 'config.php';

$resposta_json = file_get_contents("php://input");
$dados = json_decode($resposta_json, true);

if ($dados) {

    $sql_niveis = "UPDATE niveis SET nivel = :nivel WHERE id = :id";
    $editar_niveis = $pdo->prepare($sql_niveis);
    $editar_niveis->bindParam(':id', $dados['id'], PDO::PARAM_INT);
    $editar_niveis->bindParam(':nivel', $dados['nivel'], PDO::PARAM_STR);

    $editar_niveis->execute();

    if ($editar_niveis->rowCount()) {
        $resposta = [
            "erro" => false,
            "mensagem" => "Dados alterados com sucesso!",
        ];
    } else {
        $resposta = [
            "erro" => false,
            "mensagem" => "Dados não alterado!",
        ];
    }
} else {
    $resposta = [
        "erro" => false,
        "mensagem" => "Dados não alterado!",
    ];
}

http_response_code(200);
echo json_encode($resposta);
