<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{  route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('propiedades') }}">Listado dePropiedades</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <br>
    <hr>
    <br>

    <flux:modal.trigger name="crear-propiedad" class="mb-4">
        <flux:button variant="primary">Crear Nueva Propiedad</flux:button>
    </flux:modal.trigger>

    <br><br>

    {{-- MODAL PARA CREAR NUEVA PROPIEDAD --}}
    <flux:modal name="crear-propiedad" class="md:w-96" style="width: 600px">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear Nueva</flux:heading>
                <flux:text class="mt-2">Llene todos los campos requeridos</flux:text>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <flux:label for="tipo">Tipo de Propiedad <b>(*)</b></flux:label>
                    <flux:input type="text" id="tipo" wire:model="tipo" required />
                    @error('tipo') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="direccion">Dirección <b>(*)</b></flux:label>
                    <flux:input type="text" id="direccion" wire:model="direccion" required />
                    @error('direccion') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="precio">Precio <b>(*)</b></flux:label>
                    <flux:input type="number" id="precio" wire:model="precio" required />
                    @error('precio') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="descripcion">Descripción <b>(*)</b></flux:label>
                    <flux:textarea id="descripcion" wire:model="descripcion" rows="3"></flux:textarea>
                    @error('descripcion') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <div>
                    <flux:label for="estado">Estado <b>(*)</b></flux:label>
                    <flux:select id="estado" wire:model="estado">
                        <option value="">Seleccione un estado</option>
                        <option value="Disponible">Disponible</option>
                        <option value="Alquilado">Alquilado</option>
                        <option value="Mantenimiento">Mantenimiento</option>
                    </flux:select>
                    @error('estado') <span class="text-red-500">{{ $message }}</span> @enderror
                </div>

                <br><br>

                <div class="flex justify-end">
                    <flux:modal.close name="crear-propiedad" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Crear Propiedad</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    @if (session('message'))
        <div x-data x-init="
            Swal.fire({
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 2000
            })
        ">
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-black border border-b divide-y divide-gray-200" style="width: 100%">
            <thead class="border-b bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <th class="py-3 px-4" style="background-color: #f0f0f0">Nro</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Tipo</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Dirección</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Precio</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Estado</th>
                <th class="py-3 px-4" style="background-color: #f0f0f0">Acciones</th>
            </thead>
            <tbody>
                @foreach ($propiedades as $propiedad )
                    <tr style="border: 1px solid #f0f0f0">
                        <td class="py-3 px-4" style="text-align: center">{{ $propiedad->id }}</td>
                        <td>{{ $propiedad->tipo }}</td>
                        <td>{{ $propiedad->direccion }}</td>
                        <td>{{ $propiedad->precio }}</td>
                        <td>{{ $propiedad->estado }}</td>
                        <td>
                            <flux:button wire:click="show({{ $propiedad->id }})">Ver</flux:button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $propiedades->links() }}
        </div>

    </div>

    {{-- MODAL PARA LA VISTA SHOW PROPIEDAD --}}
    <flux:modal name="show-propiedad" class="md:w-96" style="width: 600px" wire:model="showModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Detalles de la Propiedad</flux:heading>
            </div>

            @if ($propiedadSeleccionada)
                <div class="space-y-4">
                    <div>
                        <flux:label for="tipo">Tipo de Propiedad </flux:label>
                        <flux:text>{{ $propiedadSeleccionada->tipo }}</flux:text>
                    </div>

                    <div>
                        <flux:label for="direccion">Dirección </flux:label>
                        <flux:text>{{ $propiedadSeleccionada->direccion }}</flux:text>
                    </div>

                    <div>
                        <flux:label for="precio">Precio </flux:label>
                        <flux:text>{{ $propiedadSeleccionada->precio }}</flux:text>
                    </div>

                    <div>
                        <flux:label for="descripcion">Descripción </flux:label>
                        <flux:text>{{ $propiedadSeleccionada->descripcion }}</flux:text>
                    </div>

                    <div>
                        <flux:label for="estado">Estado </flux:label>
                        <flux:text>{{ $propiedadSeleccionada->estado }}</flux:text>
                    </div>

                    <br><br>

                    <div class="flex justify-end">
                        <flux:modal.close name="show-propiedad" class="mr-2">
                            <flux:button type="button" variant="filled">Cerrar</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            @endif
            
        </div>
    </flux:modal>

</div>
