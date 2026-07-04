<?php

$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

if (!isset($_GET['conta']) || !isset($_GET['servidor'])) {
    die("PARAMETROS_INVALIDOS");
}

$conta = $_GET['conta'];
$servidor = $_GET['servidor'];

$chave = $conta . "_" . $servidor;

$url = $firebase_url . $chave . ".json";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($ch);
curl_close($ch);

$dados = json_decode($resposta, true);

if (!$dados) {

    $novo = [
        "inicio" => date("Y-m-d"),
        "status" => "teste"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($novo));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo "LIBERADO";
    exit;
}

$inicio = strtotime($dados["inicio"]);
$hoje = time();

$dias = floor(($hoje - $inicio) / 86400);

if ($dias <= 3) {
    echo "LIBERADO";
} else {
    echo "EXPIRADO";
}
?>