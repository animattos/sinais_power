<?php
// URL do seu Realtime Database (coloque seu link aqui)
$firebase_url = "https://SEU_PROJETO_FIREBASE.firebaseio.com/licencas/";

$conta = $_GET['conta'];
$servidor = $_GET['servidor'];
$chave = $conta . "_" . $servidor;

// 1. Tenta buscar a conta no Firebase
$url = $firebase_url . $chave . ".json";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$resposta = curl_exec($ch);
$dados = json_decode($resposta, true);

// 2. Se a conta não existe, cria ela automaticamente com status "teste"
if (!$dados) {
    $novo_registro = [
        "inicio" => date("Y-m-d"),
        "status" => "teste"
    ];
    
    $ch_put = curl_init($url);
    curl_setopt($ch_put, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch_put, CURLOPT_POSTFIELDS, json_encode($novo_registro));
    curl_setopt($ch_put, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch_put);
    curl_close($ch_put);
    
    echo "teste"; // Responde ao MT4 que acabou de ser criado como teste
} else {
    // Se já existe, apenas retorna o status atual
    echo $dados['status'];
}
curl_close($ch);
?>