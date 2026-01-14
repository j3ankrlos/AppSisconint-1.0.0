<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserTable extends Component
{
    use WithPagination;

    public $name, $email, $password, $password_confirmation, $cedula, $telefono, $user_id;
    public $isModalOpen = false;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.user-table', [
            'users' => User::latest()->paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $this->resetFields();
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->cedula = $user->cedula;
        $this->telefono = $user->telefono;
        $this->openModal();
    }

    public function openModal() { $this->isModalOpen = true; }
    
    public function closeModal() { 
        $this->isModalOpen = false; 
        $this->resetFields();
    }

    private function resetFields() {
        $this->name = ''; $this->email = ''; $this->password = '';
        $this->password_confirmation = ''; $this->cedula = ''; 
        $this->telefono = ''; $this->user_id = null;
        $this->resetValidation();
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'cedula' => 'required|unique:users,cedula,' . $this->user_id,
            'password' => $this->user_id 
                ? 'nullable|confirmed|min:8' 
                : ['required', 'confirmed', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);

        User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'email' => $this->email,
            'cedula' => $this->cedula,
            'telefono' => $this->telefono,
            'password' => $this->password 
                ? Hash::make($this->password) 
                : ($this->user_id ? User::find($this->user_id)->password : Hash::make('12345678')),
        ]);

        // Lanzar alerta de éxito
        $this->dispatch('swal:modal', [
            'title' => '¡Éxito!',
            'text'  => $this->user_id ? 'Usuario actualizado correctamente' : 'Usuario creado con éxito',
            'icon'  => 'success',
        ]);

        $this->closeModal();
    }

    // Escucha el evento de confirmación desde el JS de SweetAlert
    #[On('deleteUser')] 
    public function deleteUser($id)
    {
        User::find($id)->delete();
        $this->dispatch('swal:modal', [
            'title' => 'Eliminado',
            'text'  => 'El usuario ha sido borrado del sistema.',
            'icon'  => 'success',
        ]);
    }
}