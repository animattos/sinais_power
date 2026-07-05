<?php

$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

$conta = $_GET['conta'] ?? '';
$servidor = $_GET['servidor'] ?? '';

$chave = $conta . "_" . $servidor;
$url = $firebase_url . $chave . ".json";

// busca registro
$dados = json_decode(file_get_contents($url), true);

// não existe
if(!$dados)
{
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

// existe
$status = strtoupper($dados["status"]);

if($status == "LIBERADO" || $status == "TESTE")
{
    echo "LIBERADO";
}
else
{
    echo "BLOQUEADO";
}