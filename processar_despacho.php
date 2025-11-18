$nome         = trim($_POST['nome']);
$data_envio   = $_POST['data_envio'];
$num_sedex    = trim($_POST['num_sedex']);
$transportadora = trim($_POST['transportadora']);
$num_nota     = trim($_POST['num_nota']);
$anotacao1    = trim($_POST['anotacao1']);
$anotacao2    = trim($_POST['anotacao2']);

// Buscar transportadora_id
$tid = $pdo->query("SELECT id FROM transportadoras WHERE nome = ". $pdo->quote($transportadora))->fetchColumn();
if (!$tid && $transportadora) {
    $pdo->query("INSERT INTO transportadoras (nome) VALUES (". $pdo->quote($transportadora).")");
    $tid = $pdo->lastInsertId();
}

$sql = "INSERT INTO despachos 
(nome, data_envio, num_sedex, transportadora, transportadora_id, num_nota, anotacao1, anotacao2, 
 destino_nome, codigo_rastreio, nota_fiscal, data_criacao, despachante_id, status)
VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, 'Em Processamento')";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    $nome, $data_envio, $num_sedex, $transportadora, $tid, $num_nota, $anotacao1, $anotacao2,
    $nome, $num_sedex, $num_nota, $_SESSION['user_id']
]);