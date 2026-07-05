<?php

$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

$conta    = $_GET['conta'] ?? '';
$servidor = $_GET['servidor'] ?? '';

if(empty($conta) || empty($servidor))
{
    die("PARAMETROS_INVALIDOS");
}

$chave = $conta . "_" . $servidor;
$url   = $firebase_url . $chave . ".json";

// ======================
// BUSCA REGISTRO
// ======================

$dados = json_decode(file_get_contents($url), true);

// ======================
// PRIMEIRO ACESSO
// ======================

if(!$dados)
{
    $novo = [
        "inicio"          => date("Y-m-d"),
        "status"          => "teste",
        "ultima_conexao"  => date("Y-m-d")
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

// ======================
// ATUALIZA ULTIMO ACESSO
// ======================

$patch = [
    "ultima_conexao" => date("Y-m-d")
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($patch));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

// ======================
// STATUS MANUAL
// ======================

$status = strtoupper(trim($dados["status"]));

if($status == "LIBERADO")
{
    echo "LIBERADO";
    exit;
}

if($status == "BLOQUEADO")
{
    echo "BLOQUEADO";
    exit;
}

// ======================
// TESTE DE 3 DIAS
// ======================

$inicio = strtotime($dados["inicio"]);
$hoje   = strtotime(date("Y-m-d"));

$dias = floor(($hoje - $inicio) / 86400);

if($dias <= 3)
{
    echo "LIBERADO";
}
else
{
    echo "EXPIRADO";
}

?>