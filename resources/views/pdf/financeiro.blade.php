@extends('layouts.report')

@section('content')
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
@endsection
