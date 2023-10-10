<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET,PUT,POST,DELETE");

require 'config.php';

$resposta_json = file_get_contents("php://input");
$dados = json_decode($resposta_json, true);
