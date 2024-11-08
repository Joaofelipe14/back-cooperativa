<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Registros Financeiros</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* Definindo as cores com base nas variáveis fornecidas */
        :root {
            --background-principal: #F6FAFF;
            --btn-principal: #597492;
            --btn-secundario: #6A7077;
            --fonte-titulo: #597492;
            --card-header: #DDEAF3;
            --fundo-interno: #F6FAFF;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            padding-bottom: 60px; /* Adiciona espaço suficiente para o rodapé */
        }

        /* Cabeçalho */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #dddddd;
            padding: 10px 20px;
        }

        .header h2 {
            font-size: 24px;
            margin: 0;
            flex: 1;
            color: var(--fonte-titulo);
        }

        .header .logo {
            text-align: right;
            flex: 0 0 150px;
        }

        /* Dados da Cooperativa */
        .cooperative-info {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: var(--fundo-interno);
            border: 1px solid #dddddd;
        }

        .cooperative-info h3 {
            font-size: 18px;
            margin-top: 0;
            color: var(--fonte-titulo);
        }

        .cooperative-info p {
            margin: 5px 0;
            padding: 2px 0;
            color: var(--fonte-titulo);
        }

        .cooperative-info .left {
            width: 75%;
            float: left;
        }

        .cooperative-info .right {
            width: 25%;
            float: right;
            text-align: right;
        }

        .cooperative-info::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Tabela */
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
            background-color: var(--card-header);
            color: var(--fonte-titulo);
        }

        td {
            background-color: var(--fundo-interno);
            color: var(--fonte-titulo);
        }

        /* Rodapé */
        @page {
           
        }

        .footer {
            position: fixed; /* Torna o rodapé fixo na parte inferior da página */
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 12px;
            background-color: var(--background-principal);
            border-top: 1px solid #dddddd;
            padding: 10px 0;
        }

        .footer .page-number {
            position: absolute;
            bottom: 10px;
            right: 20px;
            font-size: 10px;
            color: var(--fonte-titulo);
        }

        .footer .print-info {
            font-size: 12px;
            color: var(--fonte-titulo);
        }

        .footer .print-info p {
            margin: 0;
        }

  

    </style>
</head>

<body>
    <!-- Cabeçalho -->
    @include('layouts.header', ['cooperativa' => $cooperativa])
    @include('layouts.footer', ['user' => $user])
    <!-- Conteúdo principal -->
    @yield('content')

    <!-- Rodapé -->
</body>

</html>
