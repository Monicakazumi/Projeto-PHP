<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$resposta = "";
$sql_niveis = "DELETE FROM niveis WHERE id = :id LIMIT 1";
$apagar_niveis = $pdo->prepare($sql_niveis);
$apagar_niveis->bindParam(':id', $id, PDO::PARAM_INT);

if ($apagar_niveis->execute()) {
    $resposta = [
        "erro" => false,
        "mensagem" => "Apagado com sucesso!"
    ];
} else {
    $resposta = [
        "erro" => true,
        "mensagem" => "Não apagado!"
    ];
}

http_response_code(204);
echo json_encode($resposta);
