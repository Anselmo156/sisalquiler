<?php

namespace App\Livewire;

use App\Models\Inquilino;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Inquilinos extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // CAMPOS DEL FORMULARIO DE CREACION
    public $nombres;
    public $email;
    public $telefono;
    public $fecha_nacimiento;
    public $documento_identidad;

    // CAMPOS DEL FORMULARIO DE EDICION
    public $editNombres;
    public $editEmail;
    public $editTelefono;
    public $editFechaNacimiento;
    public $editDocumentoIdentidad;

    // CONTROL DE MODALES
    public $createModal = false;
    public $showModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $inquilinoSeleccionado;
    public $inquilinoEditando;
    public $inquilinoEliminar;

    // REGLAS DE VALIDACION
    protected $rules = [
        'nombres' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:inquilinos,email',
        'telefono' => 'required|string|max:20',
        'fecha_nacimiento' => 'required|date',
        'documento_identidad' => 'required|string|max:20|unique:inquilinos,documento_identidad',
    ];

    // RESETEAR LOS CAMPOS DEL FORMULARIO DE CREACION
    public function resetCreateForm()
    {
        $this->reset(['nombres', 'email', 'telefono', 'fecha_nacimiento', 'documento_identidad']);
        $this->resetErrorBag();
    }

    // RESETEAR LOS CAMPOS DEL FORMULARIO DE EDICION
    public function resetEditForm()
    {
        $this->reset(['editNombres', 'editEmail', 'editTelefono', 'editFechaNacimiento', 'editDocumentoIdentidad', 'inquilinoEditando']);
        $this->resetErrorBag();
    }

    // ABRIR MODAL DE CREACION
    public function openCreateModal()
    {
        $this->resetCreateForm();
        $this->createModal = true;
    }

    // GUARDAR NUEVO INQUILINO
    public function save()
    {
        $this->validate();
        Inquilino::create([
            'nombres' => $this->nombres,
            'email' => $this->email,
            'telefono' => $this->telefono,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'documento_identidad' => $this->documento_identidad,
        ]);

        $this->resetCreateForm();
        $this->createModal = false;
        session()->flash('message', 'Inquilino creado exitosamente.');
    }

    // MOSTRAR DETALLES DEL INQUILINO
    public function show($id)
    {
        $this->inquilinoSeleccionado = Inquilino::findOrFail($id);
        $this->showModal = true;
    }

    // MOSTRAR DETALLES DEL INQUILINO EN EL MODAL DE EDICION
    public function edit($id)
    {
        $this->inquilinoEditando = Inquilino::findOrFail($id);
        $this->editNombres = $this->inquilinoEditando->nombres;
        $this->editEmail = $this->inquilinoEditando->email;
        $this->editTelefono = $this->inquilinoEditando->telefono;
        $this->editFechaNacimiento = $this->inquilinoEditando->fecha_nacimiento;
        $this->editDocumentoIdentidad = $this->inquilinoEditando->documento_identidad;

        $this->editModal = true;
    }

    // ACTUALIZAR INQUILINO
    public function update()
    {
        $this->validate([
            'editNombres' => 'required|string|max:255',
            'editEmail' => 'required|email|max:255|unique:inquilinos,email,' . $this->inquilinoEditando->id,
            'editTelefono' => 'required|string|max:20',
            'editFechaNacimiento' => 'required|date',
            'editDocumentoIdentidad' => 'required|string|max:20|unique:inquilinos,documento_identidad,' . $this->inquilinoEditando->id,
        ]);

        $this->inquilinoEditando->update([
            'nombres' => $this->editNombres,
            'email' => $this->editEmail,
            'telefono' => $this->editTelefono,
            'fecha_nacimiento' => $this->editFechaNacimiento,
            'documento_identidad' => $this->editDocumentoIdentidad,
        ]);

        $this->resetEditForm();
        $this->editModal = false;
        session()->flash('message', 'Inquilino actualizado exitosamente.');
    }

    // CONFIRMAR ELIMINACION DE INQUILINO
    public function confirmDelete($id)
    {
        $this->inquilinoEliminar = Inquilino::findOrFail($id);
        $this->deleteModal = true;
    }

    // ELIMINAR INQUILINO
    public function delete()
    {
        $inquilino = Inquilino::findOrFail($this->inquilinoEliminar->id);
        $inquilino->delete();

        $this->deleteModal = false;
        $this->inquilinoEliminar = null;
        session()->flash('message', 'Inquilino eliminado exitosamente.');

        $inquilinos = Inquilino::paginate(10);
        if ($inquilinos->isEmpty() && $this->page > 1) {
            $this->previousPage();
        }
    }

    public function render()
    {
        $inquilinos = Inquilino::paginate(10);
        return view('livewire.inquilinos', compact('inquilinos'));
    }
}
