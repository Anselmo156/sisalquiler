<?php

namespace App\Livewire;

use App\Models\Propiedad;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class Propiedads extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // CAMPOS DEL FORMULARIO DE CREACION
    public $tipo;
    public $direccion;
    public $precio;
    public $descripcion;
    public $estado = 'Disponible';

    // CAMPOS DEL FORMULARIO DE EDICION
    public $editTipo;
    public $editDireccion;
    public $editPrecio;
    public $editDescripcion;
    public $editEstado;

    // CONTROL DE MODALES
    public $createModal = false;
    public $showModal = false;
    public $editModal = false;
    public $deleteModal = false;
    public $propiedadSeleccionada;
    public $propiedadEditando;
    public $propiedadEliminar;

    // REGLAS DE VALIDACION
    protected $rules = [
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string|max:1000',
        'estado' => 'required|in:Disponible, Alquilado, Mantenimiento',
    ];

    // RESETEAR LOS CAMPOS DEL FORMULARIO DE CREACION
    public function resetCreateForm()
    {
        $this->reset(['tipo', 'direccion', 'precio', 'descripcion', 'estado']);
        $this->resetErrorBag();
    }

    // RESETEAR LOS CAMPOS DEL FORMULARIO DE EDICION
    public function resetEditForm()
    {
        $this->reset(['editTipo', 'editDireccion', 'editPrecio', 'editDescripcion', 'editEstado', 'propiedadEditando']);
        $this->resetErrorBag();
    }

    // ABRIR MODAL DE CREACION
    public function openCreateModal()
    {
        $this->resetCreateForm();
        // Flux::modal('crear-propiedad')->open();
        $this->createModal = true;
    }

    // GUARDAR NUEVA PROPIEDAD
    public function save()
    {
        $this->validate();

        Propiedad::create([
            'tipo' => $this->tipo,
            'direccion' => $this->direccion,
            'precio' => $this->precio,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
        ]);

        $this->resetCreateForm();
        Flux::modal('crear-propiedad')->close();
        $this->createModal = false;
        session()->flash('message', 'Propiedad creada exitosamente.');
    }

    public function show($id)
    {
        $this->propiedadSeleccionada = Propiedad::find($id);
        $this->showModal = true;
    }

    public function edit($id)
    {
        $this->propiedadEditando = Propiedad::find($id);
        $this->editTipo = $this->propiedadEditando->tipo;
        $this->editDireccion = $this->propiedadEditando->direccion;
        $this->editPrecio = $this->propiedadEditando->precio;
        $this->editDescripcion = $this->propiedadEditando->descripcion;
        $this->editEstado = $this->propiedadEditando->estado;

        // Flux::modal('editar-propiedad')->open();
        $this->editModal = true;
    }

    public function update()
    {
        $this->validate([
            'editTipo' => 'required|string|max:255',
            'editDireccion' => 'required|string|max:255',
            'editPrecio' => 'required|numeric|min:0',
            'editDescripcion' => 'required|string|max:1000',
            'editEstado' => 'required|in:Disponible,Alquilado,Mantenimiento',
        ]);

        $this->propiedadEditando->update([
            'tipo' => $this->editTipo,
            'direccion' => $this->editDireccion,
            'precio' => $this->editPrecio,
            'descripcion' => $this->editDescripcion,
            'estado' => $this->editEstado,
        ]);

        $this->resetEditForm();
        // Flux::modal('editar-propiedad')->close();
        $this->editModal = false;
        session()->flash('message', 'Propiedad actualizada exitosamente.');
    }

    public function confirmDelete($id)
    {
        $this->propiedadEliminar = Propiedad::find($id);
        $this->deleteModal = true;
    }

    public function delete()
    {
        $propiedad = Propiedad::find($this->propiedadEliminar->id);
        $propiedad->delete();
        $this->deleteModal = false;
        $this->propiedadEliminar = null;
        session()->flash('message', 'Propiedad eliminada exitosamente.');

        $propiedades = Propiedad::paginate(10);
        if ($propiedades->isEmpty() && $this->page > 1) {
            $this->previousPage();
        }
    }

    public function render()
    {
        $propiedades = Propiedad::paginate(10);
        return view('livewire.propiedads', compact('propiedades'));
    }
}
