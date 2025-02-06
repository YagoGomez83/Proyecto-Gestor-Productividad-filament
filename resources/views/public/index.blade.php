@extends('layouts.public')

@section('title', 'Dashboard Público')

@section('content')
<div class="relative bg-cover bg-center min-h-screen" style="background-image: url('{{ asset('images/datasciense02.jpg') }}');">
    <div class="absolute inset-0 bg-black bg-opacity-50"></div> <!-- Overlay oscuro -->
    
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center text-white">
        <h1 class="text-4xl font-bold mb-4">Bienvenido al Dashboard Público</h1>
        <p class="text-lg mb-6">Ingresa al Sistema</p>
        <div>
            <a href="{{ route('login') }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-lg hover:bg-blue-600 transition">Login</a>
            <a href="{{ route('public.index') }}" class="px-6 py-3 bg-green-500 text-white font-semibold rounded-lg shadow-lg hover:bg-green-600 transition ml-4">Dashboard</a>
        </div>
    </div>
</div>
@endsection
