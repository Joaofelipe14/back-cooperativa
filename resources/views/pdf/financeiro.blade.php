<!DOCTYPE html>
<html>

<head>
    <title>Relatório de Registros Financeiros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            border-bottom: 1px solid #dddddd;
            text-align: center;
            padding: 10px 0;
            z-index: 1000;
        }

        .cooperative-info {
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            padding: 10px;
            margin-bottom: 10px;
            text-align: left;
        }

        .cooperative-info p {
            margin: 0;
            padding: 2px 0;
        }

        .user-info {
            text-align: left;
            margin: 0;
        }

        .content {
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
            /* Centraliza o título do PDF */
        }
    </style>
</head>

<body>
    <div class="header">
    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
        <h2>Relatório da Cooperativa de Pesca</h2>
    </div>

    <div class="content">
        <div class="cooperative-info">
            <h3>Dados da Cooperativa</h3>
            <p><strong>Nome:</strong> {{$cooperativa->nome}}</p>
            <p><strong>Endereço:</strong> {{$cooperativa->endereco}}</p>
            <p><strong>CEP:</strong> {{$cooperativa->cep}} </p>
        </div>

        <div class="cooperative-info">
            <h3>Informações do Usuário</h3>
            <p>Nome: {{ $user->name }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>CPF: {{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf) }}</p>
            <p>Contato: {{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $user->contato) }}</p>
        </div>

        <h1>Registros Financeiros</h1>
        <table>
            <thead>
                <tr>
                    <th>Transporte</th>
                    <th>Combustível</th>
                    <th>Embarcação</th>
                    <th>Energia</th>
                    <th>Material</th>
                    <th>Data Inicial</th>
                    <th>Data Final</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->transporte }}</td>
                    <td>{{ $registro->combustivel }}</td>
                    <td>{{ $registro->embarcacao }}</td>
                    <td>{{ $registro->energia }}</td>
                    <td>{{ $registro->material }}</td>
                    <td>{{ $registro->data_inicial }}</td>
                    <td>{{ $registro->data_final }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>