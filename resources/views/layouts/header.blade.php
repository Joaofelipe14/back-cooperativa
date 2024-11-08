<!-- Cabeçalho -->

<div class="cooperative-info">
    <div class="left">
        <h3>Dados da Cooperativa</h3>
        <p><strong>Nome:</strong> {{$cooperativa->nome}}</p>
        <p><strong>Endereço:</strong> {{$cooperativa->endereco}}</p>
        <p><strong>CEP:</strong> {{$cooperativa->cep}}</p>
    </div>
    <div class="right">
        <img src="data:image/png;base64,{{ $cooperativa->logo }}" alt="Logo" style="max-height: 100px;"/>
    </div>
</div>
