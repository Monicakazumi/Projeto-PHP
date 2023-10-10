<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

require 'config.php';

$resposta_json = file_get_contents("php://input");
$dados = json_decode($resposta_json, true);

if ($dados) {
    $sql_verificar = "SELECT nivel FROM niveis WHERE nivel = :nivel";
    $verificar_nivel = $pdo->prepare($sql_verificar);
    $verificar_nivel->bindParam(':nivel', $dados['niveis']['nivel'], PDO::PARAM_STR);
    $verificar_nivel->execute();

    if ($verificar_nivel->rowCount() > 0) {
        $resposta = [
            "erro" => true,
            "mensagem" => "Este registro já existe!"
        ];
    } else {
        $sql_niveis = "INSERT INTO niveis (nivel) VALUES (:nivel)";
        $cadastro_niveis = $pdo->prepare($sql_niveis);
        $cadastro_niveis->bindParam(':nivel', $dados['niveis']['nivel'], PDO::PARAM_STR);
        $cadastro_niveis->execute();

        if ($cadastro_niveis->rowCount()) {
            $resposta = [
                "erro" => false,
                "mensagem" => "Cadastro realizado com sucesso!"
            ];
        } else {
            $resposta = [
                "erro" => true,
                "mensagem" => "Cadastro não realizado!"
            ];
        }
    }
} else {
    $resposta = [
        "erro" => true,
        "mensagem" => "Dados Inválido!"
    ];
}

http_response_code(201);
echo json_encode($resposta);
