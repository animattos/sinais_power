<?php
// Desabilita cache para garantir que o MetaTrader pegue sempre o dado atualizado
header("Content-Type: text/plain");

$firebase_url = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/";

$conta = isset($_GET['conta']) ? $_GET['conta'] : "sem_conta";
$servidor = isset($_GET['servidor']) ? $_GET['servidor'] : "sem_servidor";

$chave = $conta . "_" . $servidor;
$url = $firebase_url . $chave . ".json";

// Dados para salvar
$dados = json_encode([
    "data" => date("d-m-Y H:i:s"),
    "status" => "ativo",
    "conta" => $conta,
    "servidor" => $servidor
]);

// Ação de escrita no Firebase
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

echo "LIBERADO";
?>