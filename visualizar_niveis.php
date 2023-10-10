<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    require 'config.php';

    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $resposta = "";
    $sql_niveis = "SELECT id, nivel FROM niveis WHERE id = :id LIMIT 1";
    $visualizar_niveis = $pdo->prepare($sql_niveis);
    $visualizar_niveis->bindParam(':id', $id, PDO::PARAM_INT);
    $visualizar_niveis->execute();

    if (($visualizar_niveis) and ($visualizar_niveis->rowCount() != 0)) {
        $row_niveis = $visualizar_niveis->fetch(PDO::FETCH_ASSOC);
        extract($row_niveis);
        $niveis = [
            'id' => $id,
            'nivel' => $nivel,
        ];
        $resposta = [
            "erro" => false,
            "niveis" => $niveis
        ];
    } else {
        $resposta = [
            "erro" => true,
            "mensagem" => "Cadastro não encontrado!"
        ];
    }

    http_response_code(200);
    echo json_encode($resposta);
