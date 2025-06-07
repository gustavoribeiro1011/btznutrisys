@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Cabeçalho da Página -->
    @include('components.page-header', [
        'title' => 'Dashboard',
        'description' => 'Visão geral do sistema de gerenciamento de ração',
    ])

    <!-- Container Principal -->
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Seção de Ações Rápidas -->
        @include('components.dashboard.quick-actions')

        <!-- Seção de Módulos do Sistema -->
        @include('components.dashboard.system-modules')
    </div>
@endsection
