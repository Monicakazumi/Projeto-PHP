<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$resposta = "";
$sql_devs = "SELECT id, id_nivel, nome, sexo, data_nascimento, idade, hobby FROM desenvolvedores WHERE id = :id LIMIT 1";
$visualizar_devs = $pdo->prepare($sql_devs);
$visualizar_devs->bindParam(':id', $id, PDO::PARAM_INT);
$visualizar_devs->execute();

if (($visualizar_devs) and ($visualizar_devs->rowCount() != 0)) {
    $row_devs = $visualizar_devs->fetch(PDO::FETCH_ASSOC);
    extract($row_devs);
    $desenvolvedores = [
        'id' => $id,
        'id_nivel' => $id_nivel,
        'nome' => $nome,
        'sexo' => $sexo,
        'data_nascimento' => $data_nascimento,
        'idade' => $idade,
        'hobby' => $hobby
    ];
    $resposta = [
        "erro" => false,
        "desenvolvedores" => $desenvolvedores
    ];
} else {
    $resposta = [
        "erro" => true,
        "mensagem" => "Cadastro não encontrado!"
    ];
}

http_response_code(200);
echo json_encode($resposta);
