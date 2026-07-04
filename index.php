<?php
$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

$conta = $_GET['conta'];
$servidor = $_GET['servidor'];
$data = date("Y-m-d"); // Data atual

$chave = $conta . "_" . $servidor;
$url = $firebase_url . $chave . ".json";

// --- FORÇA A ATUALIZAÇÃO NO FIREBASE (REGISTRO) ---
$dados_para_enviar = [
    "inicio" => $data, 
    "status" => "ativo",
    "ultima_conexao" => $data
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH"); // PATCH atualiza sem apagar outros campos
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dados_para_enviar));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

// --- VERIFICAÇÃO DE LIBERAÇÃO ---
echo "LIBERADO"; 
?>