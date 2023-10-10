<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

require 'config.php';

$resposta_json = file_get_contents("php://input");
$dados = json_decode($resposta_json, true);

if ($dados) {

    $sql_devs = "UPDATE desenvolvedores SET id_nivel = :id_nivel, nome = :nome, sexo = :sexo, data_nascimento = :data_nascimento, idade = :idade, hobby = :hobby WHERE id = :id";
    $editar_devs = $pdo->prepare($sql_devs);
    $editar_devs->bindParam(':id', $dados['id'], PDO::PARAM_INT);
    $editar_devs->bindParam(':id_nivel', $dados['id_nivel'], PDO::PARAM_INT);
    $editar_devs->bindParam(':nome', $dados['nome'], PDO::PARAM_STR);
    $editar_devs->bindParam(':sexo', $dados['sexo'], PDO::PARAM_STR);
    $editar_devs->bindParam(':data_nascimento', $dados['data_nascimento'], PDO::PARAM_STR);
    $editar_devs->bindParam(':idade', $dados['idade'], PDO::PARAM_INT);
    $editar_devs->bindParam(':hobby', $dados['hobby'], PDO::PARAM_STR);
    $editar_devs->execute();

    if ($editar_devs->rowCount()) {
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
