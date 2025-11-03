<div>
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}">Inicio</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('inquilinos') }}">Listado de Inquilinos</flux:breadcrumbs.item>
    </flux:breadcrumbs>
    <br><br>
    <hr>
    <br>
    <flux:button variant="primary" wire:click="openCreateModal" color="blue">Crear Nuevo Inquilino</flux:button>
    <br><br>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-black border border-b divide-y divide-gray-200" style="width: 100%">
            <thead class="border-b bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <th class="py-3 px-4" style="background-color: #f0f0f0">Nro</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Nombres</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Email</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Teléfono</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Fecha de Nacimiento</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Documento de Identidad</th>
            <th class="py-3 px-4" style="background-color: #f0f0f0">Acciones</th>
            </thead>
            <tbody>
            @foreach ($inquilinos as $inquilino )
                <tr style="border: 1px solid f0f0f0">
                    <td class="py-3 px-4" style="text-align: center">{{$inquilino->id}}</td>
                    <td>{{$inquilino->nombres}}</td>
                    <td>{{$inquilino->email}}</td>
                    <td>{{$inquilino->telefono}}</td>
                    <td style="text-align: center">{{$inquilino->fecha_nacimiento}}</td>
                    <td style="text-align: center">{{$inquilino->documento_identidad}}</td>
                    <td style="text-align: center">
                        <flux:button variant="primary" color="teal" wire:click="show({{$inquilino->id}})">Ver</flux:button>
                        <flux:button variant="primary" color="green" wire:click="edit({{$inquilino->id}})">Editar</flux:button>
                        <flux:button variant="primary" color="red" wire:click="confirmDelete({{ $inquilino->id }})">Eliminar</flux:button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $inquilinos->links() }}
        </div>
    </div>

    {{-- MODAL PARA LA VISTA CREAR INQUILINOS --}}
    <flux:modal name="create-inquilino" class="md:w-96" style="width: 600px" wire:model="createModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Crear Nuevo</flux:heading>
                <flux:text class="mt-2">Llene todos los campos requeridos</flux:text>
            </div>
            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <flux:label for="nombres">Nombres <b>(*)</b></flux:label>
                    <flux:input type="text" id="nombres" wire:model="nombres" required />
                    @error('nombres') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="email">Email <b>(*)</b></flux:label>
                    <flux:input type="email" id="email" wire:model="email" required />
                    @error('email') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="telefono">Telefono <b>(*)</b></flux:label>
                    <flux:input type="text" id="telefono" wire:model="telefono" required />
                    @error('telefono') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="fecha_nacimiento">Fecha de Nacimiento <b>(*)</b></flux:label>
                    <flux:input type="date" id="fecha_nacimiento" wire:model="fecha_nacimiento" required />
                    @error('fecha_nacimiento') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="documento_identidad">Documento de Identidad <b>(*)</b></flux:label>
                    <flux:input type="text" id="documento_identidad" wire:model="documento_identidad" required />
                    @error('documento_identidad') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <br><br>
                <div class="flex justify-end">
                    <flux:modal.close name="crear-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Crear Inquilino</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- MODAL PARA LA VISTA SHOW INQUILINOS --}}
    <flux:modal name="show-inquilino" class="md:w-96" style="width: 600px" wire:model="showModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Datos del Inquilino</flux:heading>
            </div>
            @if ($inquilinoSeleccionado)
                <div class="space-y-4">
                    <div>
                        <flux:label for="nombres">Nombres </flux:label>
                        {{--<p>{{$inquilinoSeleccionado->nombres}}</p>--}}
                        <flux:text>{{$inquilinoSeleccionado->nombres}}</flux:text>
                    </div>
                    <div>
                        <flux:label for="email">Email </flux:label>
                        {{--<p>{{$inquilinoSeleccionado->email}}</p>--}}
                        <flux:text>{{$inquilinoSeleccionado->email}}</flux:text>
                    </div>
                    <div>
                        <flux:label for="telefono">Teléfono </flux:label>
                        {{--<p>{{$inquilinoSeleccionado->telefono}}</p>--}}
                        <flux:text>{{$inquilinoSeleccionado->telefono}}</flux:text>
                    </div>
                    <div>
                        <flux:label for="fecha_nacimiento">Fecha Nacimiento </flux:label>
                        {{--<p>{{$inquilinoSeleccionado->fecha_nacimiento}}</p>--}}
                        <flux:text>{{$inquilinoSeleccionado->fecha_nacimiento}}</flux:text>
                    </div>
                    <div>
                        <flux:label for="documento_identidad">Documento de Identidad </flux:label>
                        {{--<p>{{$inquilinoSeleccionado->documento_identidad}}</p>--}}
                        <flux:text>{{$inquilinoSeleccionado->documento_identidad}}</flux:text>
                    </div>
                    <br><br>
                    <div class="flex justify-end">
                        <flux:modal.close name="show-inquilino" class="mr-2">
                            <flux:button type="button" variant="filled">Volver</flux:button>
                        </flux:modal.close>
                    </div>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- MODAL PARA LA VISTA EDITAR INQUILINOS --}}
    <flux:modal name="edit-inquilino" class="md:w-96" style="width: 600px" wire:model="editModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Editar Datos del Inquilino</flux:heading>
                <flux:text class="mt-2">Llene todos los campos requeridos</flux:text>
            </div>
            <form wire:submit.prevent="update" class="space-y-4">
                <div>
                    <flux:label for="nombres">Nombres <b>(*)</b></flux:label>
                    <flux:input type="text" id="nombres" wire:model="editNombres" required />
                    @error('nombres') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="email">Email <b>(*) </b></flux:label>
                    <flux:input type="email" id="email" wire:model="editEmail" required />
                    @error('email') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="telefono">Telefono <b>(*) </b></flux:label>
                    <flux:input type="text" id="telefono" wire:model="editTelefono" required />
                    @error('telefono') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="fecha_nacimiento">Fecha de Nacimiento <b>(*)</b></flux:label>
                    <flux:input type="date" id="fecha_nacimiento" wire:model="editFechaNacimiento" required />
                    @error('fecha_nacimiento') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <div>
                    <flux:label for="documento_identidad">Documento de Identidad <b>(*)</b></flux:label>
                    <flux:input type="text" id="documento_identidad" wire:model="editDocumentoIdentidad" required />
                    @error('documento_identidad') <span class="text-red-500">{{$message}}</span> @enderror
                </div>
                <br><br>
                <div class="flex justify-end">
                    <flux:modal.close name="edit-inquilino" class="mr-2">
                        <flux:button type="button" variant="filled">Cerrar</flux:button>
                    </flux:modal.close>
                    <flux:button type="submit" variant="primary">Actualizar Inquilino</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- MODAL PARA LA CONFIRMACION DE BORRADO DE PROPIEDAD --}}
    <flux:modal name="delete-inquilino" class="min-w-[22rem]" wire:model="deleteModal">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">¿Eliminar Registro?</flux:heading>
                <flux:text class="mt-2">
                    <p>Estas a punto de Eliminar este Inquilino</p>
                    <p>Esta Acción no se puede Deshacer</p>
                </flux:text>
            </div>
            <div class="flex gap-2">
                <flux:spacer />
                <flux:modal.close name="delete-inquilino" class="mr-2">
                    <flux:button type="button" variant="filled">Cerrar</flux:button>
                </flux:modal.close>
                <flux:button type="submit" wire:click="delete" variant="danger">Eliminar Registro</flux:button>
            </div>
        </div>
    </flux:modal>

    @if (session('message'))
        <div x-data x-init="
            Swal.fire({
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 2000
            })">
        </div>
    @endif

</div>
