<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");

require 'config.php';

$resposta_json = file_get_contents("php://input");
$dados = json_decode($resposta_json, true);

if ($dados) {
    $sql_verificar = "SELECT * FROM desenvolvedores WHERE (id_nivel = :id_nivel AND nome = :nome AND sexo = :sexo AND data_nascimento = :data_nascimento AND idade = :idade AND hobby = :hobby)";
    $verificar_devs = $pdo->prepare($sql_verificar);
    $verificar_devs->bindParam(':id_nivel', $dados['desenvolvedores']['id_nivel'], PDO::PARAM_INT);
    $verificar_devs->bindParam(':nome', $dados['desenvolvedores']['nome'], PDO::PARAM_STR);
    $verificar_devs->bindParam(':sexo', $dados['desenvolvedores']['sexo'], PDO::PARAM_STR);
    $verificar_devs->bindParam(':data_nascimento', $dados['desenvolvedores']['data_nascimento'], PDO::PARAM_STR);
    $verificar_devs->bindParam(':idade', $dados['desenvolvedores']['idade'], PDO::PARAM_INT);
    $verificar_devs->bindParam(':hobby', $dados['desenvolvedores']['hobby'], PDO::PARAM_STR);
    $verificar_devs->execute();

    if ($verificar_devs->rowCount() > 0) {
        $resposta = [
            "erro" => true,
            "mensagem" => "Este registro já existe!"
        ];
    } else {
        $sql_devs = "INSERT INTO desenvolvedores (id_nivel, nome, sexo, data_nascimento, idade, hobby) VALUES (:id_nivel, :nome, :sexo, :data_nascimento, :idade, :hobby)";
        $cadastro_devs = $pdo->prepare($sql_devs);
        $cadastro_devs->bindParam(':id_nivel', $dados['desenvolvedores']['id_nivel'], PDO::PARAM_INT);
        $cadastro_devs->bindParam(':nome', $dados['desenvolvedores']['nome'], PDO::PARAM_STR);
        $cadastro_devs->bindParam(':sexo', $dados['desenvolvedores']['sexo'], PDO::PARAM_STR);
        $cadastro_devs->bindParam(':data_nascimento', $dados['desenvolvedores']['data_nascimento'], PDO::PARAM_STR);
        $cadastro_devs->bindParam(':idade', $dados['desenvolvedores']['idade'], PDO::PARAM_INT);
        $cadastro_devs->bindParam(':hobby', $dados['desenvolvedores']['hobby'], PDO::PARAM_STR);
        $cadastro_devs->execute();

        if ($cadastro_devs->rowCount()) {
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
