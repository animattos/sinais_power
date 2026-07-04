<?php
// Apenas para teste: força o registro de qualquer acesso
$conta = isset($_GET['conta']) ? $_GET['conta'] : "sem_conta";
$servidor = isset($_GET['servidor']) ? $_GET['servidor'] : "sem_servidor";
$url_firebase = "https://conteumconto-f4f8e-default-rtdb.firebaseio.com/licencas/" . $conta . "_" . $servidor . ".json";

$dados = json_encode(["status" => "teste_ok", "data" => date("d-m-Y H:i:s")]);

$ch = curl_init($url_firebase);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);
curl_close($ch);

echo "LIBERADO";
?>