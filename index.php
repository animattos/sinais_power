<?php

// URL do Firebase
$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

// Verifica parâmetros
$conta    = $_GET['conta'] ?? '';
$servidor = $_GET['servidor'] ?? '';

if ($conta == '' || $servidor == '') {
    die("PARAMETROS_INVALIDOS");
}

// Monta chave única
$chave = $conta . "_" . $servidor;

// URL do registro
$url = $firebase_url . $chave . ".json";

// Busca registro existente
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($ch);
curl_close($ch);

$dados = json_decode($resposta, true);

// Se não existe, cria automaticamente
if (!$dados)
{
    $novo_registro = [
        "inicio" => date("Y-m-d"),
        "status" => "teste"
    ];

    $ch_put = curl_init($url);
    curl_setopt($ch_put, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch_put, CURLOPT_POSTFIELDS, json_encode($novo_registro));
    curl_setopt($ch_put, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);
    curl_setopt($ch_put, CURLOPT_RETURNTRANSFER, true);

    curl_exec($ch_put);
    curl_close($ch_put);

    echo "LIBERADO";
    exit;
}

// Já existe
$status = $dados['status'] ?? 'bloqueado';

// Libera apenas teste ou assinante
if ($status == "teste" || $status == "assinante")
{
    echo "LIBERADO";
}
else
{
    echo "BLOQUEADO";
}

?>