<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Pesca</title>
    <style>
        /* Estilo básico */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            /* background-color: #f8f9fa; */
        }

        /* Cabeçalho */
        .header {
            text-align: center;
            padding: 20px 0;
            background-color: #ffffff;
            border-bottom: 1px solid #ddd;
        }

        .header img {
            height: 100px;
            width: 100px;
        }

        .header h2 {
            margin: 10px 0;
        }

        /* Informações da cooperativa */
        .cooperative-info {
            background-color: #f9f9f9;
            border: 1px solid #dddddd;
            margin-bottom: 10px;
            padding-left: 100px;
            text-align:center
        }

        .cooperative-info h3 {
            margin-top: 0;
            padding: 20px;

        }

   

        /* Tabela de registros de pesca */
        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 0.75rem;
            text-align: left;
            border: 1px solid #ddd;
        }

        table th {
            background-color: rgb(96, 165, 250);
            color: white;
            font-weight: bold;
        }

        table tr.items {
            /* background-color: rgb(241, 245, 249); */
        }

        table td {
            background-color: #fff;
        }

        .footer {
            background-color: rgb(241, 245, 249);
            font-size: 0.875rem;
            padding: 1rem;
            margin-top: 20px;
            text-align: center;
        }

        .footer p {
            margin: 0;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .cooperative-info {
                padding: 5px;
            }

            table th, table td {
                padding: 0.5rem;
            }

            .header h2 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="data:image/png;base64,{{ $base64Image }}" alt="Logo" />
        <h2>Relatório da Cooperativa de Pesca</h2>
    </div>

    <div class="cooperative-info">
        <!-- <h3>Dados da Cooperativa</h3> -->
        <p><strong>Nome:</strong> {{$cooperativa->nome}}</p>
        <p><strong>Endereço:</strong> {{$cooperativa->endereco}}</p>
        <p><strong>CEP:</strong> {{$cooperativa->cep}}</p>
    </div>

    <h4>Relatório de Pesca</h4>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Data e Hora</th>
                <th>Nome do Usuário</th>
                <th>Localização</th>
                <th>Pescado</th>
                <th>Quantidade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr class="items">
                    <td>{{ $registro->codigo }}</td>
                    <td>{{ \Carbon\Carbon::parse($registro->data_com_hora)->format('d/m/Y H:i') }}</td>
                    <td>{{ $registro->user->name }}</td> <!-- Nome do usuário -->
                    <td>{{ $registro->localizacao->descricao_amigavel }}</td> <!-- Descrição amigável da localização -->
                    <td>{{ $registro->pescado }}</td>
                    <td>{{ $registro->quantidade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Cooperativa de Pesca. Todos os direitos reservados.</p>
    </div>
</body>
</html>
