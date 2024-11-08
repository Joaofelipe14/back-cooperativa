@extends('layouts.report')

@section('content')
    <h1>Registros de Venda</h1>
    <table>
        <thead>
            <tr>
                <th>Ponto de Venda</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Código</th>
                <th>Usuário</th>
                <th>Pescado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->localizacao->descricao_amigavel }}</td> 
                    <td>{{ $registro->quantidade }}</td> 
                    <td>{{ number_format($registro->valor, 2, ',', '.') }}</td>
                    <td>{{ $registro->codigo }}</td>
                    <td>{{ $registro->user->name }}</td> 
                    <td>{{ $registro->pescado }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
