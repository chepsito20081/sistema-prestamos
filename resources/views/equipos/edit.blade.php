<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Equipo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('equipos.update', $equipo->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del Equipo:</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $equipo->nombre) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Código de Inventario:</label>
                        <input type="text" name="codigo_inventario" value="{{ old('codigo_inventario', $equipo->codigo_inventario) }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('codigo_inventario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción:</label>
                        <textarea name="descripcion" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ old('descripcion', $equipo->descripcion) }}</textarea>
                        @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
                        <select name="estado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="disponible" {{ old('estado', $equipo->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="prestado" {{ old('estado', $equipo->estado) == 'prestado' ? 'selected' : '' }}>Prestado</option>
                            <option value="mantenimiento" {{ old('estado', $equipo->estado) == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        </select>
                        @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Actualizar Equipo
                        </button>
                        <a href="{{ route('equipos.index') }}" class="text-gray-600 hover:text-gray-900">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>