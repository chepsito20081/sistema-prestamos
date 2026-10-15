<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Equipos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 space-y-6">

                <!-- Barra superior: Botón y Buscador alineados -->
                <div class="flex flex-wrap items-center justify-between gap-4">
                    
                    <!-- Botón Registrar (Solo Encargado) -->
                    @if(Auth::user()->role === 'admin')
                        <div>
                            <a href="{{ route('equipos.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                + Registrar Nuevo Equipo
                            </a>
                        </div>
                    @else
                        <div></div>
                    @endif

                    <!-- Formulario de Búsqueda y Filtros -->
                    <form method="GET" action="{{ route('equipos.index') }}" class="flex items-center gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar nombre o código..." class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3">

                        <select name="estado" class="border-gray-300 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 py-1.5 px-3 bg-white">
                            <option value="">Todos</option>
                            <option value="disponible" {{ request('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="prestado" {{ request('estado') == 'prestado' ? 'selected' : '' }}>Prestado</option>
                            <option value="mantenimiento" {{ request('estado') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        </select>

                        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm font-semibold rounded-lg transition">
                            Filtrar
                        </button>

                        @if(request('search') || request('estado'))
                            <a href="{{ route('equipos.index') }}" class="text-xs text-indigo-600 hover:text-indigo-800 underline">
                                Limpiar
                            </a>
                        @endif
                    </form>

                </div>

                <!-- Mensaje de Éxito -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-sm" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Tabla de Equipos -->
                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @forelse ($equipos as $equipo)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $equipo->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-mono text-xs">{{ $equipo->codigo_inventario }}</td>
                                    
                                    <!-- Badges de Estado -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $equipo->estado == 'disponible' ? 'bg-green-100 text-green-800 border border-green-200' : '' }}
                                            {{ $equipo->estado == 'prestado' ? 'bg-yellow-100 text-yellow-800 border border-yellow-200' : '' }}
                                            {{ $equipo->estado == 'mantenimiento' ? 'bg-red-100 text-red-800 border border-red-200' : '' }}">
                                            <span class="w-2 h-2 mr-1.5 my-auto rounded-full 
                                                {{ $equipo->estado == 'disponible' ? 'bg-green-500' : '' }}
                                                {{ $equipo->estado == 'prestado' ? 'bg-yellow-500' : '' }}
                                                {{ $equipo->estado == 'mantenimiento' ? 'bg-red-500' : '' }}"></span>
                                            {{ ucfirst($equipo->estado) }}
                                        </span>
                                    </td>

                                    <!-- Acciones por Rol -->
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('equipos.edit', $equipo->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-semibold">Editar</a>
                                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este equipo?')" class="text-red-600 hover:text-red-900 font-semibold">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs italic">Solo lectura</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-6 text-center text-gray-500 italic">
                                        No se encontraron equipos registrados o que coincidan con la búsqueda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación Laravel -->
                <div class="mt-4">
                    {{ $equipos->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>