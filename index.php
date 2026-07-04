<?php
// Configurações do Firebase
$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

// Recebe os dados do MT4
$conta = $_GET['conta'] ?? '';
$servidor = $_GET['servidor'] ?? '';
$id = $conta . "_" . $servidor;

if (empty($conta) || empty($servidor)) {
    die("ERRO: Dados invalidos.");
}

// Busca no Firebase
$url = $firebase_url . $id . ".json";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!$data) {
    die("NAO LIBERADO");
}

if ($data['status'] == 'assinante') {
    die("LIBERADO");
}

if ($data['status'] == 'teste') {
    $data_inicio = strtotime($data['inicio']);
    $hoje = strtotime(date("Y-m-d"));
    $diferenca = ($hoje - $data_inicio) / (60 * 60 * 24);

    if ($diferenca <= 3) {
        die("LIBERADO");
    } else {
        die("EXPIRADO");
    }
}

die("BLOQUEADO");
?>