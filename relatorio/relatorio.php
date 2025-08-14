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
        $this->html .= '<link rel="stylesheet" href="style.css">';
    }

    protected function setTitulo($titulo){
        $this->html .= "<h2>$titulo</h2>";
    }

    protected function setHeader(array $header){
        $this->html .= "<table id='tabela-relatorio'>";
        $this->html .= "<tr>";
        foreach ($header as $linha){
            $this->html .= "<th>$linha</th>";
        }
        $this->html .= "</tr>";
    }

protected function setBody(array $body){
    foreach ($body as $linhaIndex => $linha){
        $this->html .= "<tr>";
        foreach ($linha as $i => $coluna){
            if ($i === 2) {
                // Formata com vírgula, mas mantém como string no input
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
        <button class='btn' onclick='window.print()'>
            <span class='btn-text'>Imprimir Relatório</span>
            <span class='btn-icon'>🖨️</span>
        </button>
    </div>";
}

    protected function setScript(){
        $this->html .= "
        <script>
        function calcularTotal(){
            let total = 0;
            document.querySelectorAll('.valor').forEach(campo => {
                let val = campo.value.replace('.', '').replace(',', '.');
                if(!isNaN(val) && val.trim() !== '') total += parseFloat(val);
            });
            document.getElementById('total').innerText = 'R$ ' + total.toFixed(2).replace('.', ',');
        }

        function salvarValor(index, valor){
            fetch('salvar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'index=' + index + '&valor=' + encodeURIComponent(valor)
            });
        }

        document.querySelectorAll('.valor').forEach(campo => {
            campo.addEventListener('input', () => {
                calcularTotal();
                salvarValor(campo.dataset.index, campo.value);
            });
        });

        calcularTotal();
        </script>
        ";
    }
}
