<?php
if (!isset($_POST['index']) || !isset($_POST['valor'])) {
    exit;
}

$index = (int) $_POST['index'];
$novo_valor = $_POST['valor'];

include 'dados.php';

// Atualiza o valor no array
if (isset($body[$index])) {
    $body[$index][2] = $novo_valor;
}

// Reescreve o arquivo dados.php
$conteudo = "<?php\n";
$conteudo .= '$titulo = ' . var_export($titulo, true) . ";\n";
$conteudo .= '$header = ' . var_export($header, true) . ";\n";
$conteudo .= '$body = ' . var_export($body, true) . ";\n";
$conteudo .= '$footer = ' . var_export($footer, true) . ";\n";

file_put_contents('dados.php', $conteudo);
