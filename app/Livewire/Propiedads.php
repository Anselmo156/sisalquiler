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

    // CAMPOS DEL FORMULARIO
    public $tipo;
    public $direccion;
    public $precio;
    public $descripcion;
    public $estado = 'Disponible';

    public $showModal = false;
    public $propiedadSeleccionada;

    // REGLAS DE VALIDACION
    protected $rules = [
        'tipo' => 'required|string|max:255',
        'direccion' => 'required|string|max:255',
        'precio' => 'required|numeric|min:0',
        'descripcion' => 'required|string|max:1000',
        'estado' => 'required|in:Disponible, Alquilado, Mantenimiento',
    ];

    //RESETEAR LOS CAMPOS DEL FORMULARIO
    public function resetForm()
    {
        $this->tipo = '';
        $this->direccion = '';
        $this->precio = '';
        $this->descripcion = '';
        $this->estado = '';
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
        $this->resetForm();
        Flux::modal('crear-propiedad')->close();
        session()->flash('message', 'Propiedad creada exitosamente.');
    }

    public function show($id)
    {
        $this->propiedadSeleccionada = Propiedad::find($id);
        $this->showModal = true;
    }

    public function render()
    {
        $propiedades = Propiedad::paginate(10);
        return view('livewire.propiedads', compact('propiedades'));
    }
}
