<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'exists' => 'O campo :attribute selecionado é inválido.',
    'numeric' => 'O campo :attribute deve ser numérico.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'string' => 'O campo :attribute deve ser um texto.',
    'max' => [
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
    ],
    'min' => [
        'numeric' => 'O campo :attribute deve ser no mínimo :min.',
        'integer' => 'O campo :attribute deve ser no mínimo :min.',
    ],
    'sometimes' => 'O campo :attribute pode ser enviado ou não.',

    'attributes' => [
        'tipo_id' => 'tipo',
        'status_id' => 'status',
        'localizacao_id' => 'localização',
        'nome' => 'nome',
        'descricao' => 'descrição',
        'preco' => 'preço',
        'quantidade' => 'quantidade',
        'unidade_medida' => 'unidade de medida',
        'imagem' => 'imagem',
        'descricao_amigavel' => 'descrição amigável',
        'latitude' => 'latitude',
        'longitude' => 'longitude',
        'cnpj' => 'CNPJ',
        'endereco' => 'endereço',
        'cidade' => 'cidade',
        'estado' => 'estado',
        'cep' => 'CEP',
        'telefone' => 'telefone',
        'email' => 'e-mail',
        'data_fundacao' => 'data de fundação',
        'url_foto' => 'foto',
    ],
];
