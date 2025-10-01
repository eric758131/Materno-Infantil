@extends('layouts.app')

@section('title', 'Sistema Materno Infantil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Sistema Materno Infantil</h1>
        <p class="text-gray-600 mt-2">Bienvenido al sistema</p>
    </div>

    <!-- Contenido principal -->
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(Auth::check())
            <!-- Usuario autenticado -->
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-700">¡Hola, {{ Auth::user()->nombre }}!</h2>
                <p class="text-gray-600 mt-2">Has iniciado sesión correctamente.</p>
                
                <!-- Información del usuario -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-medium text-gray-800">Información del usuario:</h3>
                    <div class="mt-2 text-sm text-gray-600">
                        <p><strong>Nombre completo:</strong> {{ Auth::user()->nombre }} {{ Auth::user()->apellido_paterno }} {{ Auth::user()->apellido_materno }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>CI:</strong> {{ Auth::user()->ci }}</p>
                        <p><strong>Estado:</strong> <span class="text-green-600 font-medium">{{ Auth::user()->estado }}</span></p>
                    </div>
                </div>

                <!-- Botón de logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-6">
                    @csrf
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition duration-200">
                        Cerrar Sesión
                    </button>
                </form>
            </div>
        @else
            <!-- Usuario no autenticado -->
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-700">No has iniciado sesión</h2>
                <p class="text-gray-600 mt-2">Por favor inicia sesión para acceder al sistema.</p>
                <a href="{{ route('login') }}" class="inline-block mt-4 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Ir al Login
                </a>
            </div>
        @endif
    </div>
</div>
@endsection