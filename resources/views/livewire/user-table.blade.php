<div>
    <div class="card card-outline card-dark shadow">
        <div class="card-header">
            <h3 class="card-title">Listado de Usuarios</h3>
            <div class="card-tools">
                <button type="button" wire:click="create" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </button>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr wire:key="user-{{ $user->id }}">
                            <td>{{ $user->cedula }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->telefono }}</td>
                            <td class="text-center">
                                <button wire:click="edit({{ $user->id }})" class="btn btn-info btn-xs" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                {{-- Botón que dispara el evento de SweetAlert configurado en el index --}}
                                <button type="button" 
                                    wire:click="$dispatch('swal:confirm', { 
                                        title: '¿Estás seguro?', 
                                        text: 'No podrás recuperar los datos de {{ $user->name }}', 
                                        id: {{ $user->id }} 
                                    })" 
                                    class="btn btn-danger btn-xs" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal --}}
    @if($isModalOpen)
        <div class="modal d-block" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg">
                    <div class="modal-header bg-dark">
                        <h5 class="modal-title">{{ $user_id ? 'Editar Usuario' : 'Nuevo Usuario' }}</h5>
                        <button type="button" wire:click="closeModal" class="close text-white">&times;</button>
                    </div>
                    
                    <form wire:submit.prevent="store" autocomplete="off">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Cédula</label>
                                    <input type="text" wire:model="cedula" class="form-control @error('cedula') is-invalid @enderror" autocomplete="none">
                                    @error('cedula') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Teléfono</label>
                                    <input type="text" wire:model="telefono" class="form-control" autocomplete="none">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nombre Completo</label>
                                <input type="text" wire:model="name" class="form-control @error('name') is-invalid @enderror" autocomplete="none">
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label>Correo Electrónico</label>
                                <input type="email" wire:model="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off">
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Contraseña {{ $user_id ? '(Opcional)' : '' }}</label>
                                    <input type="password" wire:model="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                                    @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Confirmar Contraseña</label>
                                    <input type="password" wire:model="password_confirmation" class="form-control" autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="store" class="spinner-border spinner-border-sm"></span>
                                Guardar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>