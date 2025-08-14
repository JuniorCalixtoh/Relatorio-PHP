<?php
class Relatorio {
    protected $html;

    public function __construct(){
        $this->html = "";
    }

    public function __destruct(){
        echo $this->html;
    }

    public function init($titulo, $header, $body, $footer){
        $this->setHead();
        $this->setTitulo($titulo);
        $this->setHeader($header);
        $this->setBody($body);
        $this->setFooter($footer);
        $this->setBotaoImpressaoDireta();
        $this->setScript();
    }

    protected function setHead(){
        // CSS externo
        $this->html .= '<link rel="stylesheet" href="style.css">';
    }

    protected function setTitulo($titulo){
        $this->html .= "<h2>$titulo</h2>";
    }

    protected function setHeader(array $header){
        $this->html .= "<table id='tabela-relatorio'>";
        $this->html .= "<thead><tr>";
        foreach ($header as $linha){
            $this->html .= "<th>$linha</th>";
        }
        $this->html .= "</tr></thead><tbody>";
    }

    protected function setBody(array $body){
        foreach ($body as $linhaIndex => $linha){
            $this->html .= "<tr>";
            foreach ($linha as $i => $coluna){
                if ($i === 2) {
                    // Valores editáveis centralizados
                    $valorFormatado = number_format((float)str_replace(',', '.', $coluna), 2, ',', '.');
                    $this->html .= "<td style='text-align:center;'>
                        <input type='text' class='valor' data-index='{$linhaIndex}' value='{$valorFormatado}' style='width:80px; text-align:center;'>
                    </td>";
                } else {
                    $this->html .= "<td>$coluna</td>";
                }
            }
            $this->html .= "</tr>";
        }
        $this->html .= "</tbody>";
    }

    protected function setFooter($footer){
        $this->html .= "<tfoot>";
        $this->html .= "<tr><td colspan='2' style='text-align:right'>Total:</td>";
        $this->html .= "<td id='total'>R$ 0,00</td></tr>";
        $this->html .= "<tr><td colspan='100%'>$footer</td></tr>";
        $this->html .= "</tfoot>";
        $this->html .= "</table>";
    }

    protected function setBotaoImpressaoDireta(){
        $this->html .= "<div class='btn-container'>
            <!-- Botão de imprimir -->
            <button class='btn btn-print' onclick='window.print()'>
                <span class='btn-text'>Imprimir Relatório</span>
                <span class='btn-icon'>🖨️</span>
            </button>

            <!-- Botão de exportar Excel -->
            <button class='btn btn-excel' id='exportExcel'>
                <span class='btn-text'>Exportar para Excel</span>
                <span class='btn-icon'>📄</span>
            </button>
        </div>";
    }

    protected function setScript(){
        // Importa XLSX e o script externo
        $this->html .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>';
        $this->html .= '<script src="script.js"></script>';
    }
}
