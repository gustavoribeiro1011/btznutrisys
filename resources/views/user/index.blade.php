@extends('layouts.app')

@section('title', 'Usuários')

@section('content')

    <x-page-header title="Lista os usuários" />

    @if ($usuarios)
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-gray-500 font-medium">
                        <th class="text-left">Nome completo</th>
                        <th class="text-left">Nome de usuário</th>
                        <th class="text-left">Empresa</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario['full_name'] }}</td>
                            <td>{{ $usuario['username'] }}</td>
                            <td>{{ $usuario['id_company'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
