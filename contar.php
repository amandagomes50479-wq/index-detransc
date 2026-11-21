<?php
// Define o arquivo onde os cliques ficarão salvos
$arquivo = 'cliques.json';

// Lê os dados atuais ou cria uma lista vazia
if (file_exists($arquivo)) {
    $conteudo = file_get_contents($arquivo);
    $cliques = json_decode($conteudo, true) ?: [];
} else {
    $cliques = [];
}

// Se recebeu um clique via POST, soma +1 no botão correspondente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['botao'])) {
    $nomeBotao = strip_tags(trim($_POST['botao']));
    
    if (!isset($cliques[$nomeBotao])) {
        $cliques[$nomeBotao] = 0;
    }
    $cliques[$nomeBotao]++;

    // Salva a contagem atualizada no arquivo cliques.json
    file_put_contents($arquivo, json_encode($cliques, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    exit('OK');
}

// Se você acessar seudominio.com.br/contar.php pelo navegador, exibe o relatório de cliques:
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Cliques</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 40px; }
        .painel { max-width: 500px; margin: auto; background: #fff; padding: 25px; border-radius: 6px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        h2 { color: #2b542c; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #e9f5e9; color: #2b542c; }
    </style>
</head>
<body>
    <div class="painel">
        <h2>Contagem de Cliques por Botão</h2>
        <table>
            <tr>
                <th>Botão</th>
                <th>Total de Cliques</th>
            </tr>
            <?php if (empty($cliques)): ?>
                <tr><td colspan="2">Nenhum clique registrado ainda.</td></tr>
            <?php else: ?>
                <?php foreach ($cliques as $botao => $total): ?>
                    <tr>
                        <td><?= htmlspecialchars($botao) ?></td>
                        <td><strong><?= $total ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
