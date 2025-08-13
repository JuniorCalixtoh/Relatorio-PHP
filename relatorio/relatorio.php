<?php
session_start();

class Relatorio {
    protected $html;

    public function __construct(){
        $this->html = "";
    }

    public function __destruct(){
        echo $this->html;
    }

    public function init($titulo, $header , $body, $footer){
        $this->setHead();                 // Inclui CSS externo
        $this->setTitulo($titulo);        // Título
        $this->setHeader($header);        // Cabeçalho
        $this->setBody($body);            // Corpo
        $this->setFooter($footer, $body); // Rodapé
        $this->setBotaoImpressaoDireta(); // Botão
    }

    // Inclui CSS externo
    protected function setHead(){
        $this->html .= '<link rel="stylesheet" href="style.css">';
    }

    protected function setTitulo($titulo){
        $this->html .= "<h2>$titulo</h2>"; 
    }

    protected function setHeader(array $header){
        $this->html .= "<table>"; 
        $this->html .= "<tr>"; 
        foreach ($header as $linha){
            $this->html .= "<th>$linha</th>"; 
        }
        $this->html .= "</tr>"; 
    }

    protected function setBody(array $body){
        foreach ($body as $linha){
            $this->html .= "<tr>";
            foreach ($linha as $coluna){
                $this->html .= "<td>$coluna</td>";
            }
            $this->html .= "</tr>";
        }
    }

    protected function setFooter($footer, $body){
        $total = 0;
        foreach ($body as $linha){
            if (isset($linha[2])) {
                $valor = str_replace(",", ".", preg_replace("/[^0-9,]/", "", $linha[2]));
                $total += (float)$valor;
            }
        }
        $this->html .= "<tfoot>";
        $this->html .= "<tr><td colspan='2' style='text-align:right'>Total:</td>";
        $this->html .= "<td>R$ " . number_format($total, 2, ',', '.') . "</td></tr>";
        $this->html .= "<tr><td colspan='100%'>$footer</td></tr>";
        $this->html .= "</tfoot>";
        $this->html .= "</table>"; 
    }

    protected function setBotaoImpressaoDireta(){
        $this->html .= "<div class='btn-container'>
            <button class='btn' onclick='window.print()'>Imprimir Relatório</button>
        </div>";
    }
}

// ---------- DADOS ----------
$titulo = "RELATÓRIO DE ALUNOS FILTRADOS POR DATA DE MATRÍCULA ATIVA: 01/08/2025 ATÉ 11/08/2025.";
$bd = ["Nome do Aluno", "Telefone do Aluno", "Valores"]; 
$body = [
    ["João da Silva", "(11) 99999-9999", "100,50"],
    ["Maria Souza", "(21) 98888-8888", "200,00"],
    ["Pedro Lima", "(31) 97777-7777", "50,75"]
];
$footer = "Fim do relatório";

// ---------- EXECUTA ----------
$relatorio = new Relatorio();
$relatorio->init($titulo, $bd, $body, $footer);
?>
