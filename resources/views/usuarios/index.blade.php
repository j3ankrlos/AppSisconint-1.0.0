@extends('adminlte::page')

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
    @livewire('user-table')
@stop

@push('css')
<style>
    /* Estilos para el modal manual de Livewire */
    .modal { 
        display: block; 
        background-color: rgba(0,0,0,0.5); 
        z-index: 1060 !important; 
    }
</style>
@endpush

@push('js')
    {{-- CDN de SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        /**
         * Escuchador de eventos de Livewire 3
         */
        document.addEventListener('livewire:init', () => {
            
            // 1. Escuchar mensajes de éxito/error (Flash alternativo)
            Livewire.on('swal:modal', (event) => {
                Swal.fire({
                    title: event[0].title,
                    text: event[0].text,
                    icon: event[0].icon, // success, error, warning, info
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Aceptar'
                });
            });

            // 2. Escuchar confirmación de eliminación
            Livewire.on('swal:confirm', (event) => {
                Swal.fire({
                    title: event[0].title,
                    text: event[0].text,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Llamamos al método 'delete' en el componente PHP
                        Livewire.dispatch('deleteUser', { id: event[0].id });
                    }
                });
            });
        });
    </script>
@endpush