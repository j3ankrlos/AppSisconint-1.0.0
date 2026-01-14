@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Bienvenido a Sisconint</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Información del Usuario</h3>
                </div>
                <div class="card-body">
                    <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Cédula:</strong> {{ Auth::user()->cedula ?? 'No asignada' }}</p>
                    <p><strong>Teléfono:</strong> {{ Auth::user()->telefono ?? 'No asignado' }}</p>
                </div>
            </div>
        </div>
    </div>
@stop
