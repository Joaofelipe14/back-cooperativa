@extends('layouts.report')

@section('content')
    <h1>Registros de Pesca</h1>
    <table>
        <thead>
            <tr>
                <th>Localização</th>
                <th>Data e Hora</th>
                <th>Código</th>
                <th>Usuário</th>
                <th>Pescado</th>
                <th>Quantidade(Kg)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->localizacao->descricao_amigavel }}</td>
                    <td>{{ $registro->data_com_hora }}</td>
                    <td>{{ $registro->codigo }}</td>
                    <td>{{ $registro->user->name }}</td>
                    <td>{{ $registro->pescado }}</td>
                    <td>{{ $registro->quantidade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
