<!-- Rodapé -->
<div class="footer">
    <div class="print-info">
        <p>Relatório gerado por: {{ $user->name }}</p>
        <p>Data de Impressão: {{ date('d/m/Y H:i:s') }}</p>
    </div>
    <div class="page-number">
        Página: {PAGE_NUM} de {PAGE_COUNT}
    </div>
</div>
