<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require 'config.php';

$sql_devs = "SELECT id, id_nivel, nome, sexo, data_nascimento, idade, hobby FROM desenvolvedores ORDER BY id";
$consulta_devs = $pdo->prepare($sql_devs);
$consulta_devs->execute();

if (($consulta_devs) and ($consulta_devs->rowCount() != 0)) {
    while ($dados = $consulta_devs->fetch(PDO::FETCH_ASSOC)) {
        extract($dados);
        //var_dump($dados);

        $lista_devs[$id] = [
            'id' => $id,
            'id_nivel' => $id_nivel,
            'nome' => $nome,
            'sexo' => $sexo,
            'data_nascimento' => $data_nascimento,
            'idade' => $idade,
            'hobby' => $hobby,
        ];
    }

    http_response_code(200);
    echo json_encode($lista_devs);
}
