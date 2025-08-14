// ------------------------- Calcular total automaticamente -------------------------
function calcularTotal(){
    let total = 0;
    document.querySelectorAll('.valor').forEach(campo => {
        let val = campo.value.replace('.', '').replace(',', '.');
        if(!isNaN(val) && val.trim() !== '') total += parseFloat(val);
    });
    document.getElementById('total').innerText = 'R$ ' + total.toFixed(2).replace('.', ',');
}

// ------------------------- Salvar valores via fetch (opcional) -------------------------
function salvarValor(index, valor){
    fetch('salvar.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'index=' + index + '&valor=' + encodeURIComponent(valor)
    });
}

// ------------------------- Evento para atualizar valores -------------------------
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.valor').forEach(campo => {
        campo.addEventListener('input', () => {
            calcularTotal();
            salvarValor(campo.dataset.index, campo.value);
        });
    });

    calcularTotal();

    // ------------------------- Exportar para Excel -------------------------
    if (document.getElementById('exportExcel')) {
        document.getElementById('exportExcel').addEventListener('click', () => {
            let wb = XLSX.utils.book_new();
            let ws_data = [];

            // Cabeçalho
            let headers = [];
            document.querySelectorAll('#tabela-relatorio th').forEach(th => headers.push(th.innerText));
            ws_data.push(headers);

            // Corpo
            document.querySelectorAll('#tabela-relatorio tbody tr').forEach(tr => {
                let row = [];
                tr.querySelectorAll('td').forEach(td => {
                    let input = td.querySelector('input');
                    row.push(input ? input.value : td.innerText);
                });
                ws_data.push(row);
            });

            let ws = XLSX.utils.aoa_to_sheet(ws_data);
            XLSX.utils.book_append_sheet(wb, ws, 'Relatorio');
            XLSX.writeFile(wb, 'relatorio.xlsx');
        });
    }
});
