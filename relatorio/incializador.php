<?php
session_start();

// Importa a classe e os dados
require_once 'Relatorio.php';
require_once 'dados.php';

// Cria e inicializa o relatório
$relatorio = new Relatorio();
$relatorio->init($titulo, $header, $body, $footer);
