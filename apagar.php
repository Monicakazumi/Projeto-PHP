<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_NUMBER_INT);
$resposta = "";
$sql_devs = "DELETE FROM desenvolvedores WHERE id = :id LIMIT 1";
$apagar_devs = $pdo->prepare($sql_devs);
$apagar_devs->bindParam(':id', $id, PDO::PARAM_INT);

if ($apagar_devs->execute()) {
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
